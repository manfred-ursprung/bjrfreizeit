<?php
namespace MUM\BjrFreizeitFeadmin\Hook;

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
 * @package bjr_freizeitfeadmin
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */

use \MUM\BjrFreizeit\Domain\Repository\OrganizationRepository;
use  \TYPO3\CMS\Core\Utility\GeneralUtility;


class LoginHook {

    /**
     * @var  \TYPO3\CMS\Extbase\Object\ObjectManager
     * Da diese Klasse nicht mit dem ObjectManager erzeugt wird, kann kein inject verwendet werden
    */
    protected $objectManager;

    /**
     * @var bool
     */
    protected $debug = false;


    public function afterLogin($param, &$parent){
        if($this->debug) {
            echo "hallo after Login";
            var_dump($param);
            exit();
        }
        //session löschen
        $GLOBALS['TSFE']->fe_user->removeSessionData();
        $this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        $GLOBALS['TSFE']->fe_user->setKey('ses', 'organization', $this->findOrganizationByLogin());
    }


    /**
     * @return null|object
     */
    protected function findOrganizationByLogin(){
        $feUserId = $GLOBALS['TSFE']->fe_user->user['uid'];
        /** @var  $organizationRepository OrganizationRepository */
        $organizationRepository = $this->objectManager->get('MUM\\BjrFreizeit\\Domain\\Repository\\OrganizationRepository');
        /** @var  $organization  \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult */
        $organization = $organizationRepository->findByFeusername($feUserId);
        if($organization->count() > 0){
            return $organization->getFirst();
        }else{
            return null;
        }
    }
}
