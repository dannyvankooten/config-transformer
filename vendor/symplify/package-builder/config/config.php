<?php

declare (strict_types=1);
namespace ConfigTransformer2022051110;

use ConfigTransformer2022051110\SebastianBergmann\Diff\Differ;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use ConfigTransformer2022051110\Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter;
use ConfigTransformer2022051110\Symplify\PackageBuilder\Console\Output\ConsoleDiffer;
use ConfigTransformer2022051110\Symplify\PackageBuilder\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use ConfigTransformer2022051110\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) : void {
    $services = $containerConfigurator->services();
    $services->defaults()->public()->autowire()->autoconfigure();
    $services->set(\ConfigTransformer2022051110\Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter::class);
    $services->set(\ConfigTransformer2022051110\Symplify\PackageBuilder\Console\Output\ConsoleDiffer::class);
    $services->set(\ConfigTransformer2022051110\Symplify\PackageBuilder\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory::class);
    $services->set(\ConfigTransformer2022051110\SebastianBergmann\Diff\Differ::class);
    $services->set(\ConfigTransformer2022051110\Symplify\PackageBuilder\Reflection\PrivatesAccessor::class);
};
