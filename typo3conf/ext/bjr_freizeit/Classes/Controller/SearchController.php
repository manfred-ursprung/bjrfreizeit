<?php
namespace MUM\BjrFreizeit\Controller;

/***************************************************************
 *
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
 * SearchController
 */

use MUM\BjrFreizeit\Utility\SearchManager;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use MUM\BjrFreizeit\Domain\Model\Holiday;
use MUM\BjrFreizeit\Domain\Model\Country;
use MUM\BjrFreizeit\Domain\Model\TargetGroup;
use MUM\BjrFreizeit\Domain\Model\Tags;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use MUM\BjrFreizeit\Utility\CategoryMapper;


class SearchController extends \MUM\BjrFreizeit\Controller\AbstractController
{

    /**
     * @var \array
     */
    protected $mapSearchCategoriesToRepository;


    /**
     * @var \array
     */
    protected $mapSearchCategoriesToLeisureProperties;


    /**
     * leisureRepository
     *
     * @var \MUM\BjrFreizeit\Domain\Repository\LeisureRepository
     * @inject
     */
    protected $leisureRepository = NULL;

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
     * OrganizationRepository
     *
     * @var \MUM\BjrFreizeit\Domain\Repository\OrganizationRepository
     * @inject
     */
    protected $organizationRepository;


    /**
     * @var array
     */
    private $typoScript;

    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;




    public function initializeAction(){
        $this->mapSearchCategoriesToRepository = array(
            'Ferienzeiten'      => $this->holidayRepository,
            'Altersgruppe'      => $this->targetGroupRepository,
            'Land'              => $this->countryRepository,
            'Tag'               => $this->tagsRepository
        );
        $this->mapSearchCategoriesToLeisureProperties = array(
            'Ferienzeiten'      => 'holiday',
            'Altersgruppe'      => 'targetGroup',
            'Land'              => 'country',
            'Tag'               => 'tags'
        );
        //$this->typoScript = $this->getFullTypoScript();

        $css = $this->settings['stylesheet'];
        if (strpos($css, 'EXT:') === 0) {
            list($extKey, $local) = explode('/', substr($css, 4), 2);
            $css = '';
            if ((string)$extKey !== '' && ExtensionManagementUtility::isLoaded($extKey) && (string)$local !== '') {
                $css = ExtensionManagementUtility::extRelPath($extKey) . $local;
            }
        }
        if(strlen($css) > 0) {
            //$GLOBALS['TSFE']->getPageRenderer()->addCssFile($css, 'stylesheet', 'all', $title = 'bjrfreizeit', true, true);
            //$this->response->addAdditionalHeaderData('<link rel="stylesheet" type="text/css" href="' . $css .'"> ');
        }
        $js = $this->settings['javascript'];
        if (strpos($js, 'EXT:') === 0) {
            list($extKey, $local) = explode('/', substr($js, 4), 2);
            $js = '';
            if ((string)$extKey !== '' && ExtensionManagementUtility::isLoaded($extKey) && (string)$local !== '') {
                $js = ExtensionManagementUtility::extRelPath($extKey) . $local;
            }
        }
        if(strlen($js) > 0) {
            $this->pageRenderer->addJsFooterFile($js, 'text/javascript', false, false);
            //$GLOBALS['TSFE']->getPageRenderer()->addCssFile($css, 'stylesheet', 'all', $title = 'bjrfreizeit', true, true);
            //$this->response->addAdditionalHeaderData('<link rel="stylesheet" type="text/css" href="' . $css .'"> ');
        }
        //$this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
        //$this->logger->info('hallo');
    }

