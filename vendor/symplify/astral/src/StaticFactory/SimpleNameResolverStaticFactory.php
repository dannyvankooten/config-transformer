<?php

declare (strict_types=1);
namespace ConfigTransformer2021113010\Symplify\Astral\StaticFactory;

use ConfigTransformer2021113010\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\ArgNodeNameResolver;
use ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\AttributeNodeNameResolver;
use ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\ClassLikeNodeNameResolver;
use ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\ClassMethodNodeNameResolver;
use ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\ConstFetchNodeNameResolver;
use ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\FuncCallNodeNameResolver;
use ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\IdentifierNodeNameResolver;
use ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\NamespaceNodeNameResolver;
use ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\ParamNodeNameResolver;
use ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\PropertyNodeNameResolver;
/**
 * This would be normally handled by standard Symfony or Nette DI, but PHPStan does not use any of those, so we have to
 * make it manually.
 */
final class SimpleNameResolverStaticFactory
{
    public static function create() : \ConfigTransformer2021113010\Symplify\Astral\Naming\SimpleNameResolver
    {
        $nameResolvers = [new \ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\ArgNodeNameResolver(), new \ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\AttributeNodeNameResolver(), new \ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\ClassLikeNodeNameResolver(), new \ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\ClassMethodNodeNameResolver(), new \ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\ConstFetchNodeNameResolver(), new \ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\FuncCallNodeNameResolver(), new \ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\IdentifierNodeNameResolver(), new \ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\NamespaceNodeNameResolver(), new \ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\ParamNodeNameResolver(), new \ConfigTransformer2021113010\Symplify\Astral\NodeNameResolver\PropertyNodeNameResolver()];
        return new \ConfigTransformer2021113010\Symplify\Astral\Naming\SimpleNameResolver($nameResolvers);
    }
}
