<?php
namespace FSL\Searchmaster\UserFunctions;

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

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class SolrIndexer
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package Searchmaster
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SolrIndexer
{
    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    public $cObj;

    /**
     * Returns string with category title
     *
     * @param $content
     * @param $conf
     * @return mixed
     */
    public function getCategoryDisplayed($content, $conf)
    {
        $record = $this->cObj->data;

        if (!empty($record['categories_displayed'])) {
            $tableName = 'sys_category';

            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable($tableName)
                ->createQueryBuilder();
            $result = $queryBuilder
                ->select('title')
                ->from($tableName)
                ->where(
                    $queryBuilder->expr()->eq('uid', $record['categories_displayed'])
                )
                ->execute();

            while ($row = $result->fetch()) {
                if (isset($row['title'])) {
                    return $row['title'];
                }
            }
        }

        // return nothing, to avoid creating non-existing entries / facets
        return null;
    }

}
