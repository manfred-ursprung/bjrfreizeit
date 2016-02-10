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
 */
use TYPO3\CMS\Core\Exception;
use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use MUM\BjrFreizeit\Domain\Model\Organization;
use MUM\BjrFreizeit\Domain\Model\Leisure;

class LeisureController extends AbstractController {

    /**
     * leisureRepository
     *
     * @var \MUM\BjrFreizeit\Domain\Repository\LeisureRepository
     * @inject
     */
    protected $leisureRepository;


    /**
     * TagsRepository
     *
     * @var \MUM\BjrFreizeit\Domain\Repository\TagsRepository
     * @inject
     */
    protected $tagsRepository;


    /**
     * TargetGroupRepository
     *
     * @var \MUM\BjrFreizeit\Domain\Repository\TargetGroupRepository
     * @inject
     */
    protected $targetGroupRepository;

    /**
     * CountryRepository
     *
     * @var \MUM\BjrFreizeit\Domain\Repository\CountryRepository
     * @inject
     */
    protected $countryRepository;


    /**
     * HolidayRepository
     *
     * @var \MUM\BjrFreizeit\Domain\Repository\HolidayRepository
     * @inject
     */
    protected $holidayRepository;




    /**
     * @var array
     */
    private $typoScript;


    public function initializeAction(){
        $this->typoScript = $this->getFullTypoScript();
        $js = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($this->request->getControllerExtensionKey())
            .'Resources/Public/Scripts/feadminLib.js';
        $GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile($js);
    }


    public function initializeUpdateAction() {
        if ($this->arguments->hasArgument('leisure')) {
            $args = $this->request->getArguments();
        /*    if( (empty($args['leisure']['category'])) || !is_numeric(intval($args['leisure']['category']))){
                $GLOBALS['TSFE']->fe_user->setKey("ses","leisureList",'Die Freizeit konnte nicht angelegt werden, da keine Unterkategorie angegeben war.');
                //DebuggerUtility::var_dump($this->arguments->getArgument('leisure'), '$this->arguments');
                //DebuggerUtility::var_dump($this->request->getArguments(), 'request->getArguments');
                //exit();
                $this->redirect('list');
            }
        */
        }
    }


    public function newAction(\MUM\BjrFreizeit\Domain\Model\Leisure $leisure = NULL){
        //category select list
        $tagList = array();
        $tagList[] = $this->tagsRepository->findAll();

        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($GLOBALS['TSFE'], 'TSFE ');
        //exit();
        $organization = $this->findOrganization();
        if(!is_a($organization, '\MUM\BjrFreizeit\Domain\Model\Organization')){
            $organization = 'Error';
        }
        $js = $this->jsForNewLeisure();
        $GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('newleisure', $js, false);

        $params = array(
            'leisure' => $leisure,
            'organization' => $organization,
            'leisureImagePath' => (isset($this->typoScript['plugin.']['tx_bjr_lend.']['settings.']['leisureImagePath']) ?
                    $this->typoScript['plugin.']['tx_bjr_lend.']['settings.']['leisureImagePath'] :
                    'uploads/tx_bjrlend/'),
            'categoryList' => $tagList,
            //'firstParent'   => $leisure->getCategory()->getFirstParent(),
            'currentPageId' => $GLOBALS['TSFE']->id,
        );
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($params, 'Parameter');

        $this->view->assignMultiple($params);
    }

    /**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
        $organization = $this->findOrganizationBySession();
        if(!is_a($organization, '\MUM\BjrFreizeit\Domain\Model\Organization')){
            $organization = $this->findOrganizationByLogin();
            if(is_a($organization, '\MUM\BjrFreizeit\Domain\Model\Organization')){
                $this->redirect('organizationList', 'Leisure', NULL, array('organization' => $organization));
            }else{
                $this->setFlashMessage('Es konnte keine zugehörige Ausleihstelle zu Ihrem Account gefunden werden.');
            }
        }else{
            $this->redirect('organizationList', 'Leisure', NULL, array('organization' => $organization));
        }

	}

    /**
     * @param Organization $organization
     */
    public function organizationListAction(\MUM\BjrFreizeit\Domain\Model\Organization $organization){
        $leisures = $this->leisureRepository->findByOrganization($organization);
        $GLOBALS['TSFE']->fe_user->setKey('ses',  'organization', $organization->getUid());
        $js = $this->jsForDeleteArticle();
        $GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('organizationList', $js, false);

        $msg = $GLOBALS['TSFE']->fe_user->getKey("ses","leisureList");
        if(!empty($msg)) {
            $this->setFlashMessage($msg);
            $GLOBALS['TSFE']->fe_user->setKey("ses", "leisureList", '');
        }
        $params = array(
            'leisures' => $leisures,
            'organization' => $organization,
            'currentPageId' => $GLOBALS['TSFE']->id,
            'settings'      => $this->settings,
        );
        $this->view->assignMultiple($params);

    }

