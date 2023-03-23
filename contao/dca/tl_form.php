<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;

// Palettes
PaletteManipulator::create()
    ->addField(['dynamicRecipientField', 'dynamicRecipientList'], 'nc_notification', PaletteManipulator::POSITION_AFTER)
    ->applyToPalette('default', 'tl_form');

// Fields
$GLOBALS['TL_DCA']['tl_form']['fields']['dynamicRecipientList'] = [
    'exclude' => true,
    'inputType' => 'keyValueWizard',
    'eval' => ['multiple' => true, 'tl_class' => 'clr'],
    'sql' => ['type' => 'blob', 'notnull' => false],
];

$GLOBALS['TL_DCA']['tl_form']['fields']['dynamicRecipientField'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => ['decodeEntities' => true, 'tl_class' => 'w50'],
    'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
];
