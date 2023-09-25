<?php
namespace FSL\Searchmaster\ExpressionLanguage\Functions;

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

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

/**
 * IsSearchFunctionsProvider
 *
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright Christian Dilger
 * @package Searchmaster
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class IsSearchFunctionsProvider implements ExpressionFunctionProviderInterface
{
    /**
     * @return ExpressionFunction[]
     */
    public function getFunctions(): array
    {
        return [
            $this->getIsSearchFunction(),
        ];
    }


    /**
     * @return ExpressionFunction
     */
    protected function getIsSearchFunction(): ExpressionFunction
    {
        return new ExpressionFunction('isSearch', function () {
            // Not implemented, we only use the evaluator
        }, function ($existingVariables, $extensionName) {
            return \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded($extensionName);
        });
    }

}
