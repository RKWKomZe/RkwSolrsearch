<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:solr/Resources/Private/Language/locallang.xlf'][] = 'EXT:rkw_solrsearch/Resources/Private/Language/locallang.xlf';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('rkw_solrsearch', 'Configuration/TypoScript', 'RKW Solrsearch');
    }
);
