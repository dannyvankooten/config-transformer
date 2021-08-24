<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202108242\Symfony\Component\Cache\Adapter;

use ConfigTransformer202108242\Predis\Connection\Aggregate\ClusterInterface;
use ConfigTransformer202108242\Predis\Connection\Aggregate\PredisCluster;
use ConfigTransformer202108242\Predis\Connection\Aggregate\ReplicationInterface;
use ConfigTransformer202108242\Predis\Response\Status;
use ConfigTransformer202108242\Symfony\Component\Cache\Exception\InvalidArgumentException;
use ConfigTransformer202108242\Symfony\Component\Cache\Exception\LogicException;
use ConfigTransformer202108242\Symfony\Component\Cache\Marshaller\DeflateMarshaller;
use ConfigTransformer202108242\Symfony\Component\Cache\Marshaller\MarshallerInterface;
use ConfigTransformer202108242\Symfony\Component\Cache\Marshaller\TagAwareMarshaller;
use ConfigTransformer202108242\Symfony\Component\Cache\Traits\RedisClusterProxy;
use ConfigTransformer202108242\Symfony\Component\Cache\Traits\RedisProxy;
use ConfigTransformer202108242\Symfony\Component\Cache\Traits\RedisTrait;
/**
 * Stores tag id <> cache id relationship as a Redis Set.
 *
 * Set (tag relation info) is stored without expiry (non-volatile), while cache always gets an expiry (volatile) even
 * if not set by caller. Thus if you configure redis with the right eviction policy you can be safe this tag <> cache
 * relationship survives eviction (cache cleanup when Redis runs out of memory).
 *
 * Redis server 2.8+ with any `volatile-*` eviction policy, OR `noeviction` if you're sure memory will NEVER fill up
 *
 * Design limitations:
 *  - Max 4 billion cache keys per cache tag as limited by Redis Set datatype.
 *    E.g. If you use a "all" items tag for expiry instead of clear(), that limits you to 4 billion cache items also.
 *
 * @see https://redis.io/topics/lru-cache#eviction-policies Documentation for Redis eviction policies.
 * @see https://redis.io/topics/data-types#sets Documentation for Redis Set datatype.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 * @author André Rømcke <andre.romcke+symfony@gmail.com>
 */
