<?php

declare (strict_types=1);
namespace ConfigTransformer202112169\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202112169\PhpParser\BuilderHelpers;
use ConfigTransformer202112169\PhpParser\Node\Arg;
use ConfigTransformer202112169\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202112169\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202112169\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ParentLazyServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202112169\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202112169\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202112169\PhpParser\Node\Expr\MethodCall
    {
        $method = $key;
        $methodCall = new \ConfigTransformer202112169\PhpParser\Node\Expr\MethodCall($methodCall, $method);
        $methodCall->args[] = new \ConfigTransformer202112169\PhpParser\Node\Arg(\ConfigTransformer202112169\PhpParser\BuilderHelpers::normalizeValue($values[$key]));
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\ConfigTransformer202112169\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARENT, \ConfigTransformer202112169\Symplify\PhpConfigPrinter\ValueObject\YamlKey::LAZY], \true);
    }
}
