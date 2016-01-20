<?php
namespace Bjr\BjrLend\Validation\Validator;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Manfred Ursprung <manfred@manfred-ursprung.de>, Webapplikationen Ursprung
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
 */

use  \TYPO3\CMS\Core\Utility\GeneralUtility;
use   \Bjr\BjrLend\Domain\Repository\ArticleRepository;
use   \TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class OrganizationValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
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
        $valid = $this->checkEmail($value['organization']['address']['email']);
        if($valid){
            if(strlen($value['organization']['address']['phone']) < 5){
                $valid = false;
                $this->addError('Sie müssen eine gültige Telefonnummer eingeben',
                    1415260362);
            }
            if(strlen($value['organization']['address']['street']) < 5){
                $valid = false;
                $this->addError('Sie müssen eine gültige Strasse eingeben',
                    1415260369);
            }
            if(strlen($value['organization']['openingTimes']) == 0){
                $valid = false;
                $this->addError('Sie müssen gültige Öffnungszeiten angeben',
                    1415260569);
            }
            if($value['articleFolderPid'] == 0){
                $valid = false;
                $this->addError('Sie müssen eine gültige Seite für den Ablegeplatz der Artikel angeben',
                    1415260569);
            }
            /* TODO: den Usernamen auf Eindeutigkeit prüfen */
        }
        return $valid;
    }


    private function checkEmail($email){
        $valid = true;
        if (strlen($email) == 0) {
            //echo 'Ein error ist aufgertererten.<br />';
            $valid = false;
            $this->addError('Sie müssen eine gültige Mailadresse eingeben',
                1415260669);

        } else {
            /** @var  $validator \TYPO3\CMS\Extbase\Validation\Validator\EmailAddressValidator */
            $validator = $this->objectManager->create('TYPO3\\CMS\\Extbase\\Validation\\Validator\\EmailAddressValidator');
            $valid = $validator->isValid($email);
            if (!$valid) {
                $valid = false;
                $result = $validator->getErrors();
                $errors[] = $result[0]->getMessage();
                $this->addError($result[0]->getMessage(),
                    1415260302);
            }
       }
        return $valid;
    }

}