<?php

declare (strict_types=1);
namespace ConfigTransformer20220607\Symplify\SymplifyKernel\HttpKernel;

use ConfigTransformer20220607\Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ConfigTransformer20220607\Symfony\Component\DependencyInjection\Container;
use ConfigTransformer20220607\Symfony\Component\DependencyInjection\ContainerInterface;
use ConfigTransformer20220607\Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use ConfigTransformer20220607\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformer20220607\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ConfigTransformer20220607\Symplify\SymplifyKernel\ContainerBuilderFactory;
use ConfigTransformer20220607\Symplify\SymplifyKernel\Contract\LightKernelInterface;
use ConfigTransformer20220607\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
use ConfigTransformer20220607\Symplify\SymplifyKernel\ValueObject\SymplifyKernelConfig;
/**
 * @api
 */
abstract class AbstractSymplifyKernel implements LightKernelInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container|null
     */
    private $container = null;
    /**
     * @param string[] $configFiles
     * @param CompilerPassInterface[] $compilerPasses
     * @param ExtensionInterface[] $extensions
     */
    public function create(array $configFiles, array $compilerPasses = [], array $extensions = []) : ContainerInterface
    {
        $containerBuilderFactory = new ContainerBuilderFactory(new ParameterMergingLoaderFactory());
        $compilerPasses[] = new AutowireArrayParameterCompilerPass();
        $configFiles[] = SymplifyKernelConfig::FILE_PATH;
        $containerBuilder = $containerBuilderFactory->create($configFiles, $compilerPasses, $extensions);
        $containerBuilder->compile();
        $this->container = $containerBuilder;
        return $containerBuilder;
    }
    public function getContainer() : \ConfigTransformer20220607\Psr\Container\ContainerInterface
    {
        if (!$this->container instanceof Container) {
            throw new ShouldNotHappenException();
        }
        return $this->container;
    }
}
