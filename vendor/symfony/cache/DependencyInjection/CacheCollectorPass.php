<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202205131\Symfony\Component\Cache\DependencyInjection;

use ConfigTransformer202205131\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface;
use ConfigTransformer202205131\Symfony\Component\Cache\Adapter\TraceableAdapter;
use ConfigTransformer202205131\Symfony\Component\Cache\Adapter\TraceableTagAwareAdapter;
use ConfigTransformer202205131\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer202205131\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202205131\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformer202205131\Symfony\Component\DependencyInjection\Reference;
/**
 * Inject a data collector to all the cache services to be able to get detailed statistics.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class CacheCollectorPass implements \ConfigTransformer202205131\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(\ConfigTransformer202205131\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        if (!$container->hasDefinition('data_collector.cache')) {
            return;
        }
        foreach ($container->findTaggedServiceIds('cache.pool') as $id => $attributes) {
            $poolName = $attributes[0]['name'] ?? $id;
            $this->addToCollector($id, $poolName, $container);
        }
    }
    private function addToCollector(string $id, string $name, \ConfigTransformer202205131\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        $definition = $container->getDefinition($id);
        if ($definition->isAbstract()) {
            return;
        }
        $collectorDefinition = $container->getDefinition('data_collector.cache');
        $recorder = new \ConfigTransformer202205131\Symfony\Component\DependencyInjection\Definition(\is_subclass_of($definition->getClass(), \ConfigTransformer202205131\Symfony\Component\Cache\Adapter\TagAwareAdapterInterface::class) ? \ConfigTransformer202205131\Symfony\Component\Cache\Adapter\TraceableTagAwareAdapter::class : \ConfigTransformer202205131\Symfony\Component\Cache\Adapter\TraceableAdapter::class);
        $recorder->setTags($definition->getTags());
        if (!$definition->isPublic() || !$definition->isPrivate()) {
            $recorder->setPublic($definition->isPublic());
        }
        $recorder->setArguments([new \ConfigTransformer202205131\Symfony\Component\DependencyInjection\Reference($innerId = $id . '.recorder_inner')]);
        foreach ($definition->getMethodCalls() as [$method, $args]) {
            if ('setCallbackWrapper' !== $method || !$args[0] instanceof \ConfigTransformer202205131\Symfony\Component\DependencyInjection\Definition || !($args[0]->getArguments()[2] ?? null) instanceof \ConfigTransformer202205131\Symfony\Component\DependencyInjection\Definition) {
                continue;
            }
            if ([new \ConfigTransformer202205131\Symfony\Component\DependencyInjection\Reference($id), 'setCallbackWrapper'] == $args[0]->getArguments()[2]->getFactory()) {
                $args[0]->getArguments()[2]->setFactory([new \ConfigTransformer202205131\Symfony\Component\DependencyInjection\Reference($innerId), 'setCallbackWrapper']);
            }
        }
        $definition->setTags([]);
        $definition->setPublic(\false);
        $container->setDefinition($innerId, $definition);
        $container->setDefinition($id, $recorder);
        // Tell the collector to add the new instance
        $collectorDefinition->addMethodCall('addInstance', [$name, new \ConfigTransformer202205131\Symfony\Component\DependencyInjection\Reference($id)]);
        $collectorDefinition->setPublic(\false);
    }
}
