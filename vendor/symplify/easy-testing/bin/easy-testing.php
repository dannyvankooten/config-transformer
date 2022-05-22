<?php

declare (strict_types=1);
namespace ConfigTransformer2022052210;

use ConfigTransformer2022052210\Symplify\EasyTesting\Kernel\EasyTestingKernel;
use ConfigTransformer2022052210\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun;
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
$kernelBootAndApplicationRun = new \ConfigTransformer2022052210\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun(\ConfigTransformer2022052210\Symplify\EasyTesting\Kernel\EasyTestingKernel::class);
$kernelBootAndApplicationRun->run();
