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
//use TYPO3\CMS\Belog\Controller\AbstractController;

/**
 *
 *
 * @package bjr_feadmin
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class RegionController extends \Bjr\BjrFeadmin\Controller\AbstractController {

	/**
	 * regionRepository
	 *
	 * @var \Bjr\BjrLend\Domain\Repository\RegionRepository
	 * @inject
	 */
	protected $regionRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$regions = $this->regionRepository->findAll();
        $js = $this->jsForDeleteRegion();
        $GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('regionDelete', $js, false);

        $this->view->assign('regions', $regions);
	}

    /**
     * @param \Bjr\BjrLend\Domain\Model\Region $region
     * @return void
     */
    public function editAction(\Bjr\BjrLend\Domain\Model\Region $region) {

        $this->view->assign('region', $region);
	}


    /**
     * @param \Bjr\BjrLend\Domain\Model\Region $region
     *
     */
    public function newAction(\Bjr\BjrLend\Domain\Model\Region $region = NULL){

        $this->view->assign('region', $region);

    }


    /**
     * action update
     * @param \Bjr\BjrLend\Domain\Model\Region $region
     * @return void
     *
     */
    public function updateAction(\Bjr\BjrLend\Domain\Model\Region $region) {
        $redirectParams = array();  //array('passwordChange' => '',    'organization' => $organization,'organizationChange' => ''       );
        $args = $this->request->getArguments();

        if($region->_isNew() || $region->_isDirty()){

            if($region->_isNew()){
                $region->setPid($this->settings['pidOrganizationFolder']);

                $this->regionRepository->add($region);
                //it is not persistent already, we have to do it!
                $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
                $persistenceManager->persistAll();
                //now organization ist persistent
                $GLOBALS['TSFE']->fe_user->setKey("ses","regionChange",'Die Region <strong>'. $region->getName() .'</strong> wurde neu angelegt.');
            }else{
                $this->regionRepository->update($region);
                $GLOBALS['TSFE']->fe_user->setKey("ses","regionChange",'Die Region <strong>'. $region->getName() .'</strong> wurde geändert.');
            }

        }
        $redirectParams['region'] = $region;
        $this->redirect('successUpdate', 'Region', NULL, $redirectParams);


    }


    /**
     * @param \Bjr\BjrLend\Domain\Model\Region $region
     *
     *
     */
    public function successUpdateAction(\Bjr\BjrLend\Domain\Model\Region $region){

        $msg = $GLOBALS['TSFE']->fe_user->getKey("ses","regionChange");
        $this->setFlashMessage($msg);
        $this->view->assign('region',$region);
    }


    /**
     * @return string
     * per Ajax aufgerufen.
     */
    public function deleteAction() {
        $args = $this->request->getArguments();
        $region = $this->regionRepository->findByUid($args['region']);
        $regionName = $region->getName();

        $this->regionRepository->remove($region);
        $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
        return 'Region ' . $regionName .' ist gelöscht';
    }


    protected function jsForDeleteRegion(){
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