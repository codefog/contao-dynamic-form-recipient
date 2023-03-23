<?php

if (is_array($GLOBALS['TL_HOOKS']['processFormData']) && ($index = array_search(['NotificationCenter\tl_form', 'sendFormNotification'], $GLOBALS['TL_HOOKS']['processFormData'], true)) !== false) {
    $GLOBALS['TL_HOOKS']['processFormData'][$index] = [\Codefog\DynamicFormRecipientBundle\EventListener\ProcessFormDataListener::class, 'onProcessFormData'];
}
