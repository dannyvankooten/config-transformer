<?php

declare (strict_types=1);
namespace ConfigTransformer202110314\Symplify\Astral\Bundle;

use ConfigTransformer202110314\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202110314\Symplify\Astral\DependencyInjection\Extension\AstralExtension;
final class AstralBundle extends \ConfigTransformer202110314\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202110314\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202110314\Symplify\Astral\DependencyInjection\Extension\AstralExtension();
    }
}
