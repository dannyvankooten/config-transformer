<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\Symplify\Astral\NodeNameResolver;

use ConfigTransformer2022031610\PhpParser\Node;
use ConfigTransformer2022031610\PhpParser\Node\Expr;
use ConfigTransformer2022031610\PhpParser\Node\Param;
use ConfigTransformer2022031610\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ParamNodeNameResolver implements \ConfigTransformer2022031610\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer2022031610\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer2022031610\PhpParser\Node\Param;
    }
    /**
     * @param Param $node
     */
    public function resolve(\ConfigTransformer2022031610\PhpParser\Node $node) : ?string
    {
        $paramName = $node->var->name;
        if ($paramName instanceof \ConfigTransformer2022031610\PhpParser\Node\Expr) {
            return null;
        }
        return $paramName;
    }
}