	/**
	 * action edit
	 *
	 * @param \MUM\BjrFreizeit\Domain\Model\Leisure $leisure
	 * @return void
     * @ignorevalidation $leisure
	 */
	public function editAction(\MUM\BjrFreizeit\Domain\Model\Leisure $leisure) {

        //tags select list
        $tagList = $this->tagsRepository->findAll()->toArray();
        $targetGroupList = $this->targetGroupRepository->findAll()->toArray();
        $countryList     = $this->countryRepository->findAll()->toArray();
        $holidayList     = $this->holidayRepository->findAll()->toArray();
    /*    print '<pre>';
        print_r($tagList);
        print '</pre>';
        exit;
    */
        //$tagList[] = $leisure->getCategory()->getFirstParent();->getChilds()->toArray();

    /*/    if($leisure->hasTags()){
            $tagList[] = $leisure->getTags()->toArray();
        }
    */
        $params = array(
            'leisure' => $leisure,
            'organization' => $this->organizationRepository->findByLeisure($leisure),
            'articleImagePath' => (isset($this->typoScript['plugin.']['tx_bjrfreizeit.']['settings.']['leisureImagePath']) ?
                    $this->typoScript['plugin.']['tx_bjr_lend.']['settings.']['leisureImagePath'] :
                    'uploads/tx_bjrfreizeit/'),
            'tagList'           => $tagList,
            'targetGroupList'   => $targetGroupList,
            'countryList'       => $countryList,
            'holidayList'       => $holidayList,
            'firstParent'       => $leisure->getTags()->next(),
            'currentPageId'     => $GLOBALS['TSFE']->id,
        );
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($leisure->getCategory()->getFirstParent());
        $this->view->assignMultiple($params);
	}

    /**
     * action update
     * @param \MUM\BjrFreizeit\Domain\Model\Leisure $leisure
     * @return void
     *
     */
    public function updateAction(\MUM\BjrFreizeit\Domain\Model\Leisure $leisure) {
        $redirectParams = array();
        $args = $this->request->getArguments();
        $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($leisure);
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($args);
        //exit();
        if($leisure->_isDirty() || $leisure->_isNew()){
            if($leisure->_isNew()){
                $organization = $this->findOrganizationBySession();
                if(!is_a($organization, '\MUM\BjrFreizeit\Domain\Model\Organization')){
                    $organization = 'Error';
                    $GLOBALS['TSFE']->fe_user->setKey("ses","leisureChange",'Der Artikel konnte nicht angelegt werden. Errorcode: 1413190651');
                }else{
                    $leisure->copyDataFromOrganization($organization);
                    $this->leisureRepository->add($leisure);

                    //now organization ist persistent
                    $GLOBALS['TSFE']->fe_user->setKey("ses","leisureChange",'Der Artikel wurde neu angelegt.');
                }
            }else{
                $this->leisureRepository->update($leisure);
                $GLOBALS['TSFE']->fe_user->setKey("ses","leisureChange",'Der Artikel '. $leisure->getTitle() .' wurde geändert.');
            }
            //it is not persistent already, we have to do it!

            $persistenceManager->persistAll();
            DebuggerUtility::var_dump($_FILES['tx_bjrfreizeitfeadmin_leisure']['name']['image'], 'FILES INhalt: ');



        }
        if(strlen($_FILES['tx_bjrfreizeitfeadmin_leisure']['name']['image']) > 0) {
            $success = $this->doUploadImage($leisure);

            //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($imageFileName);
            if($success) {
                /** @var  $fileRepository \TYPO3\CMS\Core\Resource\FileRepository  */
             /*   $fileRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\FileRepository');
                $fileReferenceObject = $fileRepository->findFileReferenceByUid($referenceUid);

                $leisure->setImage($fileReferenceObject);
             */
                $this->leisureRepository->update($leisure);
                $persistenceManager->persistAll();
            }
            DebuggerUtility::var_dump($leisure, 'Leisure');
            exit;
        }
    /*    DebuggerUtility::var_dump($_FILES, '_Files');
        $fileObject = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->getFileReferenceObject(1)->getOriginalFile();
        $fileReferenceData = $GLOBALS['TSFE']->sys_page->checkRecord('sys_file_reference', 1);
        DebuggerUtility::var_dump($fileObject, 'Fileobject');
        DebuggerUtility::var_dump($fileReferenceData, 'Filereference');

        exit;
    */
        $redirectParams['leisure'] = $leisure;
        $this->redirect('successUpdate', 'Leisure', NULL, $redirectParams);


    }

