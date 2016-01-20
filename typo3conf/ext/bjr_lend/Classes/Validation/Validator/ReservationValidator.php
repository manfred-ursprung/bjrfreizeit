<?php
namespace Bjr\BjrLend\Validation\Validator;

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

use  \TYPO3\CMS\Core\Utility\GeneralUtility;
use   \Bjr\BjrLend\Domain\Repository\ArticleRepository;
use   \TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class ReservationValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {


    /**
     * @var \Bjr\BjrLend\Domain\Model\Article
     */
    protected $article;


    /**
     * @var \string
     */
    protected $format;

    /**
     * ReservationRepository
     *
     * @var \Bjr\BjrLend\Domain\Repository\ReservationRepository
     * @inject
     */
    protected $reservationRepository;



    /**
     * @param array $validationOptions
     * $param \Bjr\BjrLend\Domain\Model\Article $article
     * @param string $format
     */
    public function __construct($validationOptions = array(), \Bjr\BjrLend\Domain\Model\Article $article, $format ='%d.%m.%Y'){
        parent::__construct($validationOptions);
        $this->format = $format;
        $this->article = $article;
    }


    /**
     * @param mixed $value  array with keys issueStartDay and issueEndDay
     */
    public function isValid($value){
        $valid = true;
        if(!$this->checkDate($value['issueStartDay'])){
            $valid = false;
            $this->addError('Sie müssen ein gültiges Anfangsdatum eingeben',
                1416308406);
        }
        if(!$this->checkDate($value['issueEndDay'])){
            $valid = false;
            $this->addError('Sie müssen ein gültiges Endedatum eingeben',
                1416308476);
        }

        if($valid){
            //start day not in past
            if($this->dayNotInPast($value['issueStartDay'])){
                if(!$this->startBeforeEnd($value['issueStartDay'], $value['issueEndDay'])){
                    $valid = false;
                    $this->addError('Das Endedatum muss größer als das Startdatum sein.',
                        1416309162);
                }

            }else{
                $valid = false;
                $this->addError('Das Startdatum muss mindestens einen Tag in der Zukunft sein.',
                    1416309162);
            }
        }
        $period = array(
            $this->toUnixTimestamp($value['issueStartDay']),
            $this->toUnixTimestamp($value['issueEndDay'])
        );
        $result = $this->reservationRepository->checkPeriodForArticle($this->article, $period);
        if($result->count() > 0){
            $valid = false;
            $this->addError('Es liegt bereits eine Reservierung in dem Zeitraum vor.',
                1416316079);
        }
        return $valid;

    }



    public function getErrors(){
        return $this->errors;
    }


    /**
     * @param $date
     * @return bool
     */
    private function checkDate($date){
        list($parsedDateYear, $parsedDateMonth, $parsedDateDay) = $this->parseDate($date);
        //$debug = $this->parseDate($date);

        return checkdate($parsedDateMonth, $parsedDateDay, $parsedDateYear);

    }

    /**
     * @param $date
     * @return bool
     * date > today
     */
    private function dayNotInPast($date){
        if($this->checkDate($date)){
            list($parsedDateYear, $parsedDateMonth, $parsedDateDay) = $this->parseDate($date);
            $unixDate = mktime(0,0,0, $parsedDateMonth,$parsedDateDay, $parsedDateYear);
            return $unixDate > time();
        }

    }

    /**
     * @param $start
     * @param $end
     * @return bool
     */
    private function startBeforeEnd($start, $end){
        list($parsedDateYear, $parsedDateMonth, $parsedDateDay) = $this->parseDate($start);
        $unixDateStart = mktime(0,0,0, $parsedDateMonth,$parsedDateDay, $parsedDateYear);

        list($parsedDateYear, $parsedDateMonth, $parsedDateDay) = $this->parseDate($end);
        $unixDateEnd = mktime(0,0,0, $parsedDateMonth,$parsedDateDay, $parsedDateYear);
        return $unixDateEnd >= $unixDateStart;
    }

    /**
     * @param $date
     * @return array
     */
    private function parseDate($date)
    {
        $parsedDate = strptime($date, $this->format);
        $parsedDateYear = $parsedDate['tm_year'] + 1900;
        $parsedDateMonth = $parsedDate['tm_mon'] + 1;
        $parsedDateDay = $parsedDate['tm_mday'];
        return array($parsedDateYear, $parsedDateMonth, $parsedDateDay);
    }


    private function toUnixTimestamp($date){
        $parsedDate = $this->parseDate($date);
        return mktime(0,0,0, $parsedDate[1], $parsedDate[2], $parsedDate[0]);
    }

}