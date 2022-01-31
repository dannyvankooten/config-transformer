<?php

declare (strict_types=1);
namespace ConfigTransformer202201317;

use ConfigTransformer202201317\Symplify\EasyTesting\Kernel\EasyTestingKernel;
use ConfigTransformer202201317\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun;
$possibleAutoloadPaths = [
    // dependency
    __DIR__ . '/../../../autoload.php',
    // after split package
    __DIR__ . '/../vendor/autoload.php',
    // monorepo
    __DIR__ . '/../../../vendor/autoload.php',
];
foreach ($possibleAutoloadPaths as $possibleAutoloadPath) {
    if (\file_exists($possibleAutoloadPath)) {
        require_once $possibleAutoloadPath;
        break;
    }
}
$kernelBootAndApplicationRun = new \ConfigTransformer202201317\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun(\ConfigTransformer202201317\Symplify\EasyTesting\Kernel\EasyTestingKernel::class);
$kernelBootAndApplicationRun->run();
