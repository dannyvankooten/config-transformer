<?php

declare (strict_types=1);
namespace ConfigTransformer202202040\Symplify\EasyTesting\ValueObject;

use ConfigTransformer202202040\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer202202040\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class ExpectedAndOutputFileInfoPair
{
    /**
     * @var \Symplify\SmartFileSystem\SmartFileInfo
     */
    private $expectedFileInfo;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileInfo|null
     */
    private $outputFileInfo;
    public function __construct(\ConfigTransformer202202040\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo, ?\ConfigTransformer202202040\Symplify\SmartFileSystem\SmartFileInfo $outputFileInfo)
    {
        $this->expectedFileInfo = $expectedFileInfo;
        $this->outputFileInfo = $outputFileInfo;
    }
    /**
     * @noRector \Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector
     */
    public function getExpectedFileContent() : string
    {
        return $this->expectedFileInfo->getContents();
    }
    /**
     * @noRector \Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector
     */
    public function getOutputFileContent() : string
    {
        if (!$this->outputFileInfo instanceof \ConfigTransformer202202040\Symplify\SmartFileSystem\SmartFileInfo) {
            throw new \ConfigTransformer202202040\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->outputFileInfo->getContents();
    }
    /**
     * @noRector \Rector\Privatization\Rector\ClassMethod\PrivatizeLocalOnlyMethodRector
     */
    public function doesOutputFileExist() : bool
    {
        return $this->outputFileInfo !== null;
    }
}
