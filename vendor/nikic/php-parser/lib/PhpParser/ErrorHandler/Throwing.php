<?php

declare (strict_types=1);
namespace ConfigTransformer20220607\PhpParser\ErrorHandler;

use ConfigTransformer20220607\PhpParser\Error;
use ConfigTransformer20220607\PhpParser\ErrorHandler;
/**
 * Error handler that handles all errors by throwing them.
 *
 * This is the default strategy used by all components.
 */
class Throwing implements ErrorHandler
{
    public function handleError(Error $error)
    {
        throw $error;
    }
}
