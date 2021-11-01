<?php

declare (strict_types=1);
namespace ConfigTransformer2021110110\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer2021110110\PhpParser\BuilderHelpers;
use ConfigTransformer2021110110\PhpParser\Node\Expr;
use ConfigTransformer2021110110\PhpParser\Node\Expr\BinaryOp\Concat;
use ConfigTransformer2021110110\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer2021110110\PhpParser\Node\Expr\ConstFetch;
use ConfigTransformer2021110110\PhpParser\Node\Name;
use ConfigTransformer2021110110\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer2021110110\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformer2021110110\PhpParser\Node\Scalar\String_;
final class CommonNodeFactory
{
    /**
     * @param mixed $argument
     */
    public function createAbsoluteDirExpr($argument) : \ConfigTransformer2021110110\PhpParser\Node\Expr
    {
        if ($argument === '') {
            return new \ConfigTransformer2021110110\PhpParser\Node\Scalar\String_('');
        }
        if (\is_string($argument)) {
            // preslash with dir
            $argument = '/' . $argument;
        }
        $argumentValue = \ConfigTransformer2021110110\PhpParser\BuilderHelpers::normalizeValue($argument);
        if ($argumentValue instanceof \ConfigTransformer2021110110\PhpParser\Node\Scalar\String_) {
            $argumentValue = new \ConfigTransformer2021110110\PhpParser\Node\Expr\BinaryOp\Concat(new \ConfigTransformer2021110110\PhpParser\Node\Scalar\MagicConst\Dir(), $argumentValue);
        }
        return $argumentValue;
    }
    public function createClassReference(string $className) : \ConfigTransformer2021110110\PhpParser\Node\Expr\ClassConstFetch
    {
        return $this->createConstFetch($className, 'class');
    }
    public function createConstFetch(string $className, string $constantName) : \ConfigTransformer2021110110\PhpParser\Node\Expr\ClassConstFetch
    {
        return new \ConfigTransformer2021110110\PhpParser\Node\Expr\ClassConstFetch(new \ConfigTransformer2021110110\PhpParser\Node\Name\FullyQualified($className), $constantName);
    }
    public function createFalse() : \ConfigTransformer2021110110\PhpParser\Node\Expr\ConstFetch
    {
        return new \ConfigTransformer2021110110\PhpParser\Node\Expr\ConstFetch(new \ConfigTransformer2021110110\PhpParser\Node\Name('false'));
    }
    public function createTrue() : \ConfigTransformer2021110110\PhpParser\Node\Expr\ConstFetch
    {
        return new \ConfigTransformer2021110110\PhpParser\Node\Expr\ConstFetch(new \ConfigTransformer2021110110\PhpParser\Node\Name('true'));
    }
}
