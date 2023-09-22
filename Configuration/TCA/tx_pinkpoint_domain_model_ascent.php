<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_ascent',
        'label' => 'ascent_date',
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
        'searchFields' => 'comment',
        'iconfile' => 'EXT:pinkpoint/Resources/Public/Icons/tx_pinkpoint_domain_model_ascent.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, ascent_date, ascent_art, public_visible, comment, route, climber',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, ascent_date, ascent_art, public_visible, comment, route, climber, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
                'foreign_table' => 'tx_pinkpoint_domain_model_ascent',
                'foreign_table_where' => 'AND {#tx_pinkpoint_domain_model_ascent}.{#pid}=###CURRENT_PID### AND {#tx_pinkpoint_domain_model_ascent}.{#sys_language_uid} IN (-1,0)',
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

        'ascent_date' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_ascent.ascent_date',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'size' => 10,
                'eval' => 'datetime',
                'default' => null
            ],
        ],
        'ascent_art' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_ascent.ascent_art',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['Ohne', 0],
                    ['OnSight', 1],
                    ['Flash', 2],
                    ['RedPoint', 3],
                    ['All Free', 4],
                    ['Top Rope', 5]
                ],
                'minitems' => 0,
                'maxitems' => 1,
                'eval' => ''
            ],
        ],
        'public_visible' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_ascent.public_visible',
            'config' => [
                'type' => 'check',
                'items' => [
                    '1' => [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled'
                    ]
                ],
                'default' => 0,
            ]
        ],
        'comment' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_ascent.comment',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'route' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_ascent.route',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_pinkpoint_domain_model_route',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],

        'climber' => [
            'exclude' => true,
            'label' => 'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_domain_model_climber',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'fe_users',
                'foreign_table_where' => 'AND {#tx_extbase_type} LIKE \'%Tx_Pinkpoint_Climber%\' ORDER BY uid',
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],
    ],
];
