<?php
defined('TYPO3_MODE') || die();

if (!isset($GLOBALS['TCA']['fe_users']['ctrl']['type'])) {
    // no type field defined, so we define it here. This will only happen the first time the extension is installed!!
    $GLOBALS['TCA']['fe_users']['ctrl']['type'] = 'tx_extbase_type';
    $tempColumnstx_pinkpoint_fe_users = [];
    $tempColumnstx_pinkpoint_fe_users[$GLOBALS['TCA']['fe_users']['ctrl']['type']] = [
        'exclude' => true,
        'label'   => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint.tx_extbase_type',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['',''],
                ['Climber','Tx_Pinkpoint_Climber']
            ],
            'default' => 'Tx_Pinkpoint_Climber',
            'size' => 1,
            'maxitems' => 1,
        ]
    ];
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users', $tempColumnstx_pinkpoint_fe_users);
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'fe_users',
    $GLOBALS['TCA']['fe_users']['ctrl']['type'],
    '',
    'after:' . $GLOBALS['TCA']['fe_users']['ctrl']['label']
);

$tmp_pinkpoint_columns = [

    'country' => [
        'exclude' => true,
        'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_climber.country',
        'config' => [
            'appearance' => [
                'collapseAll' => 1,
            ],
            'type' => 'select',
            'items' => [
                ['', 0],
            ],
            'foreign_table' => 'static_countries',
            'foreign_table_where' => 'ORDER BY static_countries.cn_short_en',
            'itemsProcFunc' => 'SJBR\\StaticInfoTables\\Hook\\Backend\\Form\\FormDataProvider\\TcaSelectItemsProcessor->translateCountriesSelector',
            'itemsProcFunc_config' => [
              'indexField' => 'cn_short_en',
            ],
            'size' => 1,
            'minitems' => 0,
            'maxitems' => 1,
            'wizards' => [
                'suggest' => [
                    'type' => 'suggest',
                    'default' => [
                        'receiverClass' => 'SJBR\\StaticInfoTables\\Hook\\Backend\\Form\\Wizard\\SuggestReceiver',
                    ],
                ],
            ],
        ],
    ],

    'gender' => [
        'exclude' => true,
        'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_climber.gender',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['', 0],
                ['LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_climber.gender.1', 1],
                ['LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_climber.gender.2', 2],
            ],
            'default' => 0,
        ],
    ],

    'avatarimage' => [
        'exclude' => true,
        'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_climber.avatarimage',
        'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
            'image',
            [
                'appearance' => [
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                ],
                'foreign_match_fields' => [
                    'fieldname' => 'avatarimage',
                    'tablenames' => 'fe_users',
                    'table_local' => 'sys_file',
                ],
                'foreign_types' => [
                    '0' => [
                        'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                        'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                        'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                        'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                        'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                    ],
                    \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                        'showitem' => '
                        --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                        --palette--;;filePalette',
                    ],
                ],

            ],
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
        ),
    ],

    'ascents' => [
        'exclude' => true,
        'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_climber.ascents',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_pinkpoint_domain_model_ascent',
            'foreign_field' => 'climber',
            'maxitems' => 9999,
            'appearance' => [
                'collapseAll' => 1,
                'levelLinksPosition' => 'top',
                'showSynchronizationLink' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ],
        ],

    ],
    'sectors' => [
        'exclude' => true,
        'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_sector.sector_admins',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectMultipleSideBySide',
            'foreign_table' => 'tx_pinkpoint_domain_model_sector',
            'MM' => 'tx_pinkpoint_sector_climber_mm',
            'items' => [
                ['', 0],
            ],
            'size' => 5,
            'minitems' => 0,
            'maxitems' => 10,

        ],

    ],
    'rating' => [
        'exclude' => true,
        'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_climber.ratings',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_pinkpoint_domain_model_routerating',
            'foreign_field' => 'climber',
            'minitems' => 0,
            'maxitems' => 99999,
            'appearance' => [
                'collapseAll' => 0,
                'levelLinksPosition' => 'top',
                'showSynchronizationLink' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ],
        ],
    ],

    'message_box' => [
        'exclude' => true,
        'label' => 'Message Box',
        'config' => [
            'type' => 'inline',
            'foreign_table' => 'tx_femessage_domain_model_feusermessagebox',
            'foreign_field' => 'user',
            'maxitems' => 1,
            'appearance' => [
                'collapseAll' => 0,
                'levelLinksPosition' => 'top',
                'showSynchronizationLink' => 1,
                'showPossibleLocalizationRecords' => 1,
                'showAllLocalizationLink' => 1
            ],
        ],

    ],

];

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('fe_users',$tmp_pinkpoint_columns);

/* inherit and extend the show items from the parent class */

if (isset($GLOBALS['TCA']['fe_users']['types']['0']['showitem'])) {
    $GLOBALS['TCA']['fe_users']['types']['Tx_Pinkpoint_Climber']['showitem'] = $GLOBALS['TCA']['fe_users']['types']['0']['showitem'];
} elseif(is_array($GLOBALS['TCA']['fe_users']['types'])) {
    // use first entry in types array
    $fe_users_type_definition = reset($GLOBALS['TCA']['fe_users']['types']);
    $GLOBALS['TCA']['fe_users']['types']['Tx_Pinkpoint_Climber']['showitem'] = $fe_users_type_definition['showitem'];
} else {
    $GLOBALS['TCA']['fe_users']['types']['Tx_Pinkpoint_Climber']['showitem'] = '';
}
$GLOBALS['TCA']['fe_users']['types']['Tx_Pinkpoint_Climber']['showitem'] .= ',--div--;LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_climber,';
$GLOBALS['TCA']['fe_users']['types']['Tx_Pinkpoint_Climber']['showitem'] .= 'country, gender, avatarimage, sectors, ascents, rating, message_box';

$GLOBALS['TCA']['fe_users']['columns'][$GLOBALS['TCA']['fe_users']['ctrl']['type']]['config']['items'][] = ['LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:fe_users.tx_extbase_type.Tx_Pinkpoint_Climber','Tx_Pinkpoint_Climber'];
