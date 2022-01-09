<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace ConfigTransformer202201094\Nette\Utils;

use ConfigTransformer202201094\Nette;
if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString extends \ConfigTransformer202201094\Nette\HtmlStringable
    {
    }
} elseif (!\interface_exists(\ConfigTransformer202201094\Nette\Utils\IHtmlString::class)) {
    \class_alias(\ConfigTransformer202201094\Nette\HtmlStringable::class, \ConfigTransformer202201094\Nette\Utils\IHtmlString::class);
}
namespace ConfigTransformer202201094\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator extends \ConfigTransformer202201094\Nette\Localization\Translator
    {
    }
} elseif (!\interface_exists(\ConfigTransformer202201094\Nette\Localization\ITranslator::class)) {
    \class_alias(\ConfigTransformer202201094\Nette\Localization\Translator::class, \ConfigTransformer202201094\Nette\Localization\ITranslator::class);
}
