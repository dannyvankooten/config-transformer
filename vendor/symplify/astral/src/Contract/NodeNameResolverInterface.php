<?php

declare (strict_types=1);
namespace ConfigTransformer2021091810\Symplify\Astral\Contract;

use ConfigTransformer2021091810\PhpParser\Node;
interface NodeNameResolverInterface
{
    /**
     * @param \PhpParser\Node $node
     */
    public function match($node) : bool;
    /**
     * @param \PhpParser\Node $node
     */
    public function resolve($node) : ?string;
}
