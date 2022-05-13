<?php

declare (strict_types=1);
namespace ConfigTransformer202205131\Symplify\SmartFileSystem\Json;

use ConfigTransformer202205131\Nette\Utils\Arrays;
use ConfigTransformer202205131\Nette\Utils\Json;
use ConfigTransformer202205131\Symplify\SmartFileSystem\FileSystemGuard;
use ConfigTransformer202205131\Symplify\SmartFileSystem\SmartFileSystem;
/**
 * @api
 * @see \Symplify\SmartFileSystem\Tests\Json\JsonFileSystem\JsonFileSystemTest
 */
final class JsonFileSystem
{
    /**
     * @var \Symplify\SmartFileSystem\FileSystemGuard
     */
    private $fileSystemGuard;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\ConfigTransformer202205131\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard, \ConfigTransformer202205131\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->fileSystemGuard = $fileSystemGuard;
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @return mixed[]
     */
    public function loadFilePathToJson(string $filePath) : array
    {
        $this->fileSystemGuard->ensureFileExists($filePath, __METHOD__);
        $fileContent = $this->smartFileSystem->readFile($filePath);
        return \ConfigTransformer202205131\Nette\Utils\Json::decode($fileContent, \ConfigTransformer202205131\Nette\Utils\Json::FORCE_ARRAY);
    }
    /**
     * @param array<string, mixed> $jsonArray
     */
    public function writeJsonToFilePath(array $jsonArray, string $filePath) : void
    {
        $jsonContent = \ConfigTransformer202205131\Nette\Utils\Json::encode($jsonArray, \ConfigTransformer202205131\Nette\Utils\Json::PRETTY) . \PHP_EOL;
        $this->smartFileSystem->dumpFile($filePath, $jsonContent);
    }
    /**
     * @param array<string, mixed> $newJsonArray
     */
    public function mergeArrayToJsonFile(string $filePath, array $newJsonArray) : void
    {
        $jsonArray = $this->loadFilePathToJson($filePath);
        $newComposerJsonArray = \ConfigTransformer202205131\Nette\Utils\Arrays::mergeTree($jsonArray, $newJsonArray);
        $this->writeJsonToFilePath($newComposerJsonArray, $filePath);
    }
}
