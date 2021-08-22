<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202108229\Symfony\Component\DependencyInjection\Config;

use ConfigTransformer202108229\Symfony\Component\Config\Resource\ResourceInterface;
use ConfigTransformer202108229\Symfony\Component\Config\ResourceCheckerInterface;
use ConfigTransformer202108229\Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * @author Maxime Steinhausser <maxime.steinhausser@gmail.com>
 */
class ContainerParametersResourceChecker implements \ConfigTransformer202108229\Symfony\Component\Config\ResourceCheckerInterface
{
    /** @var ContainerInterface */
    private $container;
    public function __construct(\ConfigTransformer202108229\Symfony\Component\DependencyInjection\ContainerInterface $container)
    {
        $this->container = $container;
    }
    /**
     * {@inheritdoc}
     * @param \Symfony\Component\Config\Resource\ResourceInterface $metadata
     */
    public function supports($metadata)
    {
        return $metadata instanceof \ConfigTransformer202108229\Symfony\Component\DependencyInjection\Config\ContainerParametersResource;
    }
    /**
     * {@inheritdoc}
     * @param \Symfony\Component\Config\Resource\ResourceInterface $resource
     * @param int $timestamp
     */
    public function isFresh($resource, $timestamp)
    {
        foreach ($resource->getParameters() as $key => $value) {
            if (!$this->container->hasParameter($key) || $this->container->getParameter($key) !== $value) {
                return \false;
            }
        }
        return \true;
    }
}
