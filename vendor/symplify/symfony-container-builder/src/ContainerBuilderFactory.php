<?php

declare (strict_types=1);
namespace ConfigTransformer2021110110\Symplify\SymfonyContainerBuilder;

use ConfigTransformer2021110110\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer2021110110\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformer2021110110\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use ConfigTransformer2021110110\Symplify\SymfonyContainerBuilder\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer2021110110\Symplify\SymfonyContainerBuilder\DependencyInjection\LoadExtensionConfigsCompilerPass;
use ConfigTransformer2021110110\Webmozart\Assert\Assert;
final class ContainerBuilderFactory
{
    /**
     * @var \Symplify\SymfonyContainerBuilder\Config\Loader\ParameterMergingLoaderFactory
     */
    private $parameterMergingLoaderFactory;
    public function __construct()
    {
        $this->parameterMergingLoaderFactory = new \ConfigTransformer2021110110\Symplify\SymfonyContainerBuilder\Config\Loader\ParameterMergingLoaderFactory();
    }
    /**
     * @param ExtensionInterface[] $extensions
     * @param CompilerPassInterface[] $compilerPasses
     * @param string[] $configFiles
     */
    public function create(array $extensions, array $compilerPasses, array $configFiles) : \ConfigTransformer2021110110\Symfony\Component\DependencyInjection\ContainerBuilder
    {
        \ConfigTransformer2021110110\Webmozart\Assert\Assert::allString($configFiles);
        \ConfigTransformer2021110110\Webmozart\Assert\Assert::allFile($configFiles);
        $containerBuilder = new \ConfigTransformer2021110110\Symfony\Component\DependencyInjection\ContainerBuilder();
        $this->registerExtensions($containerBuilder, $extensions);
        $this->registerConfigFiles($containerBuilder, $configFiles);
        $this->registerCompilerPasses($containerBuilder, $compilerPasses);
        // this calls load() method in every extensions
        // ensure these extensions are implicitly loaded
        $compilerPassConfig = $containerBuilder->getCompilerPassConfig();
        $compilerPassConfig->setMergePass(new \ConfigTransformer2021110110\Symplify\SymfonyContainerBuilder\DependencyInjection\LoadExtensionConfigsCompilerPass());
        return $containerBuilder;
    }
    /**
     * @param ExtensionInterface[] $extensions
     */
    private function registerExtensions(\ConfigTransformer2021110110\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, array $extensions) : void
    {
        foreach ($extensions as $extension) {
            $containerBuilder->registerExtension($extension);
        }
    }
    /**
     * @param CompilerPassInterface[] $compilerPasses
     */
    private function registerCompilerPasses(\ConfigTransformer2021110110\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, array $compilerPasses) : void
    {
        foreach ($compilerPasses as $compilerPass) {
            $containerBuilder->addCompilerPass($compilerPass);
        }
    }
    /**
     * @param string[] $configFiles
     */
    private function registerConfigFiles(\ConfigTransformer2021110110\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, array $configFiles) : void
    {
        $delegatingLoader = $this->parameterMergingLoaderFactory->create($containerBuilder, \getcwd());
        foreach ($configFiles as $configFile) {
            $delegatingLoader->load($configFile);
        }
    }
}
