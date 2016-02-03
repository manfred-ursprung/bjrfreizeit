<?php
namespace MUM\BjrFreizeitFeadmin\Controller;

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
 * @package bjr_freizeit_feadmin
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($typeConverter);
 *
 */
class FrontendUserController extends AbstractController {

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected  $frontendUserRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
     * @inject
     */
    protected  $frontendUserGroupRepository;



    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feUser
     * @ignorevalidation $feUser
     *
    */
    public function newAction(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feUser = NULL){
        $msg = $GLOBALS['TSFE']->fe_user->getKey("ses","feuserCreate");
        $GLOBALS['TSFE']->fe_user->setKey("ses","feuserCreate",'');
        if(strlen($msg) > 0){
            $this->setFlashMessage($msg);
            //$data = $GLOBALS['TSFE']->fe_user->getKey("ses","feuserData");
            //$feUser = $this->objectManager->get('TYPO3\\CMS\Extbase\Domain\\Model\\FrontendUser');
            //$feUser->setUsername($data['username']);
        }
        $this->view->assign('feUser', $feUser);
    }


    public function createAction(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feUser){
        //TODO prüfen ob username doppelt vergeben wird.

        if( ($feUser->getPassword()) == ($this->request->getArgument('passwordConfirmation'))){
            $feUser->setPid($this->settings['pidFrontendUser']);
            $feUser->_setProperty('tx_extbase_type', 'Tx_Extbase_Domain_Model_FrontendUser');
            $feUser->addUserGroup($this->frontendUserGroupRepository->findByUid($this->settings['frontendUserGroup']));


            $this->frontendUserRepository->add($feUser);
            //it is not persistent already, we have to do it!
            $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
            $persistenceManager->persistAll();
            //now feuser ist persistent
            // Message for User
            $GLOBALS['TSFE']->fe_user->setKey("ses","feuserCreate",'Der User <b>' . $feUser->getUsername() .'</b> wurde neu angelegt.');

            $redirectParams['feUser'] = $feUser;
            $this->redirect('successUpdate', 'FrontendUser', NULL, $redirectParams);
        }else{
            $GLOBALS['TSFE']->fe_user->setKey("ses","feuserCreate",'Das Passwort stimmt nicht überein.');
            $GLOBALS['TSFE']->fe_user->setKey("ses","feuserData",array('username' => $feUser->getUsername()));

            $redirectParams['feUser'] = $feUser;
            $this->redirect('new', 'FrontendUser', NULL, array());
        }
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feUser
     */
    public function successUpdateAction(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feUser){
        $msg = $GLOBALS['TSFE']->fe_user->getKey("ses","feuserCreate");
        $GLOBALS['TSFE']->fe_user->setKey("ses","feuserCreate",'');
        if(strlen($msg) > 0){
            $this->setFlashMessage($msg);
        }
        $this->view->assign('feUser', $feUser);
    }



    public function deleteAction(){

    }


    protected function checkPassword(){
        $passwordChange = $this->doPasswordChange(array(
                $this->request->getArgument('password'),
                $this->request->getArgument('passwordConfirmation')
            ), 1

        );
        if($passwordChange == 1){
            $this->setFlashMessage('Das Passwort wurde geändert.');
            //$redirectParams['passwordChange'] = 'Das Passwort wurde geändert.';
            $GLOBALS['TSFE']->fe_user->setKey("ses","passwordChange",'Das Passwort wurde geändert.');
        }
        if($passwordChange == -1){
            $this->setFlashMessage('Das Passwort stimmt nicht mit der Kontrolleingabe überein.', 'FEHLER', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
            $this->forward('edit');
        }

    }


    /**
     * @param $passwords
     * @param $feUserId
     * @return int      0 | 1   0 => no password change, 1 => password change
     */
    protected function doPasswordChange($passwords, $feUserId){
        $changeState = 0;
        if(count($passwords) == 2){

            if(($passwords[0] == $passwords[1])){
                /** @var  $feUserRepository \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository */
                $feUserRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserRepository');
                /** @var  $feUser \TYPO3\CMS\Extbase\Domain\Model\FrontendUser  */
                $feUser = $feUserRepository->findByUid($feUserId);
                $feUser->setPassword($passwords[0]);
                $feUserRepository->update($feUser);
                $changeState = 1;
            }else{
                $changeState = -1;
            }
        }
        return $changeState;
    }


}
