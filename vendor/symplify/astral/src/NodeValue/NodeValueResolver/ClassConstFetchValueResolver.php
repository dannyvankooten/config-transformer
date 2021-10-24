<?php

declare (strict_types=1);
namespace ConfigTransformer202110248\Symplify\Astral\NodeValue\NodeValueResolver;

use ConfigTransformer202110248\PhpParser\Node\Expr;
use ConfigTransformer202110248\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer202110248\PhpParser\Node\Stmt\ClassLike;
use ReflectionClassConstant;
use ConfigTransformer202110248\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface;
use ConfigTransformer202110248\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202110248\Symplify\Astral\NodeFinder\SimpleNodeFinder;
/**
 * @see \Symplify\Astral\Tests\NodeValue\NodeValueResolverTest
 *
 * @implements NodeValueResolverInterface<ClassConstFetch>
 */
final class ClassConstFetchValueResolver implements \ConfigTransformer202110248\Symplify\Astral\Contract\NodeValueResolver\NodeValueResolverInterface
{
    /**
     * @var \Symplify\Astral\Naming\SimpleNameResolver
     */
    private $simpleNameResolver;
    /**
     * @var \Symplify\Astral\NodeFinder\SimpleNodeFinder
     */
    private $simpleNodeFinder;
    public function __construct(\ConfigTransformer202110248\Symplify\Astral\Naming\SimpleNameResolver $simpleNameResolver, \ConfigTransformer202110248\Symplify\Astral\NodeFinder\SimpleNodeFinder $simpleNodeFinder)
    {
        $this->simpleNameResolver = $simpleNameResolver;
        $this->simpleNodeFinder = $simpleNodeFinder;
    }
    public function getType() : string
    {
        return \ConfigTransformer202110248\PhpParser\Node\Expr\ClassConstFetch::class;
    }
    /**
     * @param \PhpParser\Node\Expr $expr
     * @return null|string|mixed
     * @param string $currentFilePath
     */
    public function resolve($expr, $currentFilePath)
    {
        $className = $this->simpleNameResolver->getName($expr->class);
        if ($className === 'self') {
            $classLike = $this->simpleNodeFinder->findFirstParentByType($expr, \ConfigTransformer202110248\PhpParser\Node\Stmt\ClassLike::class);
            if (!$classLike instanceof \ConfigTransformer202110248\PhpParser\Node\Stmt\ClassLike) {
                return null;
            }
            $className = $this->simpleNameResolver->getName($classLike);
        }
        if ($className === null) {
            return null;
        }
        $constantName = $this->simpleNameResolver->getName($expr->name);
        if ($constantName === null) {
            return null;
        }
        if ($constantName === 'class') {
            return $className;
        }
        if (!\class_exists($className) && !\interface_exists($className)) {
            return null;
        }
        $reflectionClassConstant = new \ReflectionClassConstant($className, $constantName);
        return $reflectionClassConstant->getValue();
    }
}
