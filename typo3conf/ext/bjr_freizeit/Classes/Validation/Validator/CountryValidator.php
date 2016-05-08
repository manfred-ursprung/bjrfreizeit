<?php
namespace MUM\BjrFreizeit\Validation\Validator;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Manfred Ursprung <manfred@manfred-ursprung.de>, Webapplikationen Ursprung
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
 * @package bjr_freizeit
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */

use  \TYPO3\CMS\Core\Utility\GeneralUtility;
use   \MUM\BjrFreizeit\Domain\Repository\CountryRepository;
use   \TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class CountryValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     * @inject
     */
    protected $objectManager;


    public function __isValid() {
        if ($this->requestHandler->has($this->fieldName)) {
            $value = $this->requestHandler->getByMethod($this->fieldName);
            if (!preg_match('/^(?#Protocol)(?:(?:ht|f)tp(?:s?)\\:\\/\\/|~\\/|\\/)?(?#Username:Password)(?:\\w+:\\w+@)?(?#Subdomains)(?:(?:[-\\w]+\\.)+(?#TopLevel Domains)(?:com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum|travel|[a-z]{2}))(?#Port)(?::[\\d]{1,5})?(?#Directories)(?:(?:(?:\\/(?:[-\\w~!$+|.,=]|%[a-f\\d]{2})+)+|\\/)+|\\?|#)?(?#Query)(?:(?:\\?(?:[-\\w~!$+|.,*:]|%[a-f\\d{2}])+=?(?:[-\\w~!$+|.,*:=]|%[a-f\\d]{2})*)(?:&(?:[-\\w~!$+|.,*:]|%[a-f\\d{2}])+=?(?:[-\\w~!$+|.,*:=]|%[a-f\\d]{2})*)*)*(?#Anchor)(?:#(?:[-\\w~!$+|.,*:=]|%[a-f\\d]{2})*)?$/', $value)) {
                return FALSE;
            }
        }
        return TRUE;
    }

    public function isValid($value){
        $valid = $this->checkUnique($value['country']['name']);
        if(!$valid){
            $this->addError('Das Land ist schon vorhanden', 1461507813);
        }
        return $valid;
    }


    private function checkUnique($name){
        $valid = true;
        if (strlen($name) == 0) {
            //echo 'Ein error ist aufgertererten.<br />';
            $valid = false;
            $this->addError('Sie müssen einen Namen eingeben',
                1461507272);

        } else {
            if(!is_a($this->objectManager, '\TYPO3\CMS\Extbase\Object\ObjectManager')){
                $this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            }
            /** @var  $repo \MUM\BjrFreizeit\Domain\Repository\CountryRepository');           */
            $repo = GeneralUtility::makeInstance('MUM\\BjrFreizeit\\Domain\\Repository\\CountryRepository');
            $result = $repo->findOneByName($name);
            $valid = $result == null;
       }
        return $valid;
    }

}