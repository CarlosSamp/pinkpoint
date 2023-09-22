<?php


$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['pinkpoint_climberregister'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    // plugin signature: <extension key without underscores> '_' <plugin name in lowercase>
    'pinkpoint_climberregister',
    // Flexform configuration schema file
    'FILE:EXT:pinkpoint/Configuration/FlexForms/flexform_register.xml'
);

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['pinkpoint_pinkpoint'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    // plugin signature: <extension key without underscores> '_' <plugin name in lowercase>
    'pinkpoint_pinkpoint',
    // Flexform configuration schema file
    'FILE:EXT:pinkpoint/Configuration/FlexForms/flexform_pinkpoint.xml'
);
