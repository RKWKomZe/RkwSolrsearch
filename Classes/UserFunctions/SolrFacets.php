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

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class SolrFacets
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package Searchmaster
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SolrFacets
{
    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
     */
    public $cObj;

    /**
     * Returns translated month to facet selection field
     *
     * @return string
     */
    public function getMonthName(): string
    {
        $now = new \DateTime();
        $baseDate = $now->modify('first day of this month');
        $selectableMonth = $baseDate->modify('first day of ' . $this->cObj->data['optionValue'] . ' months');

        return LocalizationUtility::translate(
            'tx_rkwevents_fluid.partials_event_list.month' . $selectableMonth->format('m'),
            'RkwEvents'
        ) . ' ' . $selectableMonth->format('Y');
    }
}