    /**
     * @return string
     * per Ajax aufgerufen.
     */
    public function deleteAction() {
        $args = $this->request->getArguments();
        $leisure = $this->leisureRepository->findByUid($args['leisure']);
        $leisureName = $leisure->getTitle();

        $this->leisureRepository->remove($leisure);
        $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
        return 'Leisure ' . $leisureName .' ist gelöscht';
    }

    /**
     * called by ajax. so we have to build leisure from repository and can't use normal paradigma per parameter
     */
    public function showReservationsAction(){
        /** @var $leisure \MUM\BjrFreizeit\Domain\Model\Leisure  */
        $leisure = $this->leisureRepository->findByUid($this->request->getArgument('leisure'));
        $reservations = $this->reservationRepository->findByArticle($leisure);
        $reservedDates = array();
        /* @var $reservation \Bjr\BjrLend\Domain\Model\Reservation  */
        foreach($reservations->toArray() as $reservation){
            $list = $reservation->listIssueDays();
            //DebuggerUtility::var_dump($list, 'List');
            foreach($list as $dateTime){
                $month = date('n', $dateTime);
                $day = date('j', $dateTime);
                $reservedDates[] = array('month' => $month,
                    'day' => $day);
            }
        }
        $params = array(
            'reservations' => $reservations,
            'reservedDates'=> json_encode($reservedDates),
            'leisure'       => $leisure,
        );
        $renderer = $this->getPlainRenderer('ShowReservations', 'html');
        $renderer->assignMultiple($params);
        $content = $renderer->render();
        //DebuggerUtility::var_dump($leisure, 'Leisure');
        //DebuggerUtility::var_dump($reservations, 'Reservations');
        return $content;
        //$this->view->assignMultiple($params);

    }

    /**
     * @param \MUM\BjrFreizeit\Domain\Model\Leisure $leisure
     * @return int
     */
    private function doUploadImage(\MUM\BjrFreizeit\Domain\Model\Leisure $leisure){
        $success = false;
        /** @var  $storageRepository \TYPO3\CMS\Core\Resource\StorageRepository */
        $storageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\StorageRepository');
        /** @var  $storage \TYPO3\CMS\Core\Resource\ResourceStorage */
        $storage = $storageRepository->findByUid(1);
        /** @var  $folder \TYPO3\CMS\Core\Resource\Folder */
    //    $folder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\Folder', $storage, '/', 'bjrfreizeit');
    //    $fileObject = $folder->addFile($_FILES['tx_bjrfreizeitfeadmin_leisure']['tmp_name']['image'], $_FILES['tx_bjrfreizeitfeadmin_leisure']['name']['image'],'changeName');
        try {
            $targetFolder = $storage->createFolder('bjrfreizeit');
        }catch(\TYPO3\CMS\Core\Resource\Exception\ExistingTargetFolderException $e){
            $targetFolder = $storage->getFolder('bjrfreizeit');
            /*    print '<pre>';
                    print_r($targetFolder);
                    print '</pre>';
                    exit;
            */
        }
        $originalFilePath = $_FILES['tx_bjrfreizeitfeadmin_leisure']['tmp_name']['image'];
        $newFileName      = $_FILES['tx_bjrfreizeitfeadmin_leisure']['name']['image'];

        if (file_exists($originalFilePath)) {
            $movedNewFile = $storage->addFile($originalFilePath, $targetFolder, $newFileName);
            $newFileReference = $this->objectManager->get('MUM\\BjrFreizeit\\Domain\\Model\\FileReference');
            $newFileReference->setFile($movedNewFile);
            $leisure->setImage($newFileReference);
            $success = true;
        }


        //$fileObject = $storage->addFile('/tmp/myfile', $storage->getRootLevelFolder(), 'newFile', );
        //DebuggerUtility::var_dump($fileObject, 'FileObject'); // Should output "/newFile"
        //$fileReferenceUid = $this->leisureRepository->saveImage($fileObject, $leisure);

        return $success;

    }



