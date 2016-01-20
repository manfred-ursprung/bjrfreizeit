<?php
namespace Bjr\BjrLend\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Manfred Ursprung <manfred.ursprung@aisys-media.de>, Aisys
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package bjr_lend
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * Description :  from the basket item get issue date from and issue date end
 *
 */

class DurationIssueViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     *
     * @param  \Bjr\BjrLend\Domain\Model\PositionInterface $basketItem
     * @return string the rendered string
     * @api
     */
    public function render($basketItem = NULL) {
		/* @var $basketItem \Bjr\BjrLend\Domain\Model\PositionInterface */
		if($basketItem === null){
			$basketItem = $this->renderChildren();
		}
		$startDay = $basketItem->getIssueStartDay();
		$endDay   = $basketItem->getIssueEndDay();
		$content  = $startDay . '-' . $endDay;

        return $content;
    }


}