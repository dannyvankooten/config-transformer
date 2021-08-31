<?php

declare (strict_types=1);
namespace ConfigTransformer202108312\Symplify\ConfigTransformer\Converter;

use ConfigTransformer202108312\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer202108312\Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformer202108312\Symplify\ConfigTransformer\ValueObject\ConvertedContent;
use ConfigTransformer202108312\Symplify\SmartFileSystem\SmartFileInfo;
final class ConvertedContentFactory
{
    /**
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var \Symplify\ConfigTransformer\Converter\ConfigFormatConverter
     */
    private $configFormatConverter;
    public function __construct(\ConfigTransformer202108312\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \ConfigTransformer202108312\Symplify\ConfigTransformer\Converter\ConfigFormatConverter $configFormatConverter)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->configFormatConverter = $configFormatConverter;
    }
    /**
     * @param SmartFileInfo[] $fileInfos
     * @return ConvertedContent[]
     */
    public function createFromFileInfos(array $fileInfos, \ConfigTransformer202108312\Symplify\ConfigTransformer\ValueObject\Configuration $configuration) : array
    {
        $convertedContentFromFileInfo = [];
        foreach ($fileInfos as $fileInfo) {
            $message = \sprintf('Processing "%s" file', $fileInfo->getRelativeFilePathFromCwd());
            $this->symfonyStyle->note($message);
            $convertedContent = $this->configFormatConverter->convert($fileInfo, $configuration);
            $convertedContentFromFileInfo[] = new \ConfigTransformer202108312\Symplify\ConfigTransformer\ValueObject\ConvertedContent($convertedContent, $fileInfo);
        }
        return $convertedContentFromFileInfo;
    }
}
