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
 *
 *
 * @package bjr_lend
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
use \TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

class Order extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * customerName
	 *
	 * @var \string
	 */
	protected $customerName;

	/**
	 * customerPhone
	 *
	 * @var \string
	 */
	protected $customerPhone;

	/**
	 * customerEmail
	 *
	 * @var \string
	 */
	protected $customerEmail;

	/**
	 * Bestellpositionen
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\OrderPosition>
	 */
	protected $positions;

	/**
	 * __construct
	 *
	 * @return Order
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
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
		$this->positions = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the customerName
	 *
	 * @return \string $customerName
	 */
	public function getCustomerName() {
		return $this->customerName;
	}

	/**
	 * Sets the customerName
	 *
	 * @param \string $customerName
	 * @return void
	 */
	public function setCustomerName($customerName) {
		$this->customerName = $customerName;
	}

	/**
	 * Returns the customerPhone
	 *
	 * @return \string $customerPhone
	 */
	public function getCustomerPhone() {
		return $this->customerPhone;
	}

	/**
	 * Sets the customerPhone
	 *
	 * @param \string $customerPhone
	 * @return void
	 */
	public function setCustomerPhone($customerPhone) {
		$this->customerPhone = $customerPhone;
	}

	/**
	 * Returns the customerEmail
	 *
	 * @return \string $customerEmail
	 */
	public function getCustomerEmail() {
		return $this->customerEmail;
	}

	/**
	 * Sets the customerEmail
	 *
	 * @param \string $customerEmail
	 * @return void
	 */
	public function setCustomerEmail($customerEmail) {
		$this->customerEmail = $customerEmail;
	}

	/**
	 * Adds a OrderPosition
	 *
	 * @param \Bjr\BjrLend\Domain\Model\OrderPosition $position
	 * @return void
	 */
	public function addPosition(\Bjr\BjrLend\Domain\Model\OrderPosition $position) {
		$this->positions->attach($position);
	}

	/**
	 * Removes a OrderPosition
	 *
	 * @param \Bjr\BjrLend\Domain\Model\OrderPosition $positionToRemove The OrderPosition to be removed
	 * @return void
	 */
	public function removePosition(\Bjr\BjrLend\Domain\Model\OrderPosition $positionToRemove) {
		$this->positions->detach($positionToRemove);
	}

	/**
	 * Returns the positions
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\OrderPosition> $positions
	 */
	public function getPositions() {
		return $this->positions;
	}

	/**
	 * Sets the positions
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\OrderPosition> $positions
	 * @return void
	 */
	public function setPositions(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $positions) {
		$this->positions = $positions;
	}

	/**
	 * @param array $customer
	 */
	public function setCustomerData(array $customer){
		$this->setCustomerName($customer['name']);
		$this->setCustomerEmail($customer['email']);
		$this->setCustomerPhone($customer['phone']);
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $items
	 */
	public function setPositionsFromBasketItem(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $items){
		/* @var $artikelRepository \Bjr\BjrLend\Domain\Repository\ArticleRepsitory */
        /** @var  $objectManager  \TYPO3\CMS\Extbase\Object\ObjectManager */
        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $artikelRepository = $objectManager->get('Bjr\\BjrLend\\Domain\\Repository\\ArticleRepository');

		foreach($items as $item){
			/* @var $item \Bjr\BjrLend\Domain\Model\BasketItem
			 * @var $position \Bjr\BjrLend\Domain\Model\OrderPosition
			 */
			//echo 'Artikel UID befor :'. $item->getArticleUid() .'<br />';
			$article = $artikelRepository->findByUid($item->getArticleUid());
			//echo 'Artikel UID after :'. $item->getArticleUid() .'<br />';

			if($article){
				$position = $objectManager->get('Bjr\\BjrLend\\Domain\\Model\\OrderPosition');
				$position->initializeFrom($article);

				$position->setIssueStart($item->getIssueStartDayAsTimestamp());
				$position->setIssueEnd($item->getIssueEndDayAsTimestamp());

				$this->addPosition($position);
			}
			//exit();
		}
	}


}
?>