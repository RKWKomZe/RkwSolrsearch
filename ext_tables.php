<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:solr/Resources/Private/Language/locallang.xlf'][] = 'EXT:searchmaster/Resources/Private/Language/locallang_solr.xlf';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('searchmaster', 'Configuration/TypoScript', 'Searchmaster');
    }
);
