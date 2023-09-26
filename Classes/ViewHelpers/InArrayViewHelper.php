<?php
namespace FSL\Searchmaster\ViewHelpers;

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
 * Class InArrayViewHelper
 *
 * @author Carlos Meyer <cm@davitec.de>
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package Searchmaster
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class InArrayViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('needle', 'string', 'The term to look for.');
        $this->registerArgument('haystack', 'mixed', 'List of terms.');
    }

    /**
     * returns true, if the given needle is in given haystack (string-list from Flexform)
     *
     * @return bool
     */
    public function render(): bool
    {
        $needle = $this->arguments['needle'];
        $haystack = $this->arguments['haystack'];

        $haystackArray = (is_array($haystack)) ? $haystack : array_map('trim', explode(',', $haystack));

        if (in_array($needle, $haystackArray)) {
            return true;
        }

        return false;
    }


}
