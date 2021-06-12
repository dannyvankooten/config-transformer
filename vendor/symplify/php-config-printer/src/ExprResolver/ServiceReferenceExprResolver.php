<?php

declare (strict_types=1);
namespace ConfigTransformer2021061210\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer2021061210\PhpParser\Node\Arg;
use ConfigTransformer2021061210\PhpParser\Node\Expr;
use ConfigTransformer2021061210\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer2021061210\PhpParser\Node\Name\FullyQualified;
final class ServiceReferenceExprResolver
{
    /**
     * @var StringExprResolver
     */
    private $stringExprResolver;
    public function __construct(\ConfigTransformer2021061210\Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver $stringExprResolver)
    {
        $this->stringExprResolver = $stringExprResolver;
    }
    public function resolveServiceReferenceExpr(string $value, bool $skipServiceReference, string $functionName) : \ConfigTransformer2021061210\PhpParser\Node\Expr
    {
        $value = \ltrim($value, '@');
        $expr = $this->stringExprResolver->resolve($value, $skipServiceReference, \false);
        if ($skipServiceReference) {
            return $expr;
        }
        $args = [new \ConfigTransformer2021061210\PhpParser\Node\Arg($expr)];
        return new \ConfigTransformer2021061210\PhpParser\Node\Expr\FuncCall(new \ConfigTransformer2021061210\PhpParser\Node\Name\FullyQualified($functionName), $args);
    }
}
