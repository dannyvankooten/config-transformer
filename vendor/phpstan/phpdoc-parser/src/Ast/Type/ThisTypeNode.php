<?php

declare (strict_types=1);
namespace ConfigTransformer2022030710\PHPStan\PhpDocParser\Ast\Type;

use ConfigTransformer2022030710\PHPStan\PhpDocParser\Ast\NodeAttributes;
class ThisTypeNode implements \ConfigTransformer2022030710\PHPStan\PhpDocParser\Ast\Type\TypeNode
{
    use NodeAttributes;
    public function __toString() : string
    {
        return '$this';
    }
}
