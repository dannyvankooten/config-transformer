<?php

declare (strict_types=1);
namespace ConfigTransformer2022051110\PhpParser\Node\Expr\Cast;

use ConfigTransformer2022051110\PhpParser\Node\Expr\Cast;
class Unset_ extends \ConfigTransformer2022051110\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Unset';
    }
}
