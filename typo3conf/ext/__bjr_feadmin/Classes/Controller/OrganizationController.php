<?php
namespace Bjr\BjrFeadmin\Controller;

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
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 *
 *
 * @package bjr_feadmin
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($typeConverter);
 *
 */
class OrganizationController extends AbstractController {

    public static $ADMINISTRATOR_GROUPNAME = 'Administrator';

	/**
	 * OrganizationRepository
	 *
	 * @var \Bjr\BjrLend\Domain\Repository\OrganizationRepository
	 * @inject
	 */
	protected $organizationRepository;

    /**
     * RegionRepository
     *
     * @var \Bjr\BjrLend\Domain\Repository\RegionRepository
     * @inject
     */
    protected $regionRepository;


    /**
     * FrontendUserRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository;


    /**
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserGroupRepository
     * @inject
     */
    protected  $frontendUserGroupRepository;



    /**
     * PageRepository
     *
     * @var \TYPO3\CMS\Frontend\Page\PageRepository
     * @inject
     */
    protected $pageRepository;

    /**
     * @var array
     */
    protected $validationErrors;

    /**
     * @var array
     */
    protected $user;


    public function initializeAction(){
        $this->user = array();
        foreach($GLOBALS['TSFE']->fe_user->groupData['title'] as $groupTitle){
            $this->user['groupTitle'] = $groupTitle;
            break;
        }
    }

