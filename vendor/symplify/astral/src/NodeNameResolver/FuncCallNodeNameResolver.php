<?php

declare (strict_types=1);
namespace ConfigTransformer2021110110\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2021110110\PhpParser\Node;
use ConfigTransformer2021110110\PhpParser\Node\Expr;
use ConfigTransformer2021110110\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer2021110110\Symplify\Astral\Contract\NodeNameResolverInterface;
final class FuncCallNodeNameResolver implements \ConfigTransformer2021110110\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer2021110110\PhpParser\Node\Expr\FuncCall;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        if ($node->name instanceof \ConfigTransformer2021110110\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
