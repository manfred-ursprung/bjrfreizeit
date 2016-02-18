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

use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use MUM\BjrFreizeit\Domain\Model\Holiday;
use MUM\BjrFreizeit\Domain\Model\Country;
use MUM\BjrFreizeit\Domain\Model\TargetGroup;
use MUM\BjrFreizeit\Domain\Model\Tags;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;


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
     * @var array
     */
    private $typoScript;






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
            $GLOBALS['TSFE']->getPageRenderer()->addCssFile($css, 'stylesheet', 'all', $title = 'bjrfreizeit', true, true);
            //$this->response->addAdditionalHeaderData('<link rel="stylesheet" type="text/css" href="' . $css .'"> ');
        }
        $js = $this->settings['javascript'];
        if (strpos($css, 'EXT:') === 0) {
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
                    $option->name = $elem->getName();
                    $option->leisureProperty = $this->mapSearchCategoriesToLeisureProperties[$cat];
                    $queryResult = $this->leisureRepository->findBy($this->mapSearchCategoriesToLeisureProperties[$cat], $elem);
                    $option->number = $queryResult->count();
                    $item->options[] = $option;
                }
                $quickSearch[] = $item;
            }
        }

        //DebugUtility::debug($quickSearch, "Quicksearch");
        $this->view->assign('categories', $quickSearch);
        $this->view->assign('settings', $this->settings);
    }


    public function searchResultAction(){
        if(isset($this->settings['action']) && ($this->settings['action'] == 'quickSearch')){
            return $this->quickSearchAction();
        }
        $args = $this->request->getArguments();

    }
}