    /**
     * @param \MUM\BjrFreizeit\Domain\Model\Leisure $leisure
     *
     */
    public function successUpdateAction(\MUM\BjrFreizeit\Domain\Model\Leisure $leisure){
        $typoScript = $this->getFullTypoScript();

        $msg = $GLOBALS['TSFE']->fe_user->getKey("ses","leisureChange");
        $this->setFlashMessage($msg);
        $GLOBALS['TSFE']->fe_user->setKey("ses","leisureChange", '');
        $params = array(
            'leisure' => $leisure,
            'organization' => $this->organizationRepository->findByLeisure($leisure),
            'leisureImagePath' => (isset($typoScript['plugin.']['tx_bjr_lend.']['settings.']['leisureImagePath']) ?
                    $typoScript['plugin.']['tx_bjr_lend.']['settings.']['leisureImagePath'] :
                    'uploads/tx_bjrlend/'),
          /*  'parentCategory' => $leisure->getCategory()->getFirstParent(),
            'firstParent'   => $leisure->getCategory()->getFirstParent(),
          */
            'tagList'       => $this->tagsRepository->findAll()->toArray(),
            'targetGroupList'   => $this->targetGroupRepository->findAll()->toArray(),
            'countryList'       => $this->countryRepository->findAll()->toArray(),
            'holidayList'       => $this->holidayRepository->findAll()->toArray(),
            'currentPageId'     => $GLOBALS['TSFE']->id,
        );
        $this->view->assignMultiple($params);

    }


    protected function getSubcategorys(){

    }

    /**
     * @return \Bjr\BjrLend\Domain\Model\Organization
     */
    protected  function findOrganization(){
        /** @var  $organization \Bjr\BjrLend\Domain\Model\Organization */
        $organization = $this->findOrganizationBySession();
        if(!is_a($organization, '\MUM\BjrFreizeit\Domain\Model\Organization')) {
            $organization = $this->findOrganizationByLogin();
        }
        return $organization;
    }

    /**
     * @return \Bjr\BjrLend\Domain\Model\Organization
     */
    protected function findOrganizationBySession(){
        //$user = $GLOBALS['TSFE']->fe_user->user;
        /** @var  $organization Organization */
        $organization =  $GLOBALS['TSFE']->fe_user->getKey('ses',  'organization');
        if(is_int($organization)){
            $organization = $this->organizationRepository->findByUid($organization);
        }
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($organization, 'Organization in findOrganizationBySession');
        return $organization;
    }


    protected function findOrganizationByLogin(){
        $feUserId = $GLOBALS['TSFE']->fe_user->user['uid'];
        /** @var  $organization  \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult */
        $organization = $this->organizationRepository->findByFeusername($feUserId);
        if($organization->count() > 0){
            return $organization->getFirst();
        }else{
            return null;
        }
    }


    protected function jsForDeleteArticle(){
        $js = <<<EOT

        $(document).ready(function(){
            var pageId = $('#currentPageId').val();
            $("#dialog").dialog({
                autoOpen: false,
                modal: true,
                show: true,
                buttons : [
                {
                    text: 'Ja',
                    click : function() {
                        var article = $('#dialog').data('articleuid');
                        $.ajax({
                            async: 'true',
                            url: 'index.php',
                            type: 'POST',
                            data: {
                                eID: "bjrfeadmin",
                                request: {
                                    pluginName:  'Article',
                                    controller:  'Article',
                                    action:      'delete',
                                    arguments: {
                                        'pageId': pageId,
                                        'article': article
                                    }
                                }

                            },
                            //dataType: "json",
                            dataType: 'html',

                            success: function(result) {
                                window.location.reload();

                            },
                            error: function(error) {
                                //console.log(error);

                            }
                        });

                    }
                },
                {
                    text: 'Abbrechen',
                    click: function() {
                        $(this).dialog("close");
                    }
                } ]
            });

            $(".callDeleteConfirm").on("click", function(e) {
                e.preventDefault();
                var article = $(this).data('article');
                $('#dialog').data('articleuid', $(this).data('articleuid'));
                $('#dialog').html('Sind sie sicher, dass der Artikel "' + article +'" gelöscht werden soll?');
                $("#dialog").dialog("open");
            });




        });


EOT;
        return $js;

    }


    /**
     * @return string
     */
    protected function jsForNewLeisure(){
        $js = <<<EOT

        $(document).ready(function(){
            var pageId = $('#currentPageId').val();

            $(document).on('click', '#selectKat', function(){
                $('#selectSubkat').html('');
                var category = $('#selectKat option:selected').val();
                $.ajax({
                    async: 'true',
                    url: 'index.php',
                    type: 'POST',
                    data: {
                        eID: "bjrlend",
                        request: {
                            pluginName:  'Pi1',
                            controller:  'Category',
                            action:      'subCategory',
                            arguments: {
                                'pageId': pageId,
                                'category': category
                            }
                        }

                    },
                    //dataType: "json",
                    dataType: 'html',

                    success: function(result) {
                        console.log(result);
                        $('#selectSubkat').html(result);

                    },
                    error: function(error) {
                        console.log(error);
                        $('#selectSubkat').html((error.responseText));
                    }
                });
            });
        });

EOT;
        return $js;

    }




}
?>