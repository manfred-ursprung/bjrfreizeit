<?php
namespace MUM\BjrFreizeit\Utility;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016
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
 * SearchManager : realisiert eine anspruchsvolle Suche
 *                 mit UND-Verknüpfungen und Satzteilen
 *
 *
 */

use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \MUM\BjrFreizeit\Utility\CategoryMapper;

class SearchManager {

    /**
     * @var  \array
     */
    public $category;


    /**
     * @var \string
     */
    protected $location;


    /**
     * @var \string
     */
    protected $tag;


    /**
     * SearchManager constructor.
     * @param $searchArgs  array  keys : searchBox, searchLocation
    }
     */
    public function __construct($searchArgs) {
        if(!empty($searchArgs)) {
            $this->initSearchValues($searchArgs);
        }

    }


    protected function initSearchValues($searchArgs){
        if(!empty($searchArgs['category']) && (!empty($searchArgs['property']))){
            $this->category = array(
                'leisureProperty'  => CategoryMapper::getLeisurePropertiesFromSearchCategory($searchArgs['category']),
                'value' => $searchArgs['property'],
            );

        }else{
            $this->category = array();
        }
        if(!empty($searchArgs['searchLocation'])){
            $this->location = $searchArgs['searchLocation'];
        }else{
            $this->location = '';
        }
        if(!empty($searchArgs['tag'])){
            $this->tag = $searchArgs['tag'];
        }else{
            $this->tag = '';
        }
    }




    /**
     * @return \array
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param \array $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }




    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }


    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }




}
