<?php

namespace FSL\Searchmaster\UserFunctions;


use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Resource\FileRepository;

/**
 * Class SolrIndexer
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Pascoe
 * @package PN_Pascoe
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