class RedisTagAwareAdapter extends \ConfigTransformer202108242\Symfony\Component\Cache\Adapter\AbstractTagAwareAdapter
{
    use RedisTrait;
    /**
     * On cache items without a lifetime set, we set it to 100 days. This is to make sure cache items are
     * preferred to be evicted over tag Sets, if eviction policy is configured according to requirements.
     */
    private const DEFAULT_CACHE_TTL = 8640000;
    /**
     * @var string|null detected eviction policy used on Redis server
     */
    private $redisEvictionPolicy;
    /**
     * @param \Redis|\RedisArray|\RedisCluster|\Predis\ClientInterface|RedisProxy|RedisClusterProxy $redis           The redis client
     * @param string                                                                                $namespace       The default namespace
     * @param int                                                                                   $defaultLifetime The default lifetime
     */
    public function __construct($redis, string $namespace = '', int $defaultLifetime = 0, \ConfigTransformer202108242\Symfony\Component\Cache\Marshaller\MarshallerInterface $marshaller = null)
    {
        if ($redis instanceof \ConfigTransformer202108242\Predis\ClientInterface && $redis->getConnection() instanceof \ConfigTransformer202108242\Predis\Connection\Aggregate\ClusterInterface && !$redis->getConnection() instanceof \ConfigTransformer202108242\Predis\Connection\Aggregate\PredisCluster) {
            throw new \ConfigTransformer202108242\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('Unsupported Predis cluster connection: only "%s" is, "%s" given.', \ConfigTransformer202108242\Predis\Connection\Aggregate\PredisCluster::class, \get_debug_type($redis->getConnection())));
        }
        if (\defined('Redis::OPT_COMPRESSION') && ($redis instanceof \Redis || $redis instanceof \RedisArray || $redis instanceof \RedisCluster)) {
            $compression = $redis->getOption(\Redis::OPT_COMPRESSION);
            foreach (\is_array($compression) ? $compression : [$compression] as $c) {
                if (\Redis::COMPRESSION_NONE !== $c) {
                    throw new \ConfigTransformer202108242\Symfony\Component\Cache\Exception\InvalidArgumentException(\sprintf('phpredis compression must be disabled when using "%s", use "%s" instead.', static::class, \ConfigTransformer202108242\Symfony\Component\Cache\Marshaller\DeflateMarshaller::class));
                }
            }
        }
        $this->init($redis, $namespace, $defaultLifetime, new \ConfigTransformer202108242\Symfony\Component\Cache\Marshaller\TagAwareMarshaller($marshaller));
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $values
     * @param int $lifetime
     * @param mixed[] $addTagData
     * @param mixed[] $delTagData
     */
    protected function doSave($values, $lifetime, $addTagData = [], $delTagData = []) : array
    {
        $eviction = $this->getRedisEvictionPolicy();
        if ('noeviction' !== $eviction && \strncmp($eviction, 'volatile-', \strlen('volatile-')) !== 0) {
            throw new \ConfigTransformer202108242\Symfony\Component\Cache\Exception\LogicException(\sprintf('Redis maxmemory-policy setting "%s" is *not* supported by RedisTagAwareAdapter, use "noeviction" or "volatile-*" eviction policies.', $eviction));
        }
        // serialize values
        if (!($serialized = $this->marshaller->marshall($values, $failed))) {
            return $failed;
        }
        // While pipeline isn't supported on RedisCluster, other setups will at least benefit from doing this in one op
        $results = $this->pipeline(static function () use($serialized, $lifetime, $addTagData, $delTagData, $failed) {
            // Store cache items, force a ttl if none is set, as there is no MSETEX we need to set each one
            foreach ($serialized as $id => $value) {
                (yield 'setEx' => [$id, 0 >= $lifetime ? self::DEFAULT_CACHE_TTL : $lifetime, $value]);
            }
            // Add and Remove Tags
            foreach ($addTagData as $tagId => $ids) {
                if (!$failed || ($ids = \array_diff($ids, $failed))) {
                    (yield 'sAdd' => \array_merge([$tagId], $ids));
                }
            }
            foreach ($delTagData as $tagId => $ids) {
                if (!$failed || ($ids = \array_diff($ids, $failed))) {
                    (yield 'sRem' => \array_merge([$tagId], $ids));
                }
            }
        });
        foreach ($results as $id => $result) {
            // Skip results of SADD/SREM operations, they'll be 1 or 0 depending on if set value already existed or not
            if (\is_numeric($result)) {
                continue;
            }
            // setEx results
            if (\true !== $result && (!$result instanceof \ConfigTransformer202108242\Predis\Response\Status || \ConfigTransformer202108242\Predis\Response\Status::get('OK') !== $result)) {
                $failed[] = $id;
            }
        }
        return $failed;
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $ids
     */
    protected function doDeleteYieldTags($ids) : iterable
    {
        $lua = <<<'EOLUA'
            local v = redis.call('GET', KEYS[1])
            local e = redis.pcall('UNLINK', KEYS[1])

            if type(e) ~= 'number' then
                redis.call('DEL', KEYS[1])
            end

            if not v or v:len() <= 13 or v:byte(1) ~= 0x9D or v:byte(6) ~= 0 or v:byte(10) ~= 0x5F then
                return ''
            end

            return v:sub(14, 13 + v:byte(13) + v:byte(12) * 256 + v:byte(11) * 65536)
EOLUA;
        $results = $this->pipeline(function () use($ids, $lua) {
            foreach ($ids as $id) {
                (yield 'eval' => $this->redis instanceof \ConfigTransformer202108242\Predis\ClientInterface ? [$lua, 1, $id] : [$lua, [$id], 1]);
            }
        });
        foreach ($results as $id => $result) {
            try {
                (yield $id => !\is_string($result) || '' === $result ? [] : $this->marshaller->unmarshall($result));
            } catch (\Exception $e) {
                (yield $id => []);
            }
        }
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $tagData
     */
    protected function doDeleteTagRelations($tagData) : bool
    {
        $results = $this->pipeline(static function () use($tagData) {
            foreach ($tagData as $tagId => $idList) {
                \array_unshift($idList, $tagId);
                (yield 'sRem' => $idList);
            }
        });
        foreach ($results as $result) {
            // no-op
        }
        return \true;
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $tagIds
     */
    protected function doInvalidate($tagIds) : bool
    {
        // This script scans the set of items linked to tag: it empties the set
        // and removes the linked items. When the set is still not empty after
        // the scan, it means we're in cluster mode and that the linked items
        // are on other nodes: we move the links to a temporary set and we
        // gargage collect that set from the client side.
        $lua = <<<'EOLUA'
            local cursor = '0'
            local id = KEYS[1]
            repeat
                local result = redis.call('SSCAN', id, cursor, 'COUNT', 5000);
                cursor = result[1];
                local rems = {}

                for _, v in ipairs(result[2]) do
                    local ok, _ = pcall(redis.call, 'DEL', ARGV[1]..v)
                    if ok then
                        table.insert(rems, v)
                    end
                end
                if 0 < #rems then
                    redis.call('SREM', id, unpack(rems))
                end
            until '0' == cursor;

            redis.call('SUNIONSTORE', '{'..id..'}'..id, id)
            redis.call('DEL', id)

            return redis.call('SSCAN', '{'..id..'}'..id, '0', 'COUNT', 5000)
EOLUA;
        $results = $this->pipeline(function () use($tagIds, $lua) {
            if ($this->redis instanceof \ConfigTransformer202108242\Predis\ClientInterface) {
                $prefix = $this->redis->getOptions()->prefix ? $this->redis->getOptions()->prefix->getPrefix() : '';
            } elseif (\is_array($prefix = $this->redis->getOption(\Redis::OPT_PREFIX) ?? '')) {
                $prefix = \current($prefix);
            }
            foreach ($tagIds as $id) {
                (yield 'eval' => $this->redis instanceof \ConfigTransformer202108242\Predis\ClientInterface ? [$lua, 1, $id, $prefix] : [$lua, [$id, $prefix], 1]);
            }
        });
        $lua = <<<'EOLUA'
            local id = KEYS[1]
            local cursor = table.remove(ARGV)
            redis.call('SREM', '{'..id..'}'..id, unpack(ARGV))

            return redis.call('SSCAN', '{'..id..'}'..id, cursor, 'COUNT', 5000)
EOLUA;
        foreach ($results as $id => [$cursor, $ids]) {
            while ($ids || '0' !== $cursor) {
                $this->doDelete($ids);
                $evalArgs = [$id, $cursor];
                \array_splice($evalArgs, 1, 0, $ids);
                if ($this->redis instanceof \ConfigTransformer202108242\Predis\ClientInterface) {
                    \array_unshift($evalArgs, $lua, 1);
                } else {
                    $evalArgs = [$lua, $evalArgs, 1];
                }
                $results = $this->pipeline(function () use($evalArgs) {
                    (yield 'eval' => $evalArgs);
                });
                foreach ($results as [$cursor, $ids]) {
                    // no-op
                }
            }
        }
        return \true;
    }
    private function getRedisEvictionPolicy() : string
    {
        if (null !== $this->redisEvictionPolicy) {
            return $this->redisEvictionPolicy;
        }
        $hosts = $this->getHosts();
        $host = \reset($hosts);
        if ($host instanceof \ConfigTransformer202108242\Predis\Client && $host->getConnection() instanceof \ConfigTransformer202108242\Predis\Connection\Aggregate\ReplicationInterface) {
            // Predis supports info command only on the master in replication environments
            $hosts = [$host->getClientFor('master')];
        }
        foreach ($hosts as $host) {
            $info = $host->info('Memory');
            $info = $info['Memory'] ?? $info;
            return $this->redisEvictionPolicy = $info['maxmemory_policy'];
        }
        return $this->redisEvictionPolicy = '';
    }
}
