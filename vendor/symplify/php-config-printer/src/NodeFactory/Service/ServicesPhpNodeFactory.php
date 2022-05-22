<?php

declare (strict_types=1);
namespace ConfigTransformer2022052210\Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformer2022052210\PhpParser\Node\Arg;
use ConfigTransformer2022052210\PhpParser\Node\Expr;
use ConfigTransformer2022052210\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2022052210\PhpParser\Node\Expr\Variable;
use ConfigTransformer2022052210\PhpParser\Node\Scalar\String_;
use ConfigTransformer2022052210\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2022052210\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer2022052210\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\VariableName;
final class ServicesPhpNodeFactory
{
    /**
     * @var string
     */
    private const EXCLUDE = 'exclude';
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory
     */
    private $serviceOptionNodeFactory;
    public function __construct(\ConfigTransformer2022052210\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \ConfigTransformer2022052210\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer2022052210\Symplify\PhpConfigPrinter\NodeFactory\Service\ServiceOptionNodeFactory $serviceOptionNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->serviceOptionNodeFactory = $serviceOptionNodeFactory;
    }
    /**
     * @param mixed[] $serviceValues
     */
    public function createResource(string $serviceKey, array $serviceValues) : \ConfigTransformer2022052210\PhpParser\Node\Stmt\Expression
    {
        $servicesLoadMethodCall = $this->createServicesLoadMethodCall($serviceKey, $serviceValues);
        $decoratedMethodCall = $this->serviceOptionNodeFactory->convertServiceOptionsToNodes($serviceValues, $servicesLoadMethodCall);
        if (!isset($serviceValues[self::EXCLUDE])) {
            return new \ConfigTransformer2022052210\PhpParser\Node\Stmt\Expression($decoratedMethodCall);
        }
        $exclude = $serviceValues[self::EXCLUDE];
        if (!\is_array($exclude)) {
            $exclude = [$exclude];
        }
        /** @var array<int, Expr> $excludeValue */
        $excludeValue = [];
        foreach ($exclude as $key => $singleExclude) {
            $excludeValue[$key] = $this->commonNodeFactory->createAbsoluteDirExpr($singleExclude);
        }
        $args = $this->argsNodeFactory->createFromValues([$excludeValue]);
        $excludeMethodCall = new \ConfigTransformer2022052210\PhpParser\Node\Expr\MethodCall($decoratedMethodCall, self::EXCLUDE, $args);
        return new \ConfigTransformer2022052210\PhpParser\Node\Stmt\Expression($excludeMethodCall);
    }
    /**
     * @param mixed[] $serviceValues
     */
    private function createServicesLoadMethodCall(string $serviceKey, array $serviceValues) : \ConfigTransformer2022052210\PhpParser\Node\Expr\MethodCall
    {
        $servicesVariable = new \ConfigTransformer2022052210\PhpParser\Node\Expr\Variable(\ConfigTransformer2022052210\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES);
        $resource = $serviceValues['resource'];
        $args = [];
        $args[] = new \ConfigTransformer2022052210\PhpParser\Node\Arg(new \ConfigTransformer2022052210\PhpParser\Node\Scalar\String_($serviceKey));
        $args[] = new \ConfigTransformer2022052210\PhpParser\Node\Arg($this->commonNodeFactory->createAbsoluteDirExpr($resource));
        return new \ConfigTransformer2022052210\PhpParser\Node\Expr\MethodCall($servicesVariable, 'load', $args);
    }
}
