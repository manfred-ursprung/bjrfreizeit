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
     * @var \array
     */
    protected $ands;

    /**
     * @var \string
     */
    protected $location;


    /**
     * @var \string
     */
    protected $country;


    /**
     * @var \string
     */
    protected $organization;


    /**
     * @var \string
     */
    protected $priceFrom;


    /**
     * @var \string
     */
    protected $priceTo;


    /**
     * @var \string
     */
    protected $startDate;


    /**
     * @var \string
     */
    protected $endDate;



    /**
     * SearchManager constructor.
     * @param $searchArgs  array  keys : searchBox, searchLocation
    }
     */
    public function __construct($searchArgs) {
        if(!empty($searchArgs)) {
            unset($searchArgs['action']);
            unset($searchArgs['controller']);
            unset($searchArgs['ajax']);
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
        unset($searchArgs['category']);
        unset($searchArgs['property']);
        $exclude = array('priceFrom', 'priceTo', 'startDate', 'endDate');
        foreach($searchArgs as $key => $val){
            if(!in_array($key, $exclude)) {
                $this->ands[$key] = $val;
            }
        }

    }

    /**
     * @return array
     */
    public function getAnds()
    {
        return $this->ands;
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
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param string $organization
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
    }

    /**
     * @return string
     */
    public function getPriceFrom()
    {
        return $this->priceFrom;
    }

    /**
     * @param string $priceFrom
     */
    public function setPriceFrom($priceFrom)
    {
        $this->priceFrom = $priceFrom;
    }

    /**
     * @return string
     */
    public function getPriceTo()
    {
        return $this->priceTo;
    }

    /**
     * @param string $priceTo
     */
    public function setPriceTo($priceTo)
    {
        $this->priceTo = $priceTo;
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param string $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param string $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }







}
