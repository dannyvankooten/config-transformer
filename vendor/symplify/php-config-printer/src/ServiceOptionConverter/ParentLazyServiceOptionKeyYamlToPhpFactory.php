<?php

declare (strict_types=1);
namespace ConfigTransformer202205308\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202205308\PhpParser\BuilderHelpers;
use ConfigTransformer202205308\PhpParser\Node\Arg;
use ConfigTransformer202205308\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202205308\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202205308\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ParentLazyServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202205308\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @param mixed $key
     * @param mixed $yaml
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer202205308\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202205308\PhpParser\Node\Expr\MethodCall
    {
        $method = $key;
        $methodCall = new \ConfigTransformer202205308\PhpParser\Node\Expr\MethodCall($methodCall, $method);
        $methodCall->args[] = new \ConfigTransformer202205308\PhpParser\Node\Arg(\ConfigTransformer202205308\PhpParser\BuilderHelpers::normalizeValue($values[$key]));
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return \in_array($key, [\ConfigTransformer202205308\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARENT, \ConfigTransformer202205308\Symplify\PhpConfigPrinter\ValueObject\YamlKey::LAZY], \true);
    }
}
