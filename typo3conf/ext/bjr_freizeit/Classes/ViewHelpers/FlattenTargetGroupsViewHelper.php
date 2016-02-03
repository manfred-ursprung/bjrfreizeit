<?php
namespace MUM\BjrFreizeit\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Manfred Ursprung <manfred.ursprung@aisys-media.de>, Aisys
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
use MUM\BjrFreizeit\Domain\Model\Leisure;
use MUM\BjrFreizeit\Domain\Model\TargetGroup;

/**
 *
 *
 * @package bjr_freizeit
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * Description :  get all names of targetGroup of a leisure
 *
 */
// wird noch nicht verwendet !!!!!!
class FlattenTargetGroupsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {


    public function initializeArguments(){
        //$this->registerArgument('leisure', '')
    }
    /**
     *
     * @param  string $mode
     * @return string the rendered string
     * @api
     */
    public function render($mode = NULL) {
        $output = '';
        /** @var  $leisure  Leisure */
        //$leisure = ($this->arguments['leisure']) ? $this->arguments['leisure'] : $this->renderChildren();
        $leisure = $this->renderChildren();
        if($leisure == NULL){
            return 'No Leisure given';
        }
        return "Leisure " . print_r($leisure);
        /** @var  $tGroup TargetGroup */
        foreach($leisure->getTargetGroup() as $tGroup){
            $output = $tGroup->getName() .'<br />';
        }
        $output = substr($output, 0, (strlen($output) -6));
        return $output;
    }


}