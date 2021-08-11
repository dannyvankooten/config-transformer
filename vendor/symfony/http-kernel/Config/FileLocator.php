<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202108112\Symfony\Component\HttpKernel\Config;

use ConfigTransformer202108112\Symfony\Component\Config\FileLocator as BaseFileLocator;
use ConfigTransformer202108112\Symfony\Component\HttpKernel\KernelInterface;
/**
 * FileLocator uses the KernelInterface to locate resources in bundles.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class FileLocator extends \ConfigTransformer202108112\Symfony\Component\Config\FileLocator
{
    private $kernel;
    public function __construct(\ConfigTransformer202108112\Symfony\Component\HttpKernel\KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        parent::__construct();
    }
    /**
     * {@inheritdoc}
     * @param string $file
     * @param string|null $currentPath
     * @param bool $first
     */
    public function locate($file, $currentPath = null, $first = \true)
    {
        if (isset($file[0]) && '@' === $file[0]) {
            $resource = $this->kernel->locateResource($file);
            return $first ? $resource : [$resource];
        }
        return parent::locate($file, $currentPath, $first);
    }
}
