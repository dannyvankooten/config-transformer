<?php

declare (strict_types=1);
namespace ConfigTransformer202110149\PhpParser\Node\Expr\Cast;

use ConfigTransformer202110149\PhpParser\Node\Expr\Cast;
class Unset_ extends \ConfigTransformer202110149\PhpParser\Node\Expr\Cast
{
    public function getType() : string
    {
        return 'Expr_Cast_Unset';
    }
}
