<?php

declare (strict_types=1);
namespace ConfigTransformer202202237\PhpParser\Node\Expr\Cast;

use ConfigTransformer202202237\PhpParser\Node\Expr\Cast;
class Unset_ extends \ConfigTransformer202202237\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Unset';
    }
}
