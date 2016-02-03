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
class CategoryController extends AbstractController {

	/**
	 * categoryRepository
	 *
	 * @var \Bjr\BjrLend\Domain\Repository\CategoryRepository
	 * @inject
	 */
	protected $categoryRepository;

    /**
     * @var array
     */
    private $typoScript;



    public function initializeAction(){
        $this->typoScript = $this->getFullTypoScript();
    }

	/**
	 * action list
	 * @param \Bjr\BjrLend\Domain\Model\Category $category
     * @return void
     * @ignorevalidation $category
	 *
	 * @return void
	 */
	public function listAction(\Bjr\BjrLend\Domain\Model\Category $category = NULL) {
        //category select list
        $categoryList = array();
        $categoryList[] = $this->categoryRepository->findByParent('0');

        $js = $this->jsForSelectCategories();
        $GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('categoryRename', $js, false);

        $msg = $GLOBALS['TSFE']->fe_user->getKey("ses","categoryNew");
        if(strlen($msg) > 0){
            $this->setFlashMessage($msg);
            $GLOBALS['TSFE']->fe_user->setKey("ses","categoryNew", '');
        }

		$this->view->assign('categoryList', $categoryList);
        $this->view->assign('category', $category);
	}

	/**
	 * action edit
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Category $category
	 * @return void
	 */
	public function editAction(\Bjr\BjrLend\Domain\Model\Category $category) {
		$this->view->assign('category', $category);
	}

    /**
     * @return string   json encoded
     * called by Ajax
     */
    public function renameAction(){
        $retMsg = array('success' => 0);
        $args = $this->request->getArguments();
        if(isset($args['title']) && strlen($args['title']) > 0){
            $categoryId = $args['category'];
            $parentCategory = $args['parentCategory'];
            /** @var  $category \Bjr\BjrLend\Domain\Model\Category*/
            $category = $this->categoryRepository->findByUid($categoryId);
            if(is_a($category, '\Bjr\BjrLend\Domain\Model\Category')){
                $category->setTitle($args['title']);
                $this->categoryRepository->update($category);
                //we must persist it here because we have an ajax request
                //$persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
                //$persistenceManager->persistAll();
                $retMsg['success'] = 1;
                $retMsg['msg'] = 'Die Kategorie wurde umbenannt nach ' .$args['title'];
            }else{
                $retMsg['msg'] = 'Sie müssen eine Kategorie auswählen. ';
            }
        }else{
            $retMsg['msg'] = "Füllen Sie bitte das Feld \"Neuer Name\" aus.";
        }
        return json_encode($retMsg);
    }


    /**
     *
     * @return string   json encoded
     * @ignorevalidation $category
     *
     * Anlegen einer neuen Kategory
     */
    public function newAction(\Bjr\BjrLend\Domain\Model\Category $category){
        /** @var  $parent \Bjr\BjrLend\Domain\Model\Category */
        $parent = $this->categoryRepository->findByUid($this->request->getArgument('parentCategory'));
        //if parent is found, we have a child. If no parent we have a super category
        if(is_a($parent, '\Bjr\BjrLend\Domain\Model\Category')){

            $category->addParent($parent);
            $parent->addChild($category);
            $this->categoryRepository->update($parent);
        }
        $category->setPid($this->typoScript['plugin.']['tx_bjr_feadmin.']['settings.']['pidOrganizationFolder']);

        $this->categoryRepository->add($category);
        $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();

        //now category ist persistent
        $GLOBALS['TSFE']->fe_user->setKey("ses","categoryNew",'Die Kategorie <b>"'. $category->getTitle() .'"</b> wurde neu angelegt.');

        $redirectParams['category'] = NULL;
        $this->redirect('list', 'Category', NULL, $redirectParams);
    }


    public function deleteAction(){
        $retMsg = array('success' => 0);
        $args = $this->request->getArguments();

            $categoryId = $args['category'];

            /** @var  $category \Bjr\BjrLend\Domain\Model\Category*/
            $category = $this->categoryRepository->findByUid($categoryId);
            if(is_a($category, '\Bjr\BjrLend\Domain\Model\Category')){
                if(!$category->hasChildren() && ($category->articlesInCategorySubcategory() == 0) ){
                    $this->categoryRepository->remove($category);
                    $retMsg['success'] = 1;
                    $retMsg['msg'] = 'Die Kategorie wurde gelöscht.';
                }else{
                    $retMsg['msg'] = 'Die Kategorie kann nicht gelöscht werden.';
                    $retMsg['msg'] .= ($category->articlesInCategorySubcategory() != 0) ? ' Es gibt Artikel in dieser Kategorie'
                            : ' Es gibt Unterkategorien zu dieser Kategorie.';
                }

                //we must persist it here because we have an ajax request
                //$persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
                //$persistenceManager->persistAll();

            }else{
                $retMsg['msg'] = 'Sie müssen eine Kategorie auswählen. ' .serialize($args);
            }

        return json_encode($retMsg);
    }



