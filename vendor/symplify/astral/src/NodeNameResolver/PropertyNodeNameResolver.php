<?php

declare (strict_types=1);
namespace ConfigTransformer202111011\Symplify\Astral\NodeNameResolver;

use ConfigTransformer202111011\PhpParser\Node;
use ConfigTransformer202111011\PhpParser\Node\Stmt\Property;
use ConfigTransformer202111011\Symplify\Astral\Contract\NodeNameResolverInterface;
final class PropertyNodeNameResolver implements \ConfigTransformer202111011\Symplify\Astral\Contract\NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool
    {
        return $node instanceof \ConfigTransformer202111011\PhpParser\Node\Stmt\Property;
    }
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string
    {
        $propertyProperty = $node->props[0];
        return (string) $propertyProperty->name;
    }
}
