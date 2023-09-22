<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_route',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'name,description',
        'iconfile' => 'EXT:pinkpoint/Resources/Public/Icons/tx_pinkpoint_domain_model_route.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, grade, length, sector, description, sector_count, rating',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, grade, length, sector, description, sector_count, rating, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_pinkpoint_domain_model_route',
                'foreign_table_where' => 'AND {#tx_pinkpoint_domain_model_route}.{#pid}=###CURRENT_PID### AND {#tx_pinkpoint_domain_model_route}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'name' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_route.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'grade' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_route.grade',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['3', 0],
                    ['4', 1],
                    ['5A', 2],
                    ['5A+', 3],
                    ['5B', 4],
                    ['5B+', 5],
                    ['5C', 6],
                    ['5C+', 7],
                    ['6A', 8],
                    ['6A+', 9],
                    ['6B', 10],
                    ['6B+', 11],
                    ['6C', 12],
                    ['6C+', 13],
                    ['7A', 14],
                    ['7A+', 15],
                    ['7B', 16],
                    ['7B+', 17],
                    ['7C', 18],
                    ['7C+', 19],
                    ['8A', 20],
                    ['8A+', 21],
                    ['8B', 22],
                    ['8B+', 23],
                    ['8C', 24],
                    ['8C+', 25],
                    ['9A', 26],
                    ['9A+', 27],
                    ['9B', 28],
                    ['9B+', 29],
                    ['9C', 30],
                ],
            ],
        ],
        'length' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_route.length',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int',
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_route.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                    'fullScreenRichtext' => [
                        'disabled' => false,
                    ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim',
            ],

        ],
        'sector_count' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_route.sector_count',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ]
        ],
        'sector' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_route.sector',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_pinkpoint_domain_model_sector',
                'MM_opposite_field' => 'routes',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
        'ratings' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_route.ratings',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tx_pinkpoint_domain_model_routerating',
                'foreign_field' => 'route',
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

    ],
];
