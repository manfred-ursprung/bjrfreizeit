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

/**
 *
 *
 * @package bjr_feadmin
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
use TYPO3\CMS\Core\Exception;
use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class ArticleController extends AbstractController {

    /**
     * articleRepository
     *
     * @var \Bjr\BjrLend\Domain\Repository\ArticleRepository
     * @inject
     */
    protected $articleRepository;


    /**
     * categoryRepository
     *
     * @var \Bjr\BjrLend\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository;

    /**
     * reservationRepository
     *
     * @var \Bjr\BjrLend\Domain\Repository\ReservationRepository
     * @inject
     */
    protected $reservationRepository;



    /**
     * @var \Bjr\BjrLend\Utility\UserSession
     * @inject
     */
    protected $userSession;


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
        if ($this->arguments->hasArgument('article')) {
            $args = $this->request->getArguments();
            if( (empty($args['article']['category'])) || !is_numeric(intval($args['article']['category']))){
                $GLOBALS['TSFE']->fe_user->setKey("ses","articleList",'Der Artikel konnte nicht angelegt werden, da keine Unterkategorie angegeben war.');
                //DebuggerUtility::var_dump($this->arguments->getArgument('article'), '$this->arguments');
                //DebuggerUtility::var_dump($this->request->getArguments(), 'request->getArguments');
                //exit();
                $this->redirect('list');

            }

        }
    }


    public function newAction(\Bjr\BjrLend\Domain\Model\Article $article = NULL){
        //category select list
        $categoryList = array();
        $categoryList[] = $this->categoryRepository->findByParent(0);

        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($GLOBALS['TSFE'], 'TSFE ');
        //exit();
        $organization = $this->findOrganization();
        if(!is_a($organization, '\Bjr\BjrLend\Domain\Model\Organization')){
            $organization = 'Error';
        }
        $js = $this->jsForNewArticle();
        $GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('newArticle', $js, false);

        $params = array(
            'article' => $article,
            'organization' => $organization,
            'articleImagePath' => (isset($this->typoScript['plugin.']['tx_bjr_lend.']['settings.']['articleImagePath']) ?
                    $this->typoScript['plugin.']['tx_bjr_lend.']['settings.']['articleImagePath'] :
                    'uploads/tx_bjrlend/'),
            'categoryList' => $categoryList,
            //'firstParent'   => $article->getCategory()->getFirstParent(),
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
        if(!is_a($organization, '\Bjr\BjrLend\Domain\Model\Organization')){
            $organization = $this->findOrganizationByLogin();
            if(is_a($organization, '\Bjr\BjrLend\Domain\Model\Organization')){
                $this->redirect('organizationList', 'Article', NULL, array('organization' => $organization));
            }else{
                $this->setFlashMessage('Es konnte keine zugehörige Ausleihstelle zu Ihrem Account gefunden werden.');
            }
        }else{
            $this->redirect('organizationList', 'Article', NULL, array('organization' => $organization));
        }

	}


    public function organizationListAction(\Bjr\BjrLend\Domain\Model\Organization $organization){
        $articles = $this->articleRepository->findByOrganization($organization);
        $this->userSession->setKey('organization', $organization->getUid());
        $js = $this->jsForDeleteArticle();
        $GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('organizationList', $js, false);

        $msg = $GLOBALS['TSFE']->fe_user->getKey("ses","articleList");
        if(!empty($msg)) {
            $this->setFlashMessage($msg);
            $GLOBALS['TSFE']->fe_user->setKey("ses", "articleList", '');
        }
        $params = array(
            'articles' => $articles,
            'organization' => $organization,
            'currentPageId' => $GLOBALS['TSFE']->id,
        );
        $this->view->assignMultiple($params);

    }

	/**
	 * action edit
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Article $article
	 * @return void
     * @ignorevalidation $article
	 */
	public function editAction(\Bjr\BjrLend\Domain\Model\Article $article) {

        //category select list
        $categoryList = array();
        $categoryList[] = $this->categoryRepository->findByParent(0);
        //$categoryList[] = $article->getCategory()->getFirstParent();->getChilds()->toArray();

        if(($article->getCategory()->getFirstParent()) && ($article->getCategory()->getFirstParent()->hasChildren())){
            $categoryList[] = $article->getCategory()->getFirstParent()->getChilds()->toArray();
        }
        $params = array(
            'article' => $article,
            'organization' => $this->organizationRepository->findByArticle($article),
            'articleImagePath' => (isset($this->typoScript['plugin.']['tx_bjr_lend.']['settings.']['articleImagePath']) ?
                    $this->typoScript['plugin.']['tx_bjr_lend.']['settings.']['articleImagePath'] :
                    'uploads/tx_bjrlend/'),
            'categoryList' => $categoryList,
            'firstParent'   => $article->getCategory()->getFirstParent(),
            'currentPageId' => $GLOBALS['TSFE']->id,
        );
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($article->getCategory()->getFirstParent());
        $this->view->assignMultiple($params);
	}

    /**
     * action update
     * @param \Bjr\BjrLend\Domain\Model\Organization $article
     * @return void
     *
     */
    public function updateAction(\Bjr\BjrLend\Domain\Model\Article $article) {
        $redirectParams = array();
        $args = $this->request->getArguments();
        $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($article);
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($args);
        //exit();
        if($article->_isDirty() || $article->_isNew()){
            if($article->_isNew()){
                $organization = $this->findOrganizationBySession();
                if(!is_a($organization, '\Bjr\BjrLend\Domain\Model\Organization')){
                    $organization = 'Error';
                    $GLOBALS['TSFE']->fe_user->setKey("ses","articleChange",'Der Artikel konnte nicht angelegt werden. Errorcode: 1413190651');
                }else{
                    $article->copyDataFromOrganization($organization);
                    $this->articleRepository->add($article);

                    //now organization ist persistent
                    $GLOBALS['TSFE']->fe_user->setKey("ses","articleChange",'Der Artikel wurde neu angelegt.');
                }
            }else{
                $this->articleRepository->update($article);
                $GLOBALS['TSFE']->fe_user->setKey("ses","articleChange",'Der Artikel '. $article->getTitle() .' wurde geändert.');
            }
            //it is not persistent already, we have to do it!

            $persistenceManager->persistAll();
            DebuggerUtility::var_dump($_FILES['tx_bjrfeadmin_article']['name']['image'], 'FILES INhalt: ');



        }
        if(strlen($_FILES['tx_bjrfeadmin_article']['name']['image']) > 0) {
            $referenceUid = $this->doUploadImage($article);

            //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($imageFileName);
            if($referenceUid) {
                $article->setImage(1);  //we allow  only one image
                $this->articleRepository->update($article);
                $persistenceManager->persistAll();
            }

        }
        /*$fileObject = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance()->getFileReferenceObject(1)->getOriginalFile();
        $fileReferenceData = $GLOBALS['TSFE']->sys_page->checkRecord('sys_file_reference', 1);
        DebuggerUtility::var_dump($fileObject, 'Fileobject');
        DebuggerUtility::var_dump($fileReferenceData, 'Filereference');
        */
        $redirectParams['article'] = $article;
        $this->redirect('successUpdate', 'Article', NULL, $redirectParams);


    }

    /**
     * @return string
     * per Ajax aufgerufen.
     */
    public function deleteAction() {
        $args = $this->request->getArguments();
        $article = $this->articleRepository->findByUid($args['article']);
        $articleName = $article->getTitle();

        $this->articleRepository->remove($article);
        $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
        return 'Article ' . $articleName .' ist gelöscht';
    }

    /**
     * called by ajax. so we have to build article from repository and can't use normal paradigma per parameter
     */
    public function showReservationsAction(){
        /** @var $article \Bjr\BjrLend\Domain\Model\Article  */
        $article = $this->articleRepository->findByUid($this->request->getArgument('article'));
        $reservations = $this->reservationRepository->findByArticle($article);
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
            'article'       => $article,
        );
        $renderer = $this->getPlainRenderer('ShowReservations', 'html');
        $renderer->assignMultiple($params);
        $content = $renderer->render();
        //DebuggerUtility::var_dump($article, 'Article');
        //DebuggerUtility::var_dump($reservations, 'Reservations');
        return $content;
        //$this->view->assignMultiple($params);

    }

    /**
     * @param \Bjr\BjrLend\Domain\Model\Article $article
     * @return int
     */
    private function doUploadImage(\Bjr\BjrLend\Domain\Model\Article $article){
        /** @var  $storageRepository \TYPO3\CMS\Core\Resource\StorageRepository */
        $storageRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\StorageRepository');
        /** @var  $storage \TYPO3\CMS\Core\Resource\ResourceStorage */
        $storage = $storageRepository->findByUid(2);
        /** @var  $folder \TYPO3\CMS\Core\Resource\Folder */
        $folder = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\Folder', $storage, '/', 'bjrlend');
        $fileObject = $folder->addFile($_FILES['tx_bjrfeadmin_article']['tmp_name']['image'], $_FILES['tx_bjrfeadmin_article']['name']['image'],'changeName');

        //$fileObject = $storage->addFile('/tmp/myfile', $storage->getRootLevelFolder(), 'newFile', );
        DebuggerUtility::var_dump($fileObject, 'FileObject'); // Should output "/newFile"

        //2. Part
        $article->setImage($fileObject->getIdentifier());
        $res = $this->articleRepository->saveImage($fileObject, $article);

        return $res;

    }



    /**
     * @param \Bjr\BjrLend\Domain\Model\Organization $article
     *
     *
     */
    public function successUpdateAction(\Bjr\BjrLend\Domain\Model\Article $article){
        $typoScript = $this->getFullTypoScript();

        $msg = $GLOBALS['TSFE']->fe_user->getKey("ses","articleChange");
        $this->setFlashMessage($msg);
        $GLOBALS['TSFE']->fe_user->setKey("ses","articleChange", '');
        $params = array(
            'article' => $article,
            'organization' => $this->organizationRepository->findByArticle($article),
            'articleImagePath' => (isset($typoScript['plugin.']['tx_bjr_lend.']['settings.']['articleImagePath']) ?
                    $typoScript['plugin.']['tx_bjr_lend.']['settings.']['articleImagePath'] :
                    'uploads/tx_bjrlend/'),
            'parentCategory' => $article->getCategory()->getFirstParent(),
            'firstParent'   => $article->getCategory()->getFirstParent(),
            'currentPageId' => $GLOBALS['TSFE']->id,
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
        if(!is_a($organization, '\Bjr\BjrLend\Domain\Model\Organization')) {
            $organization = $this->findOrganizationByLogin();
        }
        return $organization;
    }

    /**
     * @return \Bjr\BjrLend\Domain\Model\Organization
     */
 /*   protected function findOrganizationBySession(){
        //$user = $GLOBALS['TSFE']->fe_user->user;
        /** @var  $organization \Bjr\BjrLend\Domain\Model\Organization
        $organization =  $this->userSession->get('organization');
        if(is_int($organization)){
            $organization = $this->organizationRepository->findByUid($organization);
        }
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($organization, 'Organization in findOrganizationBySession');
        return $organization;
    }


    protected function findOrganizationByLogin(){
        $feUserId = $GLOBALS['TSFE']->fe_user->user['uid'];
        /** @var  $organization  \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult
        $organization = $this->organizationRepository->findByFeusername($feUserId);
        if($organization->count() > 0){
            return $organization->getFirst();
        }else{
            return null;
        }
    }

  */
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
    protected function jsForNewArticle(){
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