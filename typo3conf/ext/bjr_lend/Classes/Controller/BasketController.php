<?php
namespace Bjr\BjrLend\Controller;

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
 * steps of ordering:
 * - ListLongAction
 * - ConfirmationAction
 * - CompleteAction
 *
 *
 * @package bjr_lend
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class BasketController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * @var \Bjr\BjrLend\Utility\UserSession
	 * @inject
	 */
	protected $userSession;

	/**
	 * @var \Bjr\BjrLend\Domain\Repository\BasketRepository
	 */
	protected $basketRepository;

	/**
	 * @var \Bjr\BjrLend\Domain\Repository\ArticleRepository
	 */
	protected $articleRepository;

	/**
	 * @var \Bjr\BjrLend\Domain\Repository\OrderRepository
	 */
	protected $orderRepository;



	public function initializeAction(){
        parent::initializeAction();
		$this->userSession = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Utility\\UserSession');
		$this->basketRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Repository\\BasketRepository');
		$this->articleRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Repository\\ArticleRepository');
		$this->orderRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Repository\\OrderRepository');
	}

	/**
	 *
	 */
	public function initializeCompleteAction(){


	}

	/**
	 *
	 */
	public function initializeSendMailAction(){
		$this->orderRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Repository\\OrderRepository');

	}


	public function listLongAction() {
		$basket = $this->basketRepository->getBasket();
        if($basket->isEmpty()){
            //Flashmessage
            // eigene Message setzten, "OK" setzt hier den grauen Ausgabekasten im BE
            $this->controllerContext->getFlashMessageQueue()->enqueue(
                $this->objectManager->get(
                    'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                    'Der Warenkorb ist leer. Bitte erst einen Artikel hinzufügen.',
                    'Meldung',
                    \TYPO3\CMS\Core\Messaging\FlashMessage::INFO,
                    false
                )
            );
        }

		$this->view->assign('basket', $basket);

	}


	public function listShortAction(){
		/* @var $basket \Bjr\BjrLend\Domain\Model\Basket */
		$basket = $this->basketRepository->getBasket();

		$this->view->assign('basketItems', $basket->getItems());
	}

	/**
	 * Daten sind alle eingegeben, anzeigen der Daten und Benutzer zum Bestätigen auffordern
	 */
	public function confirmationAction(){
		/* @var $basket \Bjr\BjrLend\Domain\Model\Basket */
		$basket = $this->basketRepository->getBasket();
		$args = $this->request->getArguments();
		if(isset($args['action']) && ($args['action'] == 'complete')){
			$this->completeAction();
		}
		$customer = $this->getCustomer($args);
		$this->view->assign('basket', $basket);
		$this->view->assign('customer', $customer);
	}

	/**
	 * letzter Schritt im Reservierungsprozess
	 * aus Basket wird eine Order , ausserdem wird ein Ausleihdatum generiert
	 */
	public function completeAction(){
        ini_set('display_errors',1);
		$basket = $this->basketRepository->getBasket();
		$args = $this->request->getArguments();
		$customer = $this->getCustomer($args);
		$order = $basket->makeOrder($customer);

		//warenkorb löschen
		$this->basketRepository->removeBasket();


		//Bestellmail versenden
		$result = $this->sendOrderMail($order);

		// Redirect to show the order */
		$this->redirect('show', 'Order', NULL, array('order' => $order), $this->settings['finishedpage']);

	/*	$this->view->assign('customer', $customer);
		$this->view->assign('order', $order);
		$this->view->assign('sendMail', $result);
	*/
	}




	/**
	 * @return string
	 * Artikel aus Warenkorb entfernen
	 * Ajax call
	 */
	public function removeArticleAction(){
        //return 'Der Artikel wurde entfernt';
		$args = $this->request->getArguments();
        if(isset($args['posno'])){
            //$article = $this->articleRepository->findByUid($args['articleUid']);
            /* @var $basket \Bjr\BjrLend\Domain\Model\Basket */
            $basket = $this->basketRepository->getBasket();
            $basket->removePosNo($args['posno']);
            $basket->storeInSession();

            $renderer = $this->getPlainRenderer('ListShortAjax', 'html');
            $items = $basket->getItems();
            $renderer->assign('basketItems', $items);
            $content = $renderer->render();
            if($basket->getNumber() > 0){
                $message = $this->getMessageAfterRemove();
            }else{
                $message = $this->getMessageBasketIsEmpty();

            }
        }else{
            $message = 'Es ist ein Fehler aufgetreten, der Artikel konnte nicht entfernt werden.';
        }
		return json_encode(array('text'  => $message,
                                'content' => $content,
                                'basket'  =>json_encode($basket),
                                'empty'   => ($basket->getNumber() == 0)
        ));
	}

	/**
	 * This creates another stand-alone instance of the Fluid view to render a template
	 * @param string $templateName the name of the template to use
	 * @param string $format the format of the fluid template "html" or "txt"
	 * @return Tx_Fluid_View_StandaloneView the Fluid instance
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

	/**
	 * @param $args
	 * @param $customer
	 * @return mixed
	 */
	protected function getCustomer($args)
	{
		$customer = array();
		if (isset($args['customerName'])){
			$customer['name'] = $args['customerName'];
		}

		if (isset($args['customerPhone'])){
			$customer['phone'] = $args['customerPhone'];
		}
		if (isset($args['customerEmail'])){
			$customer['email'] = $args['customerEmail'];
			return $customer;
		}
		return $customer;
	}

	/**
	 * zum Testen der Mail Funktion
	 */
	public function sendMailAction(){
		$order = $this->orderRepository->findByUid(27);
		//$this->sendOrderMail($order);
		$message = 'Test<br />hier der Body der TEstmail.<hr />';
		$renderer = $this->getPlainRenderer('Mailbody', 'html');
		//damit f:translate funktioniert
		$extensionName = $this->request->getControllerExtensionName();
		$renderer->getRequest()->setControllerExtensionName($extensionName);
		$renderer->assign('order', $order);
		$siteUrl = \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
		$renderer->assign('siteUrl', $siteUrl);
		$content = $renderer->render();

		// Mail Content Array aufbauen
		$email['receiver'] = 'mu@farm01.de'; //Empfängeradresse
		$email['sender']   = $this->settings['orderSenderEmail'];
		$email['subject']= sprintf('Bestellung von %s', $order->getCustomerName() );
		$email['message']= $content;      //$message;
		/* @var $mail \TYPO3\CMS\Core\Mail\MailMessage  */
		$mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
		$mail->setTo($email['receiver']);
		$mail->setFrom($email['sender']);
		$mail->setSubject($email['subject']);
		$mail->setBody($email['message'], 'text/html'); //versendet html mail, alternativ: 'text/plain'

		$result = $mail->send();
		$this->view->assign('recipients', $mail->getFailedRecipients());
		$this->view->assign('result', $result);


	}

	private function sendOrderMail(\Bjr\BjrLend\Domain\Model\Order $order){
		$mailConfig = array();
		$mailConfig['receiver'] = $order->getCustomerEmail();
		$mailConfig['sender'] 	= $this->settings['orderSenderEmail'];
		//$mailConfig['subject'] 	= sprintf('Bestellung von %s', $order->getCustomerName() );
        //Bestellung über brauch-mal-kurz.de
        $mailConfig['subject'] 	= 'Bestellung über brauch-mal-kurz.de';

		$renderer = $this->getPlainRenderer('MailbodyCustomer', 'html');
		//damit f:translate funktioniert
		$extensionName = $this->request->getControllerExtensionName();
		$renderer->getRequest()->setControllerExtensionName($extensionName);
		$renderer->assign('order', $order);
		$siteUrl = \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
		$renderer->assign('siteUrl', $siteUrl);
		$content = $renderer->render();
		$mailConfig['message'] = $content;

		/* @var $mail \TYPO3\CMS\Core\Mail\MailMessage  */
		$mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
		$mail->setTo($mailConfig['receiver']);
		$mail->setFrom($mailConfig['sender']);
		$mail->setSubject($mailConfig['subject']);
		$mail->setBody($mailConfig['message'], 'text/html');
		$result = $mail->send();

        //Mail to lender. For each article we have to send an email
        $mailConfig['subject'] 	= sprintf('Eingegangene Bestellung von %s', $order->getCustomerName() );
        foreach($order->getPositions() as $position){
            /* @var $position \Bjr\BjrLend\Domain\Model\OrderPosition */
            $mailConfig['lender'] = $position->getOrganizationName();
            if(strlen($position->getArticle()->getEmail()) > 0){
                $mailConfig['lenderEmail'] = $position->getArticle()->getEmail();
            }else{
                $mailConfig['lenderEmail'] = $position->getOrganizationEmail();
            }
            $mailConfig['article'] = $position->getArticle();

            $renderer = $this->getPlainRenderer('MailbodyLender', 'html');
            $renderer->getRequest()->setControllerExtensionName($extensionName);
            $renderer->assign('order', $order);
            $renderer->assign('position', $position);
            $renderer->assign('siteUrl', $siteUrl);
            $content = $renderer->render();
            $mailConfig['message'] = $content;
            $result += $this->sendMailToLender($mailConfig);
        }


		return array('sent' => $result,
			'failedRecipient' => $mail->getFailedRecipients(),
			'mailConfig'	=> $mailConfig,
		);
	}


    private function sendMailToLender($mailConfig){
        /* @var $mail \TYPO3\CMS\Core\Mail\MailMessage  */
        $mail = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Mail\\MailMessage');
        $mail->setTo($mailConfig['lenderEmail']);
        //$mail->setTo($mailConfig['receiver']);
        $mail->setFrom($mailConfig['sender']);
        $mail->setSubject($mailConfig['subject']);
        $mail->setBody($mailConfig['message'], 'text/html');
        $result = $mail->send();
        return $result;
    }


    private function getMessageAfterRemove(){
        return '<div class="typo3-messages"><div class="typo3-message message-information"><div class="message-header">Meldung</div><div class="message-body">Der Artikel wurde aus dem  Warenkorb entfernt.</div></div></div>';
    }

    private function getMessageBasketIsEmpty(){
        return '<div class="typo3-messages"><div class="typo3-message message-information"><div class="message-header">Meldung</div><div class="message-body">Der Warenkorb ist leer. Bitte erst einen Artikel hinzufügen.</div></div></div>';
    }
}
?>