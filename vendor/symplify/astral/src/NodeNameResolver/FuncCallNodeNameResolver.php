<?php

declare (strict_types=1);
namespace ConfigTransformer2022030710\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022030710\PhpParser\Node;
use ConfigTransformer2022030710\PhpParser\Node\Expr;
use ConfigTransformer2022030710\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer2022030710\Symplify\Astral\Contract\NodeNameResolverInterface;
final class FuncCallNodeNameResolver implements \ConfigTransformer2022030710\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022030710\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2022030710\PhpParser\Node\Expr\FuncCall;
    }
    /**
     * @param FuncCall $node
     */
    public function resolve(\ConfigTransformer2022030710\PhpParser\Node $node) : ?string
    {
        if ($node->name instanceof \ConfigTransformer2022030710\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
}
