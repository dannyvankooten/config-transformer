<?php

declare (strict_types=1);
namespace ConfigTransformer2021120710\Symplify\PhpConfigPrinter\CaseConverter\NestedCaseConverter;

use ConfigTransformer2021120710\PhpParser\Node\Arg;
use ConfigTransformer2021120710\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021120710\PhpParser\Node\Expr\Variable;
use ConfigTransformer2021120710\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2021120710\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer2021120710\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory;
use ConfigTransformer2021120710\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer2021120710\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer2021120710\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class InstanceOfNestedCaseConverter
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(\ConfigTransformer2021120710\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \ConfigTransformer2021120710\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    public function convertToMethodCall(string $key, array $values) : \ConfigTransformer2021120710\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $servicesVariable = new \ConfigTransformer2021120710\PhpParser\Node\Expr\Variable(\ConfigTransformer2021120710\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
        $args = [new \ConfigTransformer2021120710\PhpParser\Node\Arg($classConstFetch)];
        $instanceofMethodCall = new \ConfigTransformer2021120710\PhpParser\Node\Expr\MethodCall($servicesVariable, \ConfigTransformer2021120710\Symplify\PhpConfigPrinter\ValueObject\MethodName::INSTANCEOF, $args);
        $decoreatedInstanceofMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($values, $instanceofMethodCall);
        return new \ConfigTransformer2021120710\PhpParser\Node\Stmt\Expression($decoreatedInstanceofMethodCall);
    }
    /**
     * @param mixed $subKey
     */
    public function isMatch(string $rootKey, $subKey) : bool
    {
        if ($rootKey !== \ConfigTransformer2021120710\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        if (!\is_string($subKey)) {
            return \false;
        }
        return $subKey === \ConfigTransformer2021120710\Symplify\PhpConfigPrinter\ValueObject\YamlKey::_INSTANCEOF;
    }
}
