<?php

declare (strict_types=1);
namespace ConfigTransformer202108180;

use ConfigTransformer202108180\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer202108180\Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer202108180\Symplify\ComposerJsonManipulator\ValueObject\Option;
use ConfigTransformer202108180\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer202108180\Symplify\PackageBuilder\Parameter\ParameterProvider;
use ConfigTransformer202108180\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use ConfigTransformer202108180\Symplify\SmartFileSystem\SmartFileSystem;
use function ConfigTransformer202108180\Symfony\Component\DependencyInjection\Loader\Configurator\service;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\ConfigTransformer202108180\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS, ['keywords']);
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->load('ConfigTransformer202108180\Symplify\ComposerJsonManipulator\\', __DIR__ . '/../src')->exclude([__DIR__ . '/../src/Bundle']);
    $services->set(\ConfigTransformer202108180\Symplify\SmartFileSystem\SmartFileSystem::class);
    $services->set(\ConfigTransformer202108180\Symplify\PackageBuilder\Reflection\PrivatesCaller::class);
    $services->set(\ConfigTransformer202108180\Symplify\PackageBuilder\Parameter\ParameterProvider::class)->args([\ConfigTransformer202108180\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202108180\Symfony\Component\DependencyInjection\ContainerInterface::class)]);
    $services->set(\ConfigTransformer202108180\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class);
    $services->set(\ConfigTransformer202108180\Symfony\Component\Console\Style\SymfonyStyle::class)->factory([\ConfigTransformer202108180\Symfony\Component\DependencyInjection\Loader\Configurator\service(\ConfigTransformer202108180\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory::class), 'create']);
};
