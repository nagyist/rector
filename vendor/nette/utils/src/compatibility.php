<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */
declare (strict_types=1);
namespace RectorPrefix20210728\Nette\Utils;

use RectorPrefix20210728\Nette;
if (\false) {
    /** @deprecated use Nette\HtmlStringable */
    interface IHtmlString extends \RectorPrefix20210728\Nette\HtmlStringable
    {
    }
} elseif (!\interface_exists(\RectorPrefix20210728\Nette\Utils\IHtmlString::class)) {
    \class_alias(\RectorPrefix20210728\Nette\HtmlStringable::class, \RectorPrefix20210728\Nette\Utils\IHtmlString::class);
}
namespace RectorPrefix20210728\Nette\Localization;

if (\false) {
    /** @deprecated use Nette\Localization\Translator */
    interface ITranslator extends \RectorPrefix20210728\Nette\Localization\Translator
    {
    }
} elseif (!\interface_exists(\RectorPrefix20210728\Nette\Localization\ITranslator::class)) {
    \class_alias(\RectorPrefix20210728\Nette\Localization\Translator::class, \RectorPrefix20210728\Nette\Localization\ITranslator::class);
}
