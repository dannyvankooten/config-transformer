<?php

declare (strict_types=1);
namespace ConfigTransformer2021120610\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer2021120610\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021120610\PhpParser\Node\Expr\Variable;
use ConfigTransformer2021120610\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2021120610\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer2021120610\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer2021120610\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer2021120610\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer2021120610\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ExtensionConverter implements \ConfigTransformer2021120610\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var string|null
     */
    private $rootKey;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer2021120610\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer2021120610\PhpParser\Node\Stmt\Expression
    {
        $args = $this->argsNodeFactory->createFromValues([$this->rootKey, [$key => $values]]);
        $containerConfiguratorVariable = new \ConfigTransformer2021120610\PhpParser\Node\Expr\Variable(\ConfigTransformer2021120610\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $methodCall = new \ConfigTransformer2021120610\PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, \ConfigTransformer2021120610\Symplify\PhpConfigPrinter\ValueObject\MethodName::EXTENSION, $args);
        return new \ConfigTransformer2021120610\PhpParser\Node\Stmt\Expression($methodCall);
    }
    /**
     * @param mixed $key
     * @param mixed $values
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool
    {
        $this->rootKey = $rootKey;
        return !\in_array($rootKey, \ConfigTransformer2021120610\Symplify\PhpConfigPrinter\ValueObject\YamlKey::provideRootKeys(), \true);
    }
}
