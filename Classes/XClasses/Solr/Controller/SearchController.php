<?php
namespace FSL\Searchmaster\XClasses\Solr\Controller;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use ApacheSolrForTypo3\Solr\System\Solr\SolrUnavailableException;
use ApacheSolrForTypo3\Solr\Util;

/**
 * Class SearchController
 *
 * @author Frans Saris <frans@beech.it>
 * @author Timo Hund <timo.hund@dkd.de>
 * @author Christian Dilger <c.dilger@addorange.de>
 */
class SearchController extends \ApacheSolrForTypo3\Solr\Controller\SearchController
{

    /**
     * Results
     */
    public function resultsAction()
    {
        try {
            $arguments = (array)$this->request->getArguments();
            $pageId = $this->typoScriptFrontendController->getRequestedId();
            $languageId = Util::getLanguageUid();
            $searchRequest = $this->getSearchRequestBuilder()->buildForSearch($arguments, $pageId, $languageId);

            $searchResultSet = $this->searchService->search($searchRequest);

            // we pass the search result set to the controller context, to have the possibility
            // to access it without passing it from partial to partial
            $this->controllerContext->setSearchResultSet($searchResultSet);

            $values = [
                'additionalFilters' => $this->getAdditionalFilters(),
                'resultSet' => $searchResultSet,
                'pluginNamespace' => $this->typoScriptConfiguration->getSearchPluginNamespace(),
                'arguments' => $arguments,
                'settings' => $this->settings
            ];

            $values = $this->emitActionSignal(__CLASS__, __FUNCTION__, [$values]);

            $this->view->assignMultiple($values);
        } catch (SolrUnavailableException $e) {
            $this->handleSolrUnavailable();
        }
    }

}