    /**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
        if(isset($this->settings['defaultAction']) && ($this->settings['defaultAction'] == 2)){
            $organization = $this->findOrganizationBySession();
            if(!is_a($organization, '\Bjr\BjrLend\Domain\Model\Organization')){
                $organization = $this->findOrganizationByLogin();
                if(!is_a($organization, '\Bjr\BjrLend\Domain\Model\Organization')){
                    $this->setFlashMessage('Es konnte keine zugehörige Ausleihstelle zu Ihrem Account gefunden werden.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
                }
            }
            if(is_a($organization, '\Bjr\BjrLend\Domain\Model\Organization')) {
                $this->forward('edit', 'Organization', NULL, array('organization' => $organization));
            }else{
                $this->forward('edit', 'Organization');
            }
        }else {
            $organizations = $this->organizationRepository->findAll();

            $this->view->assign('organizations', $organizations);
        }

        $flashMessage = $GLOBALS['TSFE']->fe_user->getKey("ses", "listInfo");
        if(!empty($flashMessage)) {
            $this->setFlashMessage($flashMessage);
        }
        $GLOBALS['TSFE']->fe_user->setKey("ses", "listInfo", '');

	}

	/**
	 * action edit
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Organization $organization
	 * @return void
     * @ignorevalidation $organization
	 */
	public function editAction(\Bjr\BjrLend\Domain\Model\Organization $organization = NULL) {
        $regions = $this->regionRepository->findAll();

        if(is_null($organization)){
            //$organization = $this->findOrganizationBySession();
            if(!is_a($organization, '\Bjr\BjrLend\Domain\Model\Organization')) {
                $organization = $this->findOrganizationByLogin();
            }
        }
        if(is_null($organization)){
            $this->setFlashMessage('Organisation konnte nicht gefunden werden.', '', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
        }
        $msg =  $GLOBALS['TSFE']->fe_user->getKey("ses","editErrors");
        if(strlen($msg) > 0){
            $this->setFlashMessage($msg);
            $GLOBALS['TSFE']->fe_user->setKey("ses","editErrors", '');

        }

        $this->view->assign('pageList', $this->getArticlePagesList());
        $this->view->assign('organization', $organization);
        $this->view->assign('regions', $regions);
        $this->view->assign('superuser', $this->isAdministratorMode());
        $this->view->assign('source', 'edit');
	}

    /**
     * @param \Bjr\BjrLend\Domain\Model\Organization $organization
     * @ignorevalidation $organization
     */
    public function newAction(\Bjr\BjrLend\Domain\Model\Organization $organization = NULL){
        if($this->isAdministratorMode()) {
            $regions = $this->regionRepository->findAll();

            $this->view->assign('organization', $organization);
            $this->view->assign('regions', $regions);
            $this->view->assign('feUserList', $this->getFeUserList());
            $this->view->assign('superuser', $this->isAdministratorMode());
            $this->view->assign('creation', 1);
            $this->view->assign('pageList', $this->getArticlePagesList());
            $this->view->assign('source', 'new');
        }else{
            $GLOBALS['TSFE']->fe_user->setKey("ses", "listInfo", 'Neue Ausleihstellen dürf nur der Administrator anlegen.');
            $this->redirect('list', 'Organization', NULL);
        }
        //wenn wieder aufgerufen wird wegen Fehler
        $msg =  $GLOBALS['TSFE']->fe_user->getKey("ses","editErrors");
        if(strlen($msg) > 0){
            $this->setFlashMessage($msg);
            $GLOBALS['TSFE']->fe_user->setKey("ses","editErrors", '');

        }

    }


    public function deleteAction(\Bjr\BjrLend\Domain\Model\Organization $organization){
        list($validToRemove, $messages) = $organization->validToRemove();
        if($validToRemove) {
            $this->organizationRepository->remove($organization);
            $GLOBALS['TSFE']->fe_user->setKey("ses", "listInfo", 'Die Ausleihstelle wurde gelöscht.');
        }else{
            $mesStr = implode('. ', $messages);
            $GLOBALS['TSFE']->fe_user->setKey("ses", "listInfo", 'Die Ausleihstelle wurde nicht gelöscht.' . $mesStr);
        }
        $this->redirect('list', 'Organization', NULL);

    }


    /**
     * action update
     * @param \Bjr\BjrLend\Domain\Model\Organization $organization
     * @return void
     * @validate \Bjr\BjrLend\Validation\Organization
     */
    public function updateAction(\Bjr\BjrLend\Domain\Model\Organization $organization) {
        $redirectParams = array();  //array('passwordChange' => '',    'organization' => $organization,'organizationChange' => ''       );
        $args = $this->request->getArguments();
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($args);
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($organization);
        if(array_key_exists('organizationUpdate', $args)){

            if(strlen($args['password']) > 0){

                $passwordChange = $this->doPasswordChange(array(
                    $this->request->getArgument('password'),
                    $this->request->getArgument('passwordConfirmation')
                ),
                    $this->request->getArgument('feuserId')
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
            //select Field value is not set in organization, do it manually
            if($this->isAdministratorMode()) {
                $organization->setArticleFolderPid($this->request->getArgument('articleFolderPid'));
            }
            if(($this->request->hasArgument('creation')) && ($this->request->getArgument('creation') == 1)){
                $organization->setPid($this->settings['pidOrganizationFolder']);
                $organization->setFeusername($this->frontendUserRepository->findByUid($this->request->getArgument('username')));
                //email Adresse ist pflicht
                if($this->validateOrganization($args)){
                    $this->organizationRepository->add($organization);
                    //it is not persistent already, we have to do it!
                    $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
                    $persistenceManager->persistAll();
                    //now organization ist persistent
                    $GLOBALS['TSFE']->fe_user->setKey("ses","organizationChange",'Die Ausleihstelle wurde neu angelegt.');
                }else{
                    $errors = $this->getValidationErrors();
                    $GLOBALS['TSFE']->fe_user->setKey("ses", "editErrors", implode('.<br />', $errors));
                    //DebuggerUtility::var_dump($organization);
                    //exit();
                    //$redirectParams['organization'] = $organization;
                    $redirectParams['attributes'] = $args;
                    $this->redirect('new', 'Organization', NULL, $redirectParams);
                }

            }else{
                if($this->validateOrganization($args)) {
                    $this->organizationRepository->update($organization);
                    $GLOBALS['TSFE']->fe_user->setKey("ses", "organizationChange", 'Die Ausleihstelle wurde geändert.');
                }else{
                    $errors = $this->getValidationErrors();
                    $GLOBALS['TSFE']->fe_user->setKey("ses", "editErrors", implode('. ', $errors));
                    $redirectParams['organization'] = $organization;
                    $this->redirect('edit', 'Organization', NULL, $redirectParams);
                }
            }

        }
        $redirectParams['organization'] = $organization;
        $this->redirect('successUpdate', 'Organization', NULL, $redirectParams);


    }


    /**
     * @param \Bjr\BjrLend\Domain\Model\Organization $organization
     *
     *
     */
    public function successUpdateAction(\Bjr\BjrLend\Domain\Model\Organization $organization){

        $passwordChange =  $GLOBALS['TSFE']->fe_user->getKey("ses","passwordChange");
        if(strlen($passwordChange) > 0){
            $this->setFlashMessage($passwordChange);
        }
        $msg = $GLOBALS['TSFE']->fe_user->getKey("ses","organizationChange");
        $this->setFlashMessage($msg);
        $this->view->assign('organization',$organization);
        $this->view->assign('superuser', $this->isAdministratorMode());
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



    /**
     * @return mixed
     */
    protected function getFeUserList(){
        //$feUserRepository = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserRepository');

        $querySettings = $this->frontendUserRepository->createQuery()->getQuerySettings();
        $querySettings->setStoragePageIds(array($this->settings['pidFrontendUser']));
        $this->frontendUserRepository->setDefaultQuerySettings($querySettings);

        $feUserList = $this->frontendUserRepository->findByUsergroup($this->settings['frontendUserGroup']);
        return $feUserList;
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function getArticlePagesList(){
        $pageList = array();
        if($this->settings['pidOrganizationFolder'] > 0){
            
            $organizations = $this->organizationRepository->findAll();
            $usedArticleFolderPids = array();
            /** @var  $organization \Bjr\BjrLend\Domain\Model\Organization $organization */
            foreach($organizations as $organization){
                $usedArticleFolderPids[] = $organization->getArticleFolderPid();
            }
            $ret = $this->pageRepository->getMenu($this->settings['pidOrganizationFolder']);
            foreach($ret as $pageUid => $row){
                if(!in_array($pageUid, $usedArticleFolderPids)){
                    $pageList[$pageUid] = $row['title'];
                }
            }
        }else{
            throw new Exception('PID für Seite mit Ausleihstellen ist nicht gesetzt.' );
        }
        return $pageList;
    }

    /**
     * @return \Bjr\BjrLend\Domain\Model\Organization | NULL
     */
    protected function findOrganizationBySession(){

        /** @var  $organization \Bjr\BjrLend\Domain\Model\Organization */
        $organization =  $this->userSession->get('organization');
        if(is_int($organization)){
            $organization = $this->organizationRepository->findByUid($organization);
        }
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($organization, 'Organization in findOrganizationBySession');
        return $organization;
    }

    /**
     * @return \Bjr\BjrLend\Domain\Model\Organization
     */
    protected function findOrganizationByLogin(){
        $feUserId = $GLOBALS['TSFE']->fe_user->user['uid'];
        //$feUserId = 2;
        /** @var $organization \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult */
        $organization = $this->organizationRepository->findByFeusername($feUserId);
        //DebuggerUtility::var_dump($organization);
        if($organization->count() > 0) {
            return $organization->getFirst();
        }else{
            return NULL;
        }
    }

    protected function validateOrganization($args){
        $valid = true;
        $errors = array();
        /** @var  $validator \Bjr\BjrLend\Validation\Validator\OrganizationValidator */
        $validator = $this->objectManager->create('Bjr\\BjrLend\\Validation\\Validator\\OrganizationValidator');
        
        $valid =  $validator->isValid($args);
        if(!$valid){
            $_errors = $validator->getErrors();
            foreach($_errors as $error){
                $errors[] = $error->getMessage();
            }
            $this->setValidationErrors($errors);
        }
        return $valid;

    /*    if(strlen($args['organization']['address']['email']) == 0){
            echo 'Ein error ist aufgertererten.<br />';
            DebuggerUtility::var_dump($args);
        }else{
            /** @var  $validator \TYPO3\CMS\Extbase\Validation\Validator\EmailAddressValidator *
            $validator = $this->objectManager->create('TYPO3\\CMS\\Extbase\\Validation\\Validator\\EmailAddressValidator');
            $valid =  $validator->isValid($args['organization']['address']['email']);
            if(!$valid){
                $valid = false;
                $result = $validator->getErrors();
                $errors[] = $result[0]->getMessage();
            }else{
                echo "Valid <bre />";
            }

            DebuggerUtility::var_dump($errors);
            if(count($result) >  0){
                //Fehler aufgetreten
            }
        }
        DebuggerUtility::var_dump($args);
        exit();
    */
    }



    /**
     * @return array
     */
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }

    /**
     * @param array $validationErrors
     */
    public function setValidationErrors($validationErrors)
    {
        $this->validationErrors = $validationErrors;
    }


    private function isAdministratorMode(){
        return $this->user['groupTitle'] == self::$ADMINISTRATOR_GROUPNAME;
    }


}
?>