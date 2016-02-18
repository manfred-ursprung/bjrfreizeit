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

class SearchManager {

    /**
     * @var  \string
     */
    public $searchStr;

    /**
     * @var  \array
     */
    public $searchWords;

    /**
     * @var  \array
     */
    public $ands;

    /**
     * @var  \array
     */
    public $ors;

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
        $this->ors = [];
        $this->ands = [];
        $this->searchWords = [];
        $this->parseSearchString($this->searchStr);


    }


    protected function initSearchValues($searchArgs){
        if(!empty($searchArgs['searchBox'])){
            $this->searchStr = $searchArgs['searchBox'];
        }else{
            $this->searchStr = '';
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

    public function parseSearchString($searchstr){
        /*
         * zusammenhängende Worte , UND verknüpfung
         */
        $words = explode(' ', $searchstr);
        for($i=0; $i < count($words); $i++){
            $w = $words[$i];
            switch(substr($w, 0, 1)){
                case '"':
                    $i = $this->addWordGroup($i,$words);
                    break;
                case '+':
                    $this->ands[] = ltrim($words[$i], '+');
                    break;
                case 'UND':
                    $i = $this->addAndRelation($i, $words);
                    break;
                default:
                    $this->ors[] = $words[$i];
                    break;

            }
        }

    }

    /**
     * @param $index
     * @param $words
     * @return mixed
     * collect all words belonging to a group and then clueing together by space
     * and putting in $ors
     */
    public function addWordGroup($index, $words){
        if(substr($words[$index], 0, 1) == '"'){
            $group = array(ltrim($words[$index], '"'));
            do{
                $index++;
                $group[] = rtrim($words[$index], '"');

            }while(substr($words[$index], -1) != '"');
            $this->ors[] = implode(' ', $group);
        }
        return $index;
    }

    public function addAndRelation($index, $words){
        if($words[$index] == 'UND'){
            $this->ands[] = ltrim($words[$index-1], '+');
            if((count($this->ors) > 0) && $this->ors[count($this->ors)-1] == ltrim($words[$index-1], '+')){
                array_pop($this->ors);
            }
            $this->ands[] = ltrim($words[$index+1], '+');
            $index++;
        }elseif(substr($words[$index], 0,1) == '+' ){
                if($this->isWordGroup($index, $words)){
                    list($group, $index) = $this->getWordGroup($index, $words);
                    $this->ands[] = implode(' ', $group);
                }else{
                    $this->ands[] = ltrim($words[$index], '+');
                }
        }
        return $index;
    }


    /**
     * @param $index
     * @param $words
     * @return array
     */
    protected function getWordGroup($index, $words)
    {
        $group = array(ltrim($words[$index], '"'));
        do {
            $index++;
            $group[] = rtrim($words[$index], '"');


        } while (substr($words[$index], -1) != '"');
        return array($group, $index);
    }


    protected function isWordGroup($start, $words){
        $w = ltrim($words[$start], '+');
        return(substr($w, 0, 1) == '"');
    }



    /**
     * @return string
     */
    public function getSearchStr()
    {
        return $this->searchStr;
    }

    /**
     * @param string $searchStr
     */
    public function setSearchStr($searchStr)
    {
        $this->searchStr = $searchStr;
    }

    /**
     * @return array
     */
    public function getSearchWords()
    {
        return $this->searchWords;
    }

    /**
     * @param array $searchWords
     */
    public function setSearchWords($searchWords)
    {
        $this->searchWords = $searchWords;
    }

    /**
     * @return array
     */
    public function getAnds()
    {
        return $this->ands;
    }

    /**
     * @param array $ands
     */
    public function setAnds($ands)
    {
        $this->ands = $ands;
    }

    /**
     * @return array
     */
    public function getOrs()
    {
        return $this->ors;
    }

    /**
     * @param array $ors
     */
    public function setOrs($ors)
    {
        $this->ors = $ors;
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
