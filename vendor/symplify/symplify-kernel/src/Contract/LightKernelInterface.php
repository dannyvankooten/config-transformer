<?php

declare (strict_types=1);
namespace ConfigTransformer202112011\Symplify\SymplifyKernel\Contract;

use ConfigTransformer202112011\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer202112011\Psr\Container\ContainerInterface;
    public function getContainer() : \ConfigTransformer202112011\Psr\Container\ContainerInterface;
}
