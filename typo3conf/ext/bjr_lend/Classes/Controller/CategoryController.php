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
class CategoryController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

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


	public function initializeAction(){
		//fallback to current pid if no storagePid is defined
		if (version_compare(TYPO3_version, '6.0.0', '>=')) {
			$configuration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		} else {
			$configuration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		}
		//t3lib_utility_Debug::debugInPopUpWindow($configuration);
		if (empty($configuration['persistence']['storagePid'])) {
			$currentPid['persistence']['storagePid'] = $GLOBALS["TSFE"]->id;
			$currentPid['persistence']['storagePid'] = 85;
			$this->configurationManager->setConfiguration(array_merge($configuration, $currentPid));
		}
		$this->configuration = $configuration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		//$this->response->addAdditionalHeaderData('<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAEcQo2dy8dM0fA429C0ZZIcKKyH71r2Tc&amp;sensor=false" type="text/javascript"></script>');

	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$articles = $this->articleRepository->findAll();
		$this->view->assign('articles', $articles);
	}

	/**
	 * action show
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Article $article
	 * @return void
	 */
	public function showAction(\Bjr\BjrLend\Domain\Model\Article $article) {
		$this->view->assign('article', $article);
	}

	/**
	 * action search
	 *
	 * @return void
	 */
	public function searchAction() {

	}



	/**
	 * liefert einen Menübaum über alle Kategorien
	 * für die Sidebar Navigation. Called from Typoscript
	 * Settings werden in TS gesetzt
	 */
	public function menuTreeAction(){
		$menuTree = $this->categoryRepository->getMenuTree();
		$this->view->assign('menuTree', $menuTree);
		$this->view->assign('listPage', $this->settings['listPage']);
	}

	/**
	 * liefert einen Menübaum über alle Kategorien
	 * für die Top Navigation. Called from Typoscript
	 * Settings werden in TS gesetzt
	 */
	public function menuTreeTopAction(){
		$menuTree = $this->categoryRepository->getMenuTree();
		$this->view->assign('menuTree', $menuTree);
		$this->view->assign('listPage', $this->settings['listPage']);
	}


	/**
	 * @return string
	 * Ajax request from search formula to fill select box with subcategories
	 * for special parent category
	 */
	public function subCategoryAction(){
		$args = $this->request->getArguments();
		$parentCat = $args['category'];
		if($parentCat <= 0){
			$content = '<option>Keine Unterkategorie gefunden</option>';
		}else{
			$subCategories = $this->categoryRepository->getSubCategories($parentCat);

			$renderer = $this->getPlainRenderer('SubCategory', 'html');
			$renderer->assign('categories', $subCategories);
			$content = $renderer->render();
		}
		return $content;
	}

	/**
	 * This creates another stand-alone instance of the Fluid view to render a template
	 * @param string $templateName the name of the template to use
	 * @param string $format the format of the fluid template "html" or "txt"
	 * @return Tx_Fluid_View_StandaloneView the Fluid instance
	 */
	protected function getPlainRenderer($templateName = 'default', $format = 'html') {
		$view = $this->objectManager->create('TYPO3\CMS\Fluid\View\StandaloneView');
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