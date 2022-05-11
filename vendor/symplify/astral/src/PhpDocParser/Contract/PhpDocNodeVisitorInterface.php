<?php

declare (strict_types=1);
namespace ConfigTransformer2022051110\Symplify\Astral\PhpDocParser\Contract;

use ConfigTransformer2022051110\PHPStan\PhpDocParser\Ast\Node;
/**
 * Inspired by https://github.com/nikic/PHP-Parser/blob/master/lib/PhpParser/NodeVisitor.php
 */
interface PhpDocNodeVisitorInterface
{
    public function beforeTraverse(\ConfigTransformer2022051110\PHPStan\PhpDocParser\Ast\Node $node) : void;
    /**
     * @return int|\PHPStan\PhpDocParser\Ast\Node|null
     */
    public function enterNode(\ConfigTransformer2022051110\PHPStan\PhpDocParser\Ast\Node $node);
    /**
     * @return int|\PhpParser\Node|mixed[]|null Replacement node (or special return)
     */
    public function leaveNode(\ConfigTransformer2022051110\PHPStan\PhpDocParser\Ast\Node $node);
    public function afterTraverse(\ConfigTransformer2022051110\PHPStan\PhpDocParser\Ast\Node $node) : void;
}
