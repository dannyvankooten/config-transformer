<?php

declare (strict_types=1);
namespace ConfigTransformer202110149\Symplify\PackageBuilder\Contract\HttpKernel;

use ConfigTransformer202110149\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202110149\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ConfigTransformer202110149\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     */
    public function setConfigs($configs) : void;
}
