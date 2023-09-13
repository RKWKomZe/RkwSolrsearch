<?php
namespace FSL\Searchmaster\XClasses\Solr\Domain\Search\Uri;

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

use ApacheSolrForTypo3\Solr\Domain\Search\SearchRequest;

/**
 * SearchUriBuilder
 *
 * Responsibility:
 *
 * The SearchUriBuilder is responsible to build uris, that are used in the
 * searchContext. It can use the previous request with it's persistent
 * arguments to build the url for a search sub request.
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 */
class SearchUriBuilder extends \ApacheSolrForTypo3\Solr\Domain\Search\Uri\SearchUriBuilder
{

    /**
     * @param SearchRequest $previousSearchRequest
     * @param $facetName
     * @param $facetValue
     * @return string
     */
    public function getAddUniqueFacetValueUri(SearchRequest $previousSearchRequest, $facetName, $facetValue)
    {
        $persistentAndFacetArguments = $previousSearchRequest
            ->getCopyForSubRequest()
            ->removeAllGroupItemPages()

            // START edit
            // Remove all items of given facet before adding the new one
            ->removeAllFacetValuesByName($facetName)
            // END edit

            ->addFacetValue($facetName, $facetValue)
            ->getAsArray();

        $additionalArguments = $this->getAdditionalArgumentsFromRequestConfiguration($previousSearchRequest);
        $additionalArguments = is_array($additionalArguments) ? $additionalArguments : [];

        $arguments = $persistentAndFacetArguments + $additionalArguments;

        $pageUid = $this->getTargetPageUidFromRequestConfiguration($previousSearchRequest);
        return $this->buildLinkWithInMemoryCache($pageUid, $arguments);
    }

}
