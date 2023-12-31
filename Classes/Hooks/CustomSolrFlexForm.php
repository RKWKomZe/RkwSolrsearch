<?php
namespace RKW\RkwSolrsearch\Hooks;

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

/**
 * Class CustomSolrFlexForm
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwSolrsearch
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CustomSolrFlexForm
{
    /**
     * @var string
     */
    protected $path = 'FILE:EXT:rkw_solrsearch/Configuration/FlexForms/Results.xml';

    /**
     * @return void
     */
    public function overwrite(): void
    {
        $GLOBALS['TCA']['tt_content']['columns']['pi_flexform']['config']['ds']['solr_pi_results,list']
            = $this->path;
    }
}
