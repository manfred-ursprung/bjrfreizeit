<?php
namespace Bjr\BjrLend\Domain\Model;

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
 *	Basket  not persistent only transient, it is stored in session
 *
 * @package bjr_lend
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
use \TYPO3\CMS\Core\Utility\GeneralUtility;

//use TYPO3\CMS\Extbase\Object\ObjectManager;
use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;



class Basket extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * BasketItems
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\BasketItem>
	 */
	protected $items;

	/**
	 * @var \Bjr\BjrLend\Utility\UserSession
	 */
	protected $userSession;


	/**
	 * initializeObject
	 *
	 * @return Basket
	 */
	public function initializeObject() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
		$this->userSession = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Utility\\UserSession');
	}

	/**
	 * Initializes all ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->items = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}


	public function storeInSession(){
		$this->userSession->saveBasket($this->asSessionData(), 'Basket');
	}
	/**
	 * Adds a BasketItem
	 *
	 * @param \Bjr\BjrLend\Domain\Model\BasketItem $item
	 * @return void
	 */
	public function addItem(\Bjr\BjrLend\Domain\Model\BasketItem $item) {
        $number = $this->getNumber();
        $item->setPosNo($number + 1);
		$this->items->attach($item);
	}

	/**
	 * @param Article $article
	 */
	public function addArticle(\Bjr\BjrLend\Domain\Model\Article $article){
		$item = \Bjr\BjrLend\Domain\Model\BasketItem::getItemFromArticle($article);
		$this->addItem($item);
	}


	/**
	 * Removes a BasketItem
	 *
	 * @param \Bjr\BjrLend\Domain\Model\BasketItem $itemToRemove The Basket item to be removed
	 * @return void
	 */
	public function removeItem(\Bjr\BjrLend\Domain\Model\BasketItem $itemToRemove) {
		$this->items->detach($itemToRemove);
	}


	/**
	 * @param Article $article
	 */
	public function removeArticle(\Bjr\BjrLend\Domain\Model\Article $article){
		foreach($this->items as $item){
			/* @var $item BasketItem */
			if($item->getArticleUid() == $article->getUid()){
				$this->removeItem($item);
			}
		}
	}

    /**
     * @param $posNo
     * entfernt Item mit Positionsnummer posNo
     */
    public function removePosNo($posNo){
        foreach($this->items as $item){
            /* @var $item BasketItem */
            if($item->getPosNo() == $posNo){
                $this->removeItem($item);
            }
        }
    }

	/**
	 * Returns the items basketItems
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\BasketItem> $items
	 */
	public function getItems() {
		return $this->items;
	}

	/**
	 * Sets the items
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\BasketItem> $items
	 * @return void
	 */
	public function setItems(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $items) {
		$this->items = $items;
	}

    /**
     * @return int
     * liefert Anzahl der Items
     */
    public function getNumber(){
        return $this->items->count();
    }


    public function isEmpty(){
        return $this->items->count() == 0;
    }


	/**
	 * @return array
	 */
	public function asSessionData(){
		$data = array();
		/* @var $item \Bjr\BjrLend\Domain\Model\BasketItem */
		foreach($this->items as $item){
			$_article = array(
					'uid' 		=> $item->getArticleUid(),
					'issueStart'=> $item->getIssueStartDay(),
					'issueEnd'	=> $item->getIssueEndDay()
			);
			$data[] = $_article;
		}
		return $data;
	}

	/**
	 * @param $sessionData
	 * @return \Bjr\BjrLend\Domain\Model\Basket
	 * called after sessionData for a basket are fetched
	 */
	public static function sessionDataToBasket($sessionData){
		/* @var \Bjr\BjrLend\Domain\Model\Basket */
		$basket = GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Model\\Basket');
		$basket->initializeObject();
		foreach($sessionData as $entry){

			$articleRepository = GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Repository\\ArticleRepository');
			$article = $articleRepository->findByUid($entry['uid']);
			/* @var $basketItem \Bjr\BjrLend\Domain\Model\BasketItem */
			$basketItem = \Bjr\BjrLend\Domain\Model\BasketItem::getItemFromArticle($article);
			$issueDuration = array(
				$entry['issueStart'],
				$entry['issueEnd'],
			);
			$basketItem->setDurationOfIssue($issueDuration);
			$basket->addItem($basketItem);

		}
		return $basket;
	}

	/**
	 * @param $customer
	 * @return object \Bjr\BjrLend\Domain\Model\Order
	 * create an order, create lend-dates for every basketItem and stores lend-date at article
	 * create a reservation for every basketItem and stores reservation at article
	 *
	 * make all changes persists.
	 * I dont remove Basket, do it after calling, if you wish!
	 */
	public function makeOrder($customer){
		/* @var $orderRepository \Bjr\BjrLend\Domain\Repository\OrderRepository */
        /** @var  $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$orderRepository =  $objectManager->get('Bjr\\BjrLend\\Domain\\Repository\\OrderRepository');
        //$orderRepository = GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Repository\\OrderRepository');
		/* @var $order \Bjr\BjrLend\Domain\Model\Order */
		$order = $orderRepository->createModel();
		$order->setCustomerData($customer);
		$order->setPositionsFromBasketItem($this->getItems());

		//Order persistent machen
		$orderRepository->add($order);
		//oder soll der Warenkorb das ganze machen??

		//Lenddates erzeugen
		$lendDateRepository = $objectManager->get('Bjr\\BjrLend\\Domain\\Repository\\LendDatesRepository');
		$reservationRepository = $objectManager->get('Bjr\\BjrLend\\Domain\\Repository\\ReservationRepository');
		$articleRepository = $objectManager->get('Bjr\\BjrLend\\Domain\\Repository\\ArticleRepository');

		/* @var $basketItem \Bjr\BjrLend\Domain\Model\BasketItem */
		foreach($this->items as $basketItem){
			/* @var $article \Bjr\BjrLend\Domain\Model\Article */
			$article = $articleRepository->findByUid($basketItem->getArticleUid());
			/* @var $lendDate \Bjr\BjrLend\Domain\Model\LendDates */
		/*	$lendDate = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Model\\LendDates');
			$lendDate->setDateFrom($basketItem->getIssueStartDayAsTimestamp());
			$lendDate->setDateTo($basketItem->getIssueEndDayAsTimestamp());
			$article->addLendDate($lendDate);
			$lendDateRepository->add($lendDate);
		*/
			/* @var $reservation \Bjr\BjrLend\Domain\Model\Reservation */
			$reservation = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Model\\Reservation');
			$reservation->setPid($article->getPid());	//im gleichen Ordner wie den Artikel speichern
			$reservation->setIssueStart($basketItem->getIssueStartDayAsTimestamp());
			$reservation->setIssueEnd($basketItem->getIssueEndDayAsTimestamp());
			$reservation->setCustomerName($order->getCustomerName());
			$reservation->setCustomerEmail($order->getCustomerEmail());
			$reservation->setCustomerPhone($order->getCustomerPhone());
			$reservation->setArticle($article);
			$article->addReservation($reservation);
			$reservationRepository->add($reservation);
		}

		$persistenceManager = $objectManager->get('TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager');
		$persistenceManager->persistAll();

		return $order;
	}
}
?>