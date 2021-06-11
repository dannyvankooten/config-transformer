<?php

declare (strict_types=1);
namespace ConfigTransformer202106117\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202106117\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202106117\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202106117\Symplify\PhpConfigPrinter\NodeFactory\Service\ServicesPhpNodeFactory;
use ConfigTransformer202106117\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class ResourceCaseConverter implements \ConfigTransformer202106117\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var ServicesPhpNodeFactory
     */
    private $servicesPhpNodeFactory;
    public function __construct(\ConfigTransformer202106117\Symplify\PhpConfigPrinter\NodeFactory\Service\ServicesPhpNodeFactory $servicesPhpNodeFactory)
    {
        $this->servicesPhpNodeFactory = $servicesPhpNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \ConfigTransformer202106117\PhpParser\Node\Stmt\Expression
    {
        // Due to the yaml behavior that does not allow the declaration of several identical key names.
        if (isset($values['namespace'])) {
            $key = $values['namespace'];
            unset($values['namespace']);
        }
        return $this->servicesPhpNodeFactory->createResource($key, $values);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        return isset($values[\ConfigTransformer202106117\Symplify\PhpConfigPrinter\ValueObject\YamlKey::RESOURCE]);
    }
}