    protected function jsForSelectCategories(){
        $js = <<<EOT
            $(document).ready(function(){
                var pageId = $('#currentPageId').val();
                console.log("hallo");
                $('#dialog').hide();

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
                            $('#selectSubkat').html(error.responseText);
                        }
                    });
                });

                $(document).on('click', '.-rename', function(){
                    $("#dialog").dialog({
                        autoOpen: false,
                        modal: true,
                        show: true,
                        buttons : [
                        {
                            text: 'Okay',
                            click : function() {
                                $(this).dialog( "close" );
                                window.location.reload();
                            }
                        }]
                    });
                    var title = $('#form-rename-title').val();
                    var category = $('#selectSubkat option:selected').val();
                    $.ajax({
                        async: 'true',
                        url: 'index.php',
                        type: 'POST',
                        data: {
                            eID: "bjrfeadmin",
                            request: {
                                pluginName:  'Categories',
                                controller:  'Category',
                                action:      'rename',
                                arguments: {
                                    'pageId': pageId,
                                    'category': category,
                                    'title' : title
                                }
                            }

                        },
                        dataType: "json",
                        //dataType: 'html',

                        success: function(result) {
                            console.log(result);
                            $('#dialog p').html(result.msg);
                            if(result.success == 1){
                                $("#dialog").dialog('open');
                            }else{
                                //if error, no RELOAD
                                $("#dialog").dialog({
                                    autoOpen: true,
                                    modal: true,
                                    show: true,
                                    buttons : [
                                    {
                                        text: 'Okay',
                                        click : function() {
                                            $(this).dialog( "close" );

                                        }
                                    }]
                                });
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            $('#dialog p').html((error.responseText));
                            //if fatal error no RELOAD
                            $("#dialog").dialog({
                                autoOpen: true,
                                modal: true,
                                show: true,
                                buttons : [
                                {
                                    text: 'Abbrechen',
                                    click : function() {
                                        $(this).dialog( "close" );

                                    }
                                }]
                            });
                        }
                    });

                });


                $(document).on('click', '.-delete', function(){
                    $("#dialog").dialog({
                        autoOpen: false,
                        modal: true,
                        show: true,
                        buttons : [
                        {
                            text: 'Okay',
                            click : function() {
                                $(this).dialog( "close" );
                                window.location.reload();
                            }
                        }]
                    });
                    var category;
                    if($(this).val() == 'deleteSubCategory'){
                        category = $('#selectSubkat option:selected').val();
                    }
                    if($(this).val() == 'deleteMainCategory'){
                        category = $('#selectKat option:selected').val();
                    }
                    $.ajax({
                        async: 'true',
                        url: 'index.php',
                        type: 'POST',
                        data: {
                            eID: "bjrfeadmin",
                            request: {
                                pluginName:  'Categories',
                                controller:  'Category',
                                action:      'delete',
                                arguments: {
                                    'pageId': pageId,
                                    'category': category
                                }
                            }
                        },
                        dataType: "json",
                        //dataType: 'html',

                        success: function(result) {
                            console.log(result);
                            $('#dialog p').html(result.msg);
                            if(result.success == 1){
                                $("#dialog").dialog('open');
                            }else{
                                //if error, no RELOAD
                                $("#dialog").dialog({
                                    autoOpen: true,
                                    modal: true,
                                    show: true,
                                    buttons : [
                                    {
                                        text: 'Okay',
                                        click : function() {
                                            $(this).dialog( "close" );

                                        }
                                    }]
                                });
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            $('#dialog p').html((error.responseText));
                            //if fatal error no RELOAD
                            $("#dialog").dialog({
                                autoOpen: true,
                                modal: true,
                                show: true,
                                buttons : [
                                {
                                    text: 'Abbrechen',
                                    click : function() {
                                        $(this).dialog( "close" );

                                    }
                                }]
                            });
                        }
                    });

                });


            });
EOT;
        return $js;

    }

}
?>