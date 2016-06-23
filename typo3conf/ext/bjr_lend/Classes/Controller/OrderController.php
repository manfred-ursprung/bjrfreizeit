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

/**
 *
 *
 * @package bjr_lend
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class OrderController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * @var \Bjr\BjrLend\Domain\Repository\OrderRepository
     * @inject
     */
    protected $orderRepository;


    public function initializeAction(){
        $this->orderRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Repository\\OrderRepository');
    }

    /**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$orders = $this->orderRepository->findAll();
		$this->view->assign('orders', $orders);
	}

	/**
	 * action show
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Order $order
	 * @return void
	 */
	public function showAction(\Bjr\BjrLend\Domain\Model\Order $order) {
		$this->view->assign('order', $order);
        //$this->view->assign('printPage', $this->settings['printOrderConfirmationPID']);
	}


    /**
     * @param \Bjr\BjrLend\Domain\Model\Order $order
     * @return void
     */
    public function printReservationAction(\Bjr\BjrLend\Domain\Model\Order $order) {
        /** @var $pageRenderer \TYPO3\CMS\Core\Page\PageRenderer */
        $pageRenderer = $GLOBALS['TSFE']->getPageRenderer();

        $pageRenderer->addCssFile('typo3conf/ext/bjr_lend/Resources/Public/Css/reset.css');
        $pageRenderer->addCssFile('typo3conf/ext/bjr_lend/Resources/Public/Css/bootstrap.css');
        $pageRenderer->addCssFile('typo3conf/ext/bjr_lend/Resources/Public/Css/print.css');

        $this->view->assign('order', $order);

    }

    public function printReservationAjaxAction() {

        $args = $this->request->getArguments();
        $order = $this->orderRepository->findByUid($args['order']);

        // $GLOBALS['TSFE']->additionalHeaderData['simverbrauchsrechner'] =
        //     '<link rel="stylesheet" type="text/css" href="' . t3lib_extMgm::siteRelPath($this->request->getControllerExtensionKey()) . 'Resources/Public/Css/print.css"></link>';

        $renderer = $this->getPlainRenderer('Print', 'html');

        $renderer->assign('order', $order);

        $content = $renderer->render();
        //var_dump($result);
            //exit();


        return  $content;
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
}
?>