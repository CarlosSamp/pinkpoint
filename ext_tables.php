<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Csp.Pinkpoint',
            'Pinkpoint',
            'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:startpage'
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Csp.Pinkpoint',
            'ClimberPage',
            'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:climber_page'
        );
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Csp.Pinkpoint',
            'ClimberRegister',
            'LLL:EXT:pinkpoint/Resources/Private/Language/locallang_db.xlf:climber_registration'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('pinkpoint', 'Configuration/TypoScript', 'Pinkpoint');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pinkpoint_domain_model_sector', 'EXT:pinkpoint/Resources/Private/Language/locallang_csh_tx_pinkpoint_domain_model_sector.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pinkpoint_domain_model_sector');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pinkpoint_domain_model_route', 'EXT:pinkpoint/Resources/Private/Language/locallang_csh_tx_pinkpoint_domain_model_route.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pinkpoint_domain_model_route');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pinkpoint_domain_model_ascent', 'EXT:pinkpoint/Resources/Private/Language/locallang_csh_tx_pinkpoint_domain_model_ascent.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pinkpoint_domain_model_ascent');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pinkpoint_domain_model_routerating', 'EXT:pinkpoint/Resources/Private/Language/locallang_csh_tx_pinkpoint_domain_model_routerating.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pinkpoint_domain_model_routerating');

    }
);
