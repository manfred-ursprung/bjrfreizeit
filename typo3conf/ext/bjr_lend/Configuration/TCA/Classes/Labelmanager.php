<?php
namespace Bjr\BjrLend\Configuration\TCA\Classes;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Manfred Ursprung <manfred@manfred-ursprung.de>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * @author        Manfred Ursprung <manfred@manfred-ursprung.de>
 * @package       TYPO3
 * @subpackage    bjr_lend
 * @description		Labelmanager , creates the label for entity in the backend
 */



class Labelmanager{

	/**
	 * @var \Bjr\BjrLend\Domain\Repository\LendDatesRepository
	 */
	protected $lendDatesRepository;

	/**
	 * @var \Bjr\BjrLend\Domain\Repository\OrderPositionRepository
	 */
	protected $orderPositionRepository;

	/**
	 * @var \Bjr\BjrLend\Domain\Repository\ReservationRepository
	 */
	protected $reservationRepository;


	public function __construct(){
		$this->lendDatesRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Repository\\LendDatesRepository');
		$this->orderPositionRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Repository\\OrderPositionRepository');
		$this->reservationRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Repository\\ReservationRepository');
	}
	/**
	 * @param $params array
	 */
	public function labelForArticle(&$params){
		$params['title'] =  $params['row']['title'];
	}

	/**
	 * @param $params array
	 */
	public function labelForAddress(&$params){
		$row = $params['row'];
		$params['title'] =   $row['street']. ', ' . $row['city'];
	}

	/**
	 * @param $params array
	 */
	public function labelForOrder(&$params){
		$row = $params['row'];
		$params['title'] =  $row['customer_name'];
		if(strlen($params['title']) == 0){
			$params['title'] = 'kein Kunde angegeben';
		}
	}

	/**
	 * @param $params array
	 */
	public function labelForOrderposition(&$params){
		$row = $params['row'];
		/* @var $orderPos \Bjr\BjrLend\Domain\Model\OrderPosition */
		$orderPos = $this->orderPositionRepository->findByUid($row['uid']);
		if($orderPos){
			$params['title'] =  $orderPos->getArticleTitle() .', ' . $orderPos->getOrganizationName();
			if(strlen($params['title']) == 2){
				$params['title'] = 'kein Artikel vorhanden';
			}
		}else{
			$params['title'] = 'kein Artikel vorhanden';
		}
	}

	/**
	 * @param $params array
	 */
	public function labelForLendDates(&$params){
		$row = $params['row'];
		/* in der Row ist die UId, pid, date_from und die standardfelder starttime, endtime, t3ver, ... */
		/* @var $lendDates \Bjr\BjrLend\Domain\Model\LendDates */
		$lendDates = $this->lendDatesRepository->findByUid($row['uid']);

		$params['title'] =  date('d.m.y', $lendDates->getDateFrom() ).' - ' . date('d.m.y', $lendDates->getDateTo());
		if(strlen($params['title']) == 3){
			$params['title'] = 'kein Datum vorhanden';
		}
	}

	/**
	 * @param $params array
	 */
	public function labelForReservation(&$params){
		$row = $params['row'];
		/* in der Row ist die UId, pid, date_from und die standardfelder starttime, endtime, t3ver, ... */
		/* @var $reservation \Bjr\BjrLend\Domain\Model\Reservation */
		$reservation = $this->reservationRepository->findByUid($row['uid']);

		$params['title'] =  date('d.m.y', $reservation->getIssueStart() ).' - ' . date('d.m.y', $reservation->getIssueEnd());
		if(strlen($params['title']) == 3){
			$params['title'] = 'kein Datum vorhanden';
		}
	}

}