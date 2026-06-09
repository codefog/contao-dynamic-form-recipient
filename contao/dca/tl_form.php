<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Doctrine\DBAL\Types\Types;

// Palettes
PaletteManipulator::create()
    ->addField(['dynamicRecipientField', 'dynamicRecipientList'], 'nc_notification')
    ->applyToPalette('default', 'tl_form');

// Fields
$GLOBALS['TL_DCA']['tl_form']['fields']['dynamicRecipientList'] = [
    'exclude' => true,
    'inputType' => 'keyValueWizard',
    'eval' => ['multiple' => true, 'tl_class' => 'clr'],
    'sql' => ['type' => Types::BLOB, 'notnull' => false],
];

$GLOBALS['TL_DCA']['tl_form']['fields']['dynamicRecipientField'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['decodeEntities' => true, 'tl_class' => 'w50'],
    'sql' => ['type' => Types::STRING, 'length' => 255, 'default' => ''],
];
