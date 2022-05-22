<?php

declare (strict_types=1);
namespace ConfigTransformer2022052210\Symplify\EasyTesting\ValueObject;

use ConfigTransformer2022052210\Symplify\SmartFileSystem\SmartFileInfo;
final class InputFileInfoAndExpectedFileInfo
{
    /**
     * @var \Symplify\SmartFileSystem\SmartFileInfo
     */
    private $inputFileInfo;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileInfo
     */
    private $expectedFileInfo;
    public function __construct(\ConfigTransformer2022052210\Symplify\SmartFileSystem\SmartFileInfo $inputFileInfo, \ConfigTransformer2022052210\Symplify\SmartFileSystem\SmartFileInfo $expectedFileInfo)
    {
        $this->inputFileInfo = $inputFileInfo;
        $this->expectedFileInfo = $expectedFileInfo;
    }
    public function getInputFileInfo() : \ConfigTransformer2022052210\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->inputFileInfo;
    }
    public function getExpectedFileInfo() : \ConfigTransformer2022052210\Symplify\SmartFileSystem\SmartFileInfo
    {
        return $this->expectedFileInfo;
    }
    public function getExpectedFileContent() : string
    {
        return $this->expectedFileInfo->getContents();
    }
    public function getExpectedFileInfoRealPath() : string
    {
        return $this->expectedFileInfo->getRealPath();
    }
}
