<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Csp.Pinkpoint',
            'Pinkpoint',
            [
                'Sector' => 'list, show, new, create, edit, update, delete, request, release',

                'Ascent' => 'list, show, new, create',
                'Route' => 'list, show, new, create, edit, update, delete',
                'RouteRating' => ''
            ],
            // non-cacheable actions
            [
                'Sector' => 'show, list, new, create, update, delete, edit, request, release',

                'Ascent' => 'list, show, new, create',
                'Route' => 'list, show, new, create, update, delete, edit',
                'RouteRating' => ''
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Csp.Pinkpoint',
            'ClimberPage',
            [
                'Climber' => 'show, publicShow, new, create, edit, update, delete',
                'Sector' => 'show',
                'Ascent' => 'update, delete, edit',
                'Route' => 'show, delete, edit'
            ],
            // non-cacheable actions
            [
                'Climber' => 'show, publicShow, new, create, update, delete, edit',
                'Sector' => 'list, show',
                'Ascent' => 'update, delete, edit',
                'Route' => 'show, delete, edit'

            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Csp.Pinkpoint',
            'ClimberRegister',
            [
                'Climber' => 'new, create, welcome, edit'
            ],
            // non-cacheable actions
            [
                'Climber' => 'new, create, welcome'

            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    pinkpoint {
                        iconIdentifier = pinkpoint-plugin-pinkpoint
                        title = LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_pinkpoint.name
                        description = LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:tx_pinkpoint_pinkpoint.description
                        tt_content_defValues {
                            CType = list
                            list_type = pinkpoint_pinkpoint
                        }
                    }
                }
                show = *
            }
       }'
    );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

			$iconRegistry->registerIcon(
				'pinkpoint-plugin-pinkpoint',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:pinkpoint/Resources/Public/Icons/user_plugin_pinkpoint.svg']
			);
            $iconRegistry->registerIcon(
				'edit',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:pinkpoint/Resources/Public/Icons/edit_icon.svg']
			);

    }
);
