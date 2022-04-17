<?php

declare (strict_types=1);
namespace ConfigTransformer202204178\Symplify\Astral\PhpDocParser\StaticFactory;

use ConfigTransformer202204178\PHPStan\PhpDocParser\Lexer\Lexer;
use ConfigTransformer202204178\PHPStan\PhpDocParser\Parser\ConstExprParser;
use ConfigTransformer202204178\PHPStan\PhpDocParser\Parser\PhpDocParser;
use ConfigTransformer202204178\PHPStan\PhpDocParser\Parser\TypeParser;
use ConfigTransformer202204178\Symplify\Astral\PhpDocParser\SimplePhpDocParser;
/**
 * @api
 */
final class SimplePhpDocParserStaticFactory
{
    public static function create() : \ConfigTransformer202204178\Symplify\Astral\PhpDocParser\SimplePhpDocParser
    {
        $phpDocParser = new \ConfigTransformer202204178\PHPStan\PhpDocParser\Parser\PhpDocParser(new \ConfigTransformer202204178\PHPStan\PhpDocParser\Parser\TypeParser(), new \ConfigTransformer202204178\PHPStan\PhpDocParser\Parser\ConstExprParser());
        return new \ConfigTransformer202204178\Symplify\Astral\PhpDocParser\SimplePhpDocParser($phpDocParser, new \ConfigTransformer202204178\PHPStan\PhpDocParser\Lexer\Lexer());
    }
}
