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
use \MUM\BjrFreizeit\Domain\Repository\CountryRepository;
use \MUM\BjrFreizeit\Domain\Model\Country ;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 *
 *
 * @package bjr_freizeitfeadmin
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CountryController extends \MUM\BjrFreizeitFeadmin\Controller\AbstractController {

	/**
	 * countryRepository
	 *
	 * @var \MUM\BjrFreizeit\Domain\Repository\CountryRepository;
     *
	 */
	protected $countryRepository;

    /**
     * @var array
     */
    protected $validationErrors;



    public function initializeAction()
    {
        $this->countryRepository = $this->objectManager->get('MUM\\BjrFreizeit\\Domain\\Repository\\CountryRepository');
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

		$countries = $this->countryRepository->findAll();
        $js = $this->jsForDeleteCountry();
        $GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('countryDelete', $js, false);

        $msg = $GLOBALS['TSFE']->fe_user->getKey("ses","countryChange");
        if(!empty($msg)){
            $this->setFlashMessage($msg);
        }

        $this->view->assign('countries', $countries);
	}

    /**
     * @param \MUM\BjrFreizeit\Domain\Model\Holiday $country
     * @return void
     */
    public function editAction(\MUM\BjrFreizeit\Domain\Model\Country $country) {

        $this->view->assign('country', $country);
	}


    /**
     * @param \MUM\BjrFreizeit\Domain\Model\Country $country
     *
     */
    public function newAction(\MUM\BjrFreizeit\Domain\Model\Country $country = NULL){
        $msg = $GLOBALS['TSFE']->fe_user->getKey("ses","editErrors");  //wenn Land schon vorhanden war, dann steht hier der Fehler drin
        if(strlen($msg) > 0) {
            $this->setFlashMessage($msg, 'Fehler', \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR);
            $GLOBALS['TSFE']->fe_user->setKey("ses", "editErrors", '');
        }
        $this->view->assign('country', $country);
        if(strlen($msg) == 0) {
            $this->view->assign('backlinkUrl', GeneralUtility::getIndpEnv('HTTP_REFERER'));
        }else{
            $this->view->assign('backlinkUrl', $GLOBALS['TSFE']->fe_user->getKey("ses","referrer") );
        }

    }


    /**
     * action update
     * @param \MUM\BjrFreizeit\Domain\Model\Country $country
     * @return void
     *
     */
    public function updateAction(\MUM\BjrFreizeit\Domain\Model\Country $country) {
        $redirectParams = array();
        $args = $this->request->getArguments();
        $referrer = $args['referer'];
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($referrer, 'Referrer');

        $GLOBALS['TSFE']->fe_user->setKey("ses","referrer", $referrer);

        if($country->_isNew() || $country->_isDirty()){

            if($country->_isNew()){
                if($this->validateCountry($args)) {
                    $country->setPid($this->settings['pidOrganizationFolder']);

                    $this->countryRepository->add($country);
                    //it is not persistent already, we have to do it!
                    $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
                    $persistenceManager->persistAll();
                    //now organization ist persistent
                    $GLOBALS['TSFE']->fe_user->setKey("ses","countryChange",'Die Ferienzeit <strong>'. $country->getName() .'</strong> wurde neu angelegt.');
                }else{
                    $errors = $this->getValidationErrors();
                    //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($errors, 'Errors');
                    //exit;
                    $GLOBALS['TSFE']->fe_user->setKey("ses", "editErrors", implode('. ', $errors));
                    $redirectParams['country'] = null;
                    $this->redirect('new', 'Country', NULL, $redirectParams);
                }

            }else{
                $this->countryRepository->update($country);
                $GLOBALS['TSFE']->fe_user->setKey("ses","countryChange",'Die Ferienzeit <strong>'. $country->getName() .'</strong> wurde geändert.');
            }

        }
        $redirectParams['country'] = $country;
        $this->redirect('successUpdate', 'Country', NULL, $redirectParams);


    }


    /**
     * @param \MUM\BjrFreizeit\Domain\Model\Country $country
     *
     *
     */
    public function successUpdateAction(\MUM\BjrFreizeit\Domain\Model\Country $country){

        $msg = $GLOBALS['TSFE']->fe_user->getKey("ses","countryChange");
        $referrer = $GLOBALS['TSFE']->fe_user->getKey("ses","referrer");
        $this->setFlashMessage($msg);
        $GLOBALS['TSFE']->fe_user->setKey("ses","countryChange", '');
        if(strpos($referrer, 'Leisure') !== FALSE){
            $this->view->assign('backlinkText','Zurück');
        }else{
            $this->view->assign('backlinkText','Zur Liste der Länder');
        }
        $this->view->assign('country',$country);
        $this->view->assign('backlinkUrl',$referrer);
    }


    /**
     * @return string
     * per Ajax aufgerufen.
     */
    public function deleteAction() {
        $args = $this->request->getArguments();
        $country = $this->countryRepository->findByUid($args['country']);
        $name = $country->getName();
        // @Todo 
//prüfen , ob es verwendet wird !!!!!
        $this->countryRepository->remove($country);
        $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
        $GLOBALS['TSFE']->fe_user->setKey("ses","countryChange",'Das Land '. $name .' ist gelöscht.');

        $this->redirect('list', 'Country');
    }


    protected function jsForDeleteCountry(){
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


    protected function validateCountry($args){
        $errors = array();
        /** @var  $validator \MUM\BjrFreizeit\Validation\Validator\CountryValidator */
        $validator = GeneralUtility::makeInstance('MUM\\BjrFreizeit\\Validation\\Validator\\CountryValidator');

        $_errors =  $validator->validate($args);

        if($_errors->hasErrors() > 0 ){
            //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($_errors, 'Errors');

            //$_errors = $validator->getErrors();
            foreach($_errors->getErrors() as $error){
                $errors[] = $error->getMessage();
                //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($error, 'Single Error');
            }
            //exit;
            $this->setValidationErrors($errors);
            return false;
        }
        return true;


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

    
}
?>