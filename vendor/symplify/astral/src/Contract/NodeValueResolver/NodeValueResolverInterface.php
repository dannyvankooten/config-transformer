<?php

declare (strict_types=1);
namespace ConfigTransformer20220607\Symplify\Astral\Contract\NodeValueResolver;

use ConfigTransformer20220607\PhpParser\Node\Expr;
/**
 * @template TExpr as Expr
 */
interface NodeValueResolverInterface
{
    /**
     * @return class-string<TExpr>
     */
    public function getType() : string;
    /**
     * @param TExpr $expr
     * @return mixed
     */
    public function resolve(Expr $expr, string $currentFilePath);
}
