<?php

declare (strict_types=1);
namespace ConfigTransformer202108306\Symplify\EasyTesting\HttpKernel;

use ConfigTransformer202108306\Symfony\Component\Config\Loader\LoaderInterface;
use ConfigTransformer202108306\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class EasyTestingKernel extends \ConfigTransformer202108306\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration($loader) : void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
