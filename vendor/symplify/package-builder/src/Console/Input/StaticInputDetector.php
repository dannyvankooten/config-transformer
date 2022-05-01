<?php

declare (strict_types=1);
namespace ConfigTransformer202205016\Symplify\PackageBuilder\Console\Input;

use ConfigTransformer202205016\Symfony\Component\Console\Input\ArgvInput;
/**
 * @api
 */
final class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \ConfigTransformer202205016\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
