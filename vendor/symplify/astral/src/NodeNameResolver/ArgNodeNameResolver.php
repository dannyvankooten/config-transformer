<?php

declare (strict_types=1);
namespace ConfigTransformer202112319\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202112319\PhpParser\Node;
use ConfigTransformer202112319\PhpParser\Node\Arg;
use ConfigTransformer202112319\Symplify\Astral\Contract\NodeNameResolverInterface;
final class ArgNodeNameResolver implements \ConfigTransformer202112319\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202112319\PhpParser\Node $node) : bool
    {
        return $node instanceof \ConfigTransformer202112319\PhpParser\Node\Arg;
    }
    /**
     * @param Arg $node
     */
    public function resolve(\ConfigTransformer202112319\PhpParser\Node $node) : ?string
    {
        if ($node->name === null) {
            return null;
        }
        return (string) $node->name;
    }
}
