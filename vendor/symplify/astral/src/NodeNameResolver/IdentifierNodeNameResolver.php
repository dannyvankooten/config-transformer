<?php

declare (strict_types=1);
namespace ConfigTransformer202201175\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202201175\PhpParser\Node;
use ConfigTransformer202201175\PhpParser\Node\Identifier;
use ConfigTransformer202201175\PhpParser\Node\Name;
use ConfigTransformer202201175\Symplify\Astral\Contract\NodeNameResolverInterface;
final class IdentifierNodeNameResolver implements \ConfigTransformer202201175\Symplify\Astral\Contract\NodeNameResolverInterface
{
    public function match(\ConfigTransformer202201175\PhpParser\Node $node) : bool
    {
        if ($node instanceof \ConfigTransformer202201175\PhpParser\Node\Identifier) {
            return \true;
        }
        return $node instanceof \ConfigTransformer202201175\PhpParser\Node\Name;
    }
    /**
     * @param Identifier|Name $node
     */
    public function resolve(\ConfigTransformer202201175\PhpParser\Node $node) : ?string
    {
        return (string) $node;
    }
}
