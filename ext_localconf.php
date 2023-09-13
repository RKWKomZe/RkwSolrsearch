<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;

if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

call_user_func(
    function($extKey)
    {
/*

        $extbaseObjectContainer = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\Container\Container::class);
        $extbaseObjectContainer->registerImplementation(
                \ApacheSolrForTypo3\Solr\Controller\AbstractBaseController::class,
                \FSL\Searchmaster\Controller\AbstractBaseController::class
            );

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\ApacheSolrForTypo3\Solr\Controller\AbstractBaseController::class] = [
            'className' => \FSL\Searchmaster\Controller\AbstractBaseController::class
        ];
*/

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][\ApacheSolrForTypo3\Solr\Domain\Search\Uri\SearchUriBuilder::class] = [
            'className' => \FSL\Searchmaster\XClasses\Solr\Domain\Search\Uri\SearchUriBuilder::class
        ];

    },
    $_EXTKEY
);
