<?php

declare(strict_types=1);

/*
 * This file is part of DynamicFormRecipientBundle.
 *
 * @author Codefog <https://codefog.pl>
 *
 * @license MIT
 */

namespace Codefog\DynamicFormRecipientBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CodefogDynamicFormRecipientBundle extends Bundle
{
    public function getPath()
    {
        return \dirname(__DIR__);
    }
}
