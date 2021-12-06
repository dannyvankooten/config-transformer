<?php

declare (strict_types=1);
namespace ConfigTransformer2021120610\Symplify\PackageBuilder\Console\Input;

use ConfigTransformer2021120610\Symfony\Component\Console\Input\ArgvInput;
/**
 * @api
 */
final class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \ConfigTransformer2021120610\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
