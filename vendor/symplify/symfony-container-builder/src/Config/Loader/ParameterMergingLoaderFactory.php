<?php

declare (strict_types=1);
namespace ConfigTransformer202111018\Symplify\SymfonyContainerBuilder\Config\Loader;

use ConfigTransformer202111018\Symfony\Component\Config\FileLocator;
use ConfigTransformer202111018\Symfony\Component\Config\Loader\DelegatingLoader;
use ConfigTransformer202111018\Symfony\Component\Config\Loader\GlobFileLoader;
use ConfigTransformer202111018\Symfony\Component\Config\Loader\LoaderResolver;
use ConfigTransformer202111018\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer202111018\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader;
final class ParameterMergingLoaderFactory
{
    public function create(\ConfigTransformer202111018\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $currentWorkingDirectory) : \ConfigTransformer202111018\Symfony\Component\Config\Loader\DelegatingLoader
    {
        $fileLocator = new \ConfigTransformer202111018\Symfony\Component\Config\FileLocator([$currentWorkingDirectory]);
        $loaders = [new \ConfigTransformer202111018\Symfony\Component\Config\Loader\GlobFileLoader($fileLocator), new \ConfigTransformer202111018\Symplify\PackageBuilder\DependencyInjection\FileLoader\ParameterMergingPhpFileLoader($containerBuilder, $fileLocator)];
        $loaderResolver = new \ConfigTransformer202111018\Symfony\Component\Config\Loader\LoaderResolver($loaders);
        return new \ConfigTransformer202111018\Symfony\Component\Config\Loader\DelegatingLoader($loaderResolver);
    }
}
