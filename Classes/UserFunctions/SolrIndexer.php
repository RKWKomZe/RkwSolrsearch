<?php
namespace RKW\RkwSolrsearch\UserFunctions;

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

use Doctrine\DBAL\Driver\Exception;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Class SolrIndexer
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwSolrsearch
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
     * @return string
     */
    public function getCategoryDisplayed($content, $conf): string
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

        // return empty string to avoid creating non-existing entries / facets
        return '';
    }


    /**
     * Returns semicolon seperated string with author name (list)
     *
     * Maybe put this function into a new userFunc class for pages index function? ("PagesIndexer")
     *
     * @param $content
     * @param $conf
     * @return string
     * @throws Exception
     */
    public function getAuthorNameMultiple($content, $conf): string
    {
        $record = $this->cObj->data;

        $authorArray = [];

        // ### PAGES (connected via MM-Table with authors) ###
        if (!empty($record['tx_rkwauthors_authorship'])) {
            $tableName = 'tx_rkwauthors_domain_model_authors';

            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable($tableName)
                ->createQueryBuilder();
            $result = $queryBuilder
                ->select(
                    'authors.first_name',
                    'authors.middle_name',
                    'authors.last_name',
                    'authors.title_before',
                    'authors.title_after'
                )
                ->from($tableName, 'authors')
                ->from('tx_rkwauthors_pages_authors_mm', 'mm_page_auth')
                ->where(
                    $queryBuilder->expr()->eq('mm_page_auth.uid_local', 11915),
                    $queryBuilder->expr()->eq('authors.uid', 'mm_page_auth.uid_foreign')
                )
                ->execute();

            while ($author = $result->fetchAssociative()) {

                if (!$author['last_name']) {
                    continue;
                }

                $name = $author['last_name'];

                if ($author['middle_name']) {
                    $name = $author['middle_name'] . ' ' . $name;
                }

                if ($author['first_name']) {
                    $name = $author['first_name'] . ' ' . $name;
                }

                // @toDo: Use title_before and title_after?
                if ($author['title_before']) {
                    $name = $author['title_before'] . ' ' . $name;
                }

                if ($author['title_after']) {
                    $name .= ', ' . $author['title_after'];
                }

                $authorArray[] = $name;
            }
        }

        // return empty string to avoid creating non-existing entries / facets
        return implode(';', $authorArray);

    }

    /**
     * Returns comma separated string with the category titles associated with series
     * @param $content
     * @param $conf
     * @return string
     * @throws Exception
     */
    public function getCategoriesFromSeries($content, $conf): string
    {
        $record = $this->cObj->data;

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $eventSeriesRepository = $objectManager->get('RKW\RkwEvents\Domain\Repository\EventSeriesRepository');
        $series = $eventSeriesRepository->findByUid((int)$record['series']);

        $categories = [];
        if ($series && $series->getCategories()) {
            foreach ($series->getCategories() as $category) {
                if ($category instanceof \TYPO3\CMS\Extbase\Domain\Model\Category) {
                    $categories[] = $category->getTitle();
                }
            }
        }

        return implode(', ', $categories);
    }

}
