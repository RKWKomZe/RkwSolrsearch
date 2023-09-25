<?php
namespace FSL\Searchmaster\ExpressionLanguage;

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

use FSL\Searchmaster\ExpressionLanguage\Functions\IsSearchFunctionsProvider;
use TYPO3\CMS\Core\ExpressionLanguage\AbstractProvider;

/**
 * IsSearchProvider
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Christian Dilger
 * @package Searchmaster
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class IsSearchProvider extends AbstractProvider
{

    /**
     * @return void
     */
    public function __construct()
    {
        $this->expressionLanguageProviders = [
            IsSearchFunctionsProvider::class
        ];
    }

}
