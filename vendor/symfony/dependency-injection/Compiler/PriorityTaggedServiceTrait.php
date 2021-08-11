<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202108115\Symfony\Component\DependencyInjection\Compiler;

use ConfigTransformer202108115\Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use ConfigTransformer202108115\Symfony\Component\DependencyInjection\Attribute\AsTaggedItem;
use ConfigTransformer202108115\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202108115\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use ConfigTransformer202108115\Symfony\Component\DependencyInjection\Reference;
use ConfigTransformer202108115\Symfony\Component\DependencyInjection\TypedReference;
/**
 * Trait that allows a generic method to find and sort service by priority option in the tag.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
trait PriorityTaggedServiceTrait
{
    /**
     * Finds all services with the given tag name and order them by their priority.
     *
     * The order of additions must be respected for services having the same priority,
     * and knowing that the \SplPriorityQueue class does not respect the FIFO method,
     * we should not use that class.
     *
     * @see https://bugs.php.net/53710
     * @see https://bugs.php.net/60926
     *
     * @param string|TaggedIteratorArgument $tagName
     *
     * @return Reference[]
     */
    private function findAndSortTaggedServices($tagName, \ConfigTransformer202108115\Symfony\Component\DependencyInjection\ContainerBuilder $container) : array
    {
        $indexAttribute = $defaultIndexMethod = $needsIndexes = $defaultPriorityMethod = null;
        if ($tagName instanceof \ConfigTransformer202108115\Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument) {
            $indexAttribute = $tagName->getIndexAttribute();
            $defaultIndexMethod = $tagName->getDefaultIndexMethod();
            $needsIndexes = $tagName->needsIndexes();
            $defaultPriorityMethod = $tagName->getDefaultPriorityMethod() ?? 'getDefaultPriority';
            $tagName = $tagName->getTag();
        }
        $i = 0;
        $services = [];
        foreach ($container->findTaggedServiceIds($tagName, \true) as $serviceId => $attributes) {
            $defaultPriority = null;
            $defaultIndex = null;
            $definition = $container->getDefinition($serviceId);
            $class = $definition->getClass();
            $class = $container->getParameterBag()->resolveValue($class) ?: null;
            $checkTaggedItem = !$definition->hasTag(80000 <= \PHP_VERSION_ID && $definition->isAutoconfigured() ? 'container.ignore_attributes' : $tagName);
            foreach ($attributes as $attribute) {
                $index = $priority = null;
                if (isset($attribute['priority'])) {
                    $priority = $attribute['priority'];
                } elseif (null === $defaultPriority && $defaultPriorityMethod && $class) {
                    $defaultPriority = \ConfigTransformer202108115\Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceUtil::getDefault($container, $serviceId, $class, $defaultPriorityMethod, $tagName, 'priority', $checkTaggedItem);
                }
                $priority = $priority ?? $defaultPriority ?? ($defaultPriority = 0);
                if (null === $indexAttribute && !$defaultIndexMethod && !$needsIndexes) {
                    $services[] = [$priority, ++$i, null, $serviceId, null];
                    continue 2;
                }
                if (null !== $indexAttribute && isset($attribute[$indexAttribute])) {
                    $index = $attribute[$indexAttribute];
                } elseif (null === $defaultIndex && $defaultPriorityMethod && $class) {
                    $defaultIndex = \ConfigTransformer202108115\Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceUtil::getDefault($container, $serviceId, $class, $defaultIndexMethod ?? 'getDefaultName', $tagName, $indexAttribute, $checkTaggedItem);
                }
                $index = $index ?? $defaultIndex ?? ($defaultIndex = $serviceId);
                $services[] = [$priority, ++$i, $index, $serviceId, $class];
            }
        }
        \uasort($services, static function ($a, $b) {
            return $b[0] <=> $a[0] ?: $a[1] <=> $b[1];
        });
        $refs = [];
        foreach ($services as [, , $index, $serviceId, $class]) {
            if (!$class) {
                $reference = new \ConfigTransformer202108115\Symfony\Component\DependencyInjection\Reference($serviceId);
            } elseif ($index === $serviceId) {
                $reference = new \ConfigTransformer202108115\Symfony\Component\DependencyInjection\TypedReference($serviceId, $class);
            } else {
                $reference = new \ConfigTransformer202108115\Symfony\Component\DependencyInjection\TypedReference($serviceId, $class, \ConfigTransformer202108115\Symfony\Component\DependencyInjection\ContainerBuilder::EXCEPTION_ON_INVALID_REFERENCE, $index);
            }
            if (null === $index) {
                $refs[] = $reference;
            } else {
                $refs[$index] = $reference;
            }
        }
        return $refs;
    }
}
/**
 * @internal
 */
class PriorityTaggedServiceUtil
{
    /**
     * @return string|int|null
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param string $serviceId
     * @param string $class
     * @param string $defaultMethod
     * @param string $tagName
     * @param string|null $indexAttribute
     * @param bool $checkTaggedItem
     */
    public static function getDefault($container, $serviceId, $class, $defaultMethod, $tagName, $indexAttribute, $checkTaggedItem)
    {
        if (!($r = $container->getReflectionClass($class)) || !$checkTaggedItem && !$r->hasMethod($defaultMethod)) {
            return null;
        }
        if ($checkTaggedItem && !$r->hasMethod($defaultMethod)) {
            foreach ($r->getAttributes(\ConfigTransformer202108115\Symfony\Component\DependencyInjection\Attribute\AsTaggedItem::class) as $attribute) {
                return 'priority' === $indexAttribute ? $attribute->newInstance()->priority : $attribute->newInstance()->index;
            }
            return null;
        }
        if (null !== $indexAttribute) {
            $service = $class !== $serviceId ? \sprintf('service "%s"', $serviceId) : 'on the corresponding service';
            $message = [\sprintf('Either method "%s::%s()" should ', $class, $defaultMethod), \sprintf(' or tag "%s" on %s is missing attribute "%s".', $tagName, $service, $indexAttribute)];
        } else {
            $message = [\sprintf('Method "%s::%s()" should ', $class, $defaultMethod), '.'];
        }
        if (!($rm = $r->getMethod($defaultMethod))->isStatic()) {
            throw new \ConfigTransformer202108115\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\implode('be static', $message));
        }
        if (!$rm->isPublic()) {
            throw new \ConfigTransformer202108115\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\implode('be public', $message));
        }
        $default = $rm->invoke(null);
        if ('priority' === $indexAttribute) {
            if (!\is_int($default)) {
                throw new \ConfigTransformer202108115\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\implode(\sprintf('return int (got "%s")', \get_debug_type($default)), $message));
            }
            return $default;
        }
        if (\is_int($default)) {
            $default = (string) $default;
        }
        if (!\is_string($default)) {
            throw new \ConfigTransformer202108115\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException(\implode(\sprintf('return string|int (got "%s")', \get_debug_type($default)), $message));
        }
        return $default;
    }
}
