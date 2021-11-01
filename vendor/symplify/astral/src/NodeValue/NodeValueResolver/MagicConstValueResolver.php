<?php

declare (strict_types=1);
namespace ConfigTransformer2021110110\Symplify\Astral\NodeValue\NodeValueResolver;

use ConfigTransformer2021110110\PhpParser\Node\Expr;
use ConfigTransformer2021110110\PhpParser\Node\Scalar\MagicConst;
use ConfigTransformer2021110110\PhpParser\Node\Scalar\MagicConst\Dir;
use ConfigTransformer2021110110\PhpParser\Node\Scalar\MagicConst\File;
use ConfigTransformer2021110110\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 *
 * @implements NodeValueResolverInterface<MagicConst>
 */
final class MagicConstValueResolver implements \ConfigTransformer2021110110\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface
{
    public function getType() : string
    {
        return \ConfigTransformer2021110110\PhpParser\Node\Scalar\MagicConst::class;
    }
    /**
     * @param \PhpParser\Node\Expr $expr
     * @param string $currentFilePath
     */
    public function resolve($expr, $currentFilePath) : ?string
    {
        if ($expr instanceof \ConfigTransformer2021110110\PhpParser\Node\Scalar\MagicConst\Dir) {
            return \dirname($currentFilePath);
        }
        if ($expr instanceof \ConfigTransformer2021110110\PhpParser\Node\Scalar\MagicConst\File) {
            return $currentFilePath;
        }
        return null;
    }
}
