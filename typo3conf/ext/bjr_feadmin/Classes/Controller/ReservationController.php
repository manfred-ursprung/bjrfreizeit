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
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 *
 *
 * @package bjr_feadmin
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ReservationController extends AbstractController {

	/**
	 * orderRepository
	 *
	 * @var \Bjr\BjrLend\Domain\Repository\ReservationRepository
	 * @inject
	 */
	protected $reservationRepository;

    protected $extensionName ;


    public function initializeAction(){
        //my javascript file for this plugin
        $this->extensionName = 'bjr_feadmin';
        $js = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($this->request->getControllerExtensionKey())
                        .'Resources/Public/Scripts/feadminLib.js';
        $GLOBALS['TSFE']->getPageRenderer()->addJsFooterFile($js);
    }

    /**
     * @param string $sortBy
     * @param string $sortOrder
     */
	public function listAction($sortBy='issueStart', $sortOrder = 'desc') {
        $reservations = NULL;

        $organization = $this->findOrganizationBySession();
        if(!is_a($organization, '\Bjr\BjrLend\Domain\Model\Organization')) {
            $organization = $this->findOrganizationByLogin();
            if (is_a($organization, '\Bjr\BjrLend\Domain\Model\Organization')) {
                $this->userSession->setKey('organization', $organization->getUid());

            } else {
                $this->setFlashMessage('Es konnte keine zugehörige Ausleihstelle zu Ihrem Account gefunden werden.');
            }
        }else{

        }
        if(is_a($organization, '\Bjr\BjrLend\Domain\Model\Organization')){
            if(in_array($sortBy, array('issueStart', 'article.title', 'customerName'))
                && in_array($sortOrder, array('asc', 'desc'))){
                $reservations = $this->reservationRepository->findByOrganization($organization, $sortBy, $sortOrder);

            }

        }
        //$js = $this->jsForDeleteArticle();
        //$GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('organizationList', $js, false);
        $flashMessage = $GLOBALS['TSFE']->fe_user->getKey("ses", "reservationListInfo");
        if(!empty($flashMessage)) {
            $this->setFlashMessage($flashMessage);
        }
        $GLOBALS['TSFE']->fe_user->setKey("ses", "reservationListInfo", '');


		$this->view->assign('reservations', $reservations);
	}


    /**
     * @return string
     * per Ajax aufgerufen.
     */
    public function deleteAction() {
        $args = $this->request->getArguments();
        /** @var  $reservation \Bjr\BjrLend\Domain\Model\Reservation */
        $reservation = $this->reservationRepository->findByUid($args['reservation']);

        $this->reservationRepository->remove($reservation);
        $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
        $GLOBALS['TSFE']->fe_user->setKey("ses", "reservationListInfo", 'Bestellung ' . $reservation->asString() .' ist gelöscht');
        //$this->setFlashMessage('Bestellung ' . $reservationName .' ist gelöscht');
        $this->redirect('list', 'Reservation', NULL);
    }

	/**
	 * action edit
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Reservation $reservation
	 * @return void
	 */
	public function editAction(\Bjr\BjrLend\Domain\Model\Reservation $reservation) {
		$this->view->assign('reservation', $reservation);
	}


    /**
     * called by AJAX
     */
    public function showCustomerAction(){
        //return 'Hallo ShowCustomer Action';
        $reservationId = $this->request->getArgument('reservation');
        $reservation = $this->reservationRepository->findByUid($reservationId);
        if($reservation){
            $renderer = $this->getPlainRenderer('ShowCustomer', 'html');
            $renderer->assign('reservation', $reservation);
            $content = $renderer->render();
        }else{
            $content = 'Es wurde keine Bestellung gefunden für die ID '.$reservationId;
        }

        return $content;
    }


    /**
     * @return string
     * called by AJAX
     */
    public function sendMailAction(){
        $reservationId = $this->request->getArgument('reservation');
        /** @var  $reservation \Bjr\BjrLend\Domain\Model\Reservation */
        $reservation = $this->reservationRepository->findByUid($reservationId);
        $mailType  = $this->request->getArgument('mailType');
        if($reservation){
            list($result, $failedRecipients) = $this->sendMail($reservation, $mailType);

            if($result > 0){
                $result = array('success' => 'war erfolgreich',
                                'mailCount' => $result,
                                'header'    => 'Bestellbestätigung'
                );
                //TODO Status der Reservierung ändern!
                if($mailType == 'confirm'){
                    $reservation->setStatus(\Bjr\BjrLend\Domain\Model\Reservation::STATUS_CONFIRMED);
                }elseif($mailType == 'reject'){
                    $reservation->setStatus(\Bjr\BjrLend\Domain\Model\Reservation::STATUS_REJECTED);
                    $result['header'] = 'Bestellablehnung';
                }
                $this->reservationRepository->add($reservation);

            }else {
                $result = array('success' => 'war NICHT erfolgreich',
                    'mailCount' => $result,
                    'header'    => '"Ablehnen"',
                );
            }
        }else{
            $result = array('success' => 'war NICHT erfolgreich. Reservierung wurde nicht gefunden.',
                'mailCount' => 0);
        }
        $result['mailType'] = $mailType == 'confirm' ? 'Bestätigungsmail' : 'Bestellablehnungs-Mail';

        /** @var  $renderer \TYPO3\CMS\Fluid\View\StandaloneView*/
        $renderer = $this->getPlainRenderer('SendMail', 'html');
        $renderer->assign('result', $result);
        return $renderer->render();
        //return json_encode(array($result));
    }

    /**
     * @param \Bjr\BjrLend\Domain\Model\Reservation $reservation
     * @return array
     * Prepares a HTML-Mail to confirm customer the reservation of his article
     */
    private function sendMail(\Bjr\BjrLend\Domain\Model\Reservation $reservation, $mailType){
        $mailConfig = array();
        $mailConfig['receiver'] = $reservation->getCustomerEmail();
        $mailConfig['sender'] 	= $this->settings['orderSenderEmail'];
        /** @var  $organization \Bjr\BjrLend\Domain\Model\Organization  */
        $organization = $this->organizationRepository->findByReservation($reservation);
        if($mailType == 'confirm') {
            //$subject = sprintf('Reservierung für %s bestätigen.', $organization->getName());
            $subject = 'Bestätigung über ihre Bestellung.';
            $template = 'MailConfirm';
        }elseif($mailType == 'reject'){
            $subject = 'Ablehnung der Bestellung über brauch-mal-kurz.de';
            $template = 'MailReject';
        }

        $mailConfig['subject'] = $subject;
        $renderer = $this->getPlainRenderer($template, 'html');
        //damit f:translate funktioniert
        $extensionName = $this->request->getControllerExtensionName();
        $renderer->getRequest()->setControllerExtensionName($extensionName);
        $renderer->assign('reservation', $reservation);


        $renderer->assign('organization', $organization);
        $content = $renderer->render();
        $mailConfig['message'] = $content;
        list($mail, $result) = $this->doSendMail($mailConfig);


        return array( $result,
                     $mail->getFailedRecipients()
        );
    }

    /**
     * @param $mailConfig
     * @return array
     */
    private function doSendMail($mailConfig)
    {
        /* @var $mail \TYPO3\CMS\Core\Mail\MailMessage */
        $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
        $mail->setTo($mailConfig['receiver']);
        $mail->setFrom($mailConfig['sender']);
        $mail->setSubject($mailConfig['subject']);
        $mail->setBody($mailConfig['message'], 'text/html');
        $result = $mail->send();
        return array($mail, $result);
    }



    /**
     * This creates another stand-alone instance of the Fluid view to render a template
     * @param string $templateName the name of the template to use
     * @param string $format the format of the fluid template "html" or "txt"
     * @return  \TYPO3\CMS\Fluid\View\StandaloneView the Fluid instance
     */
    protected function getPlainRenderer($templateName = 'default', $format = 'html') {
        $view = $this->objectManager->create('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        $view->setFormat($format);

        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
        //echo 'TemplateRootPath: ' . $templateRootPath;
        $templatePathAndFilename = $templateRootPath . $this->request->getControllerName().'/' . $templateName . '.' . $format;
        //echo 'TemplatePathAndFilename: ' . $templatePathAndFilename;
        $view->setTemplatePathAndFilename($templatePathAndFilename);
        $layoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['layoutRootPath']);
        $view->setLayoutRootPath($layoutRootPath);
        $partialsRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['partialRootPath']);
        $view->setPartialRootPath($partialsRootPath);
        $view->assign('settings', $this->settings);
        return $view;
    }




}
?>