    /**
     *  count the number of leisures for every search category and displays it
     */
    public function quickSearchAction(){
        $searchCats = explode(',', $this->settings['quickSearch']['searchCategories']);
        //DebugUtility::debugInPopUpWindow($searchCats, 'Searchkategorien');
        $quickSearch = array();
        foreach($searchCats as $cat){
            $cat = trim($cat);
            if(array_key_exists($cat, $this->mapSearchCategoriesToRepository)){
                $repository = $this->mapSearchCategoriesToRepository[$cat];

                $item = new \stdClass();
                $item->name = $cat;
                $elements = $repository->findAll();
                $item->options = array();
                foreach($elements as $elem){
                    $option = new \stdClass();
                    if($cat == "Ferienzeiten"){
                       // DebugUtility::debugInPopUpWindow($elem, 'Ferienzeiten');
                    }
                    $option->name = $elem->getName();
                    $option->uid  = $elem->getUid();
                    $option->leisureProperty = CategoryMapper::getLeisurePropertiesFromSearchCategory($cat);
                    if($cat == "Ferienzeiten"){
                        $queryResult = $this->leisureRepository->findBy($option->leisureProperty, $elem->getUid());
                    }else{
                        $queryResult = $this->leisureRepository->findBy($option->leisureProperty, $elem);
                    }
                    $option->number = $queryResult->count();
                    $item->options[] = $option;
                }
                $quickSearch[] = $item;
            }else{
                //wrong setting in Typoscript
            }
        }

        //DebugUtility::debug($quickSearch, "Quicksearch");
        $this->view->assign('categories', $quickSearch);
        $this->view->assign('settings', $this->settings);
    }


    public function searchResultAction(){
        $this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
        //$this->logger->warning('hallo hier der logger' . __METHOD__);
        $debug = false;
        $isAjax = true;
        if($this->request->hasArgument('ajax')){
            $isAjax = true;
        }
        $args = $this->request->getArguments();

        /** @var  $searchForm \MUM\BjrFreizeit\Utility\LeisureSearchForm */
        $searchForm = GeneralUtility::makeInstance('MUM\\BjrFreizeit\\Utility\\LeisureSearchForm', $args);
        if($debug){
            return json_encode(array(
                'html' => print_r($searchForm, true),
                'args' => $args,
            ));
        }

        $leisures = $this->leisureRepository->findAllBySearchForm($searchForm);

        if($leisures->count() > 0){
            //$this->typoScript = $this->getFullTypoScript();
            $this->view->assign('found', true);
            $this->view->assign('leisures', $leisures);
            $this->view->assign('imagePath', $this->settings['leisureImagePath']);
            $this->view->assign('detailPage', $this->settings['detailPage']);
        }else{
            $this->view->assign('found', false);
        }
        if($isAjax) {
            $renderer = $this->getPlainRenderer('SearchResult', 'html');
            $renderer->assign('found', ($leisures->count() > 0));
            $renderer->assign('leisures', $leisures);
            $renderer->assign('imagePath', $this->settings['leisureImagePath']);
            $renderer->assign('detailPage', $this->settings['detailPage']);
            $html = $renderer->render();
            //$html = $this->view->render();
            $success = true;
            $this->logger->alert('SearchManager ', array(
                'keyword' => $searchForm->getDescription(),
            ));
            $this->logger->alert('Arguments ', $args);
            return json_encode(array(
                'html' => $html,
                'success' => $success,
                'arguments' => $args,
                'searchManagerCategory' => $searchForm->getCategory(),
                'number' => $leisures->count(),
            ));
        }else{

        }


    }


    public function extendedSearchAction(){

        $params = array(
            'countryList'       => $this->countryRepository->findAll(),
            'locationList'      => $this->getSelectLocationList(),
            'organizationList'  => $this->organizationRepository->findAll(),
            'searchForm'        => GeneralUtility::makeInstance('MUM\\BjrFreizeit\\Utility\\LeisureSearchForm'),
        );

        $this->view->assignMultiple($params);
    }


    protected function getSelectLocationList(){
        $rawList = $this->leisureRepository->findAllLocations(true);
        $selectList = array();
        if(count($rawList) > 0) {
            foreach ($rawList as $location) {
                $selectList[] = array('name' => $location['location']);
            }
        }
        return $selectList;
    }

}