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
//use TYPO3\CMS\Belog\Controller\AbstractController;
use \MUM\BjrFreizeit\Domain\Repository\TargetGroupRepository;
use \MUM\BjrFreizeit\Domain\Model\TargetGroup ;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 *
 *
 * @package bjr_freizeitfeadmin
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class TargetGroupController extends \MUM\BjrFreizeitFeadmin\Controller\AbstractController {

	/**
	 * targetGroupRepository
	 *
	 * @var \MUM\BjrFreizeit\Domain\Repository\TargetGroupRepository;
     *
	 */
	protected $targetGroupRepository;


    public function initializeAction()
    {
        $this->targetGroupRepository = $this->objectManager->get('MUM\\BjrFreizeit\\Domain\\Repository\\TargetGroupRepository');
        $css = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($this->request->getControllerExtensionKey())
            .'Resources/Public/Css/bjrfreizeitfeadmin.css';
        /**  */
        $GLOBALS['TSFE']->getPageRenderer()->addCssFile($css);
    }

    /**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {

		$targetGroup = $this->targetGroupRepository->findAll();
        $js = $this->jsForDeleteTargetGroup();
        $GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('targetGroupDelete', $js, false);

        $msg = $GLOBALS['TSFE']->fe_user->getKey("ses","targetGroupChange");
        if(!empty($msg)){
            $this->setFlashMessage($msg);
        }

        $this->view->assign('targetGroups', $targetGroup);
	}

    /**
     * @param \MUM\BjrFreizeit\Domain\Model\TargetGroup $targetGroup
     * @return void
     */
    public function editAction(\MUM\BjrFreizeit\Domain\Model\TargetGroup $targetGroup) {

        $this->view->assign('targetGroup', $targetGroup);
	}


    /**
     * @param \MUM\BjrFreizeit\Domain\Model\TargetGroup $tag
     *
     */
    public function newAction(\MUM\BjrFreizeit\Domain\Model\TargetGroup $targetGroup = NULL){

        $this->view->assign('targetGroup', $targetGroup);

    }


    /**
     * action update
     * @param \MUM\BjrFreizeit\Domain\Model\TargetGroup $targetGroup
     * @return void
     *
     */
    public function updateAction(\MUM\BjrFreizeit\Domain\Model\TargetGroup $targetGroup) {
        $redirectParams = array();
        $args = $this->request->getArguments();

        if($targetGroup->_isNew() || $targetGroup->_isDirty()){

            if($targetGroup->_isNew()){
                $targetGroup->setPid($this->settings['pidOrganizationFolder']);

                $this->targetGroupRepository->add($targetGroup);
                //it is not persistent already, we have to do it!
                $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
                $persistenceManager->persistAll();
                //now organization ist persistent
                $GLOBALS['TSFE']->fe_user->setKey("ses","targetGroupChange",'Die Zielgruppe <strong>'. $targetGroup->getName() .'</strong> wurde neu angelegt.');
            }else{
                $this->targetGroupRepository->update($targetGroup);
                $GLOBALS['TSFE']->fe_user->setKey("ses","targetGroupChange",'Die Zielgruppe <strong>'. $targetGroup->getName() .'</strong> wurde geändert.');
            }

        }
        $redirectParams['targetGroup'] = $targetGroup;
        $this->redirect('successUpdate', 'TargetGroup', NULL, $redirectParams);


    }


    /**
     * @param \MUM\BjrFreizeit\Domain\Model\TargetGroup $tag
     *
     *
     */
    public function successUpdateAction(\MUM\BjrFreizeit\Domain\Model\TargetGroup $targetGroup){

        $msg = $GLOBALS['TSFE']->fe_user->getKey("ses","targetGroupChange");
        $this->setFlashMessage($msg);
        $this->view->assign('targetGroup',$targetGroup);
    }


    /**
     * @return string
     * per Ajax aufgerufen.
     */
    public function deleteAction() {
        $args = $this->request->getArguments();
        $targetGroup = $this->targetGroupRepository->findByUid($args['targetGroup']);
        $name = $targetGroup->getName();

        $this->targetGroupRepository->remove($targetGroup);
        $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
        $GLOBALS['TSFE']->fe_user->setKey("ses","targetGroupChange",'Die Zielgruppe '. $name .' ist gelöscht.');
        //return 'Ferienzeit ' . $name .' ist gelöscht';
        $this->redirect('list', 'TargetGroup');
    }


    protected function jsForDeleteTargetGroup(){
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
                        var region = $('#dialog').data('regionuid');
                        $.ajax({
                            async: 'true',
                            url: 'index.php',
                            type: 'POST',
                            data: {
                                eID: "bjrfeadmin",
                                request: {
                                    pluginName:  'Region',
                                    controller:  'Region',
                                    action:      'delete',
                                    arguments: {
                                        'pageId': pageId,
                                        'region': region
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
                var region = $(this).data('name');
                $('#dialog').data('regionuid', $(this).data('uid'));
                $('#dialog').html('Sind sie sicher, dass die Region "' + region +'" gelöscht werden soll?');
                $("#dialog").dialog("open");
            });




        });


EOT;
        return $js;

    }

}
?>