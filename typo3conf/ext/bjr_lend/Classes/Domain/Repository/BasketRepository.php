<?php
namespace Bjr\BjrLend\Domain\Repository;

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
 * Basket  not persistent only transient, it is stored in session
 *
 * @package bjr_lend
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class BasketRepository implements  \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var \Bjr\BjrLend\Utility\UserSession
	 */
	protected $userSession;

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;


	public function __construct() {
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->userSession = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Utility\\UserSession');
	}

	/**
	 * @return array|bool|object|\Bjr\BjrLend\Domain\Model\Basket
	 */
	public function findAll(){
		$sessionData = $this->userSession->getBasket();
		if($sessionData === FALSE){
			$basket = $this->objectManager->get('Bjr\\BjrLend\\Domain\\Model\\Basket');
		}else{
			//aus Array muss wieder ein Basket Objekt werden
			$basket = \Bjr\BjrLend\Domain\Model\Basket::sessionDataToBasket($sessionData);
		}
		return $basket;
	}

	/**
	 * @return array|\Bjr\BjrLend\Domain\Model\Basket|bool|object
	 */
	public function getBasket(){
		return $this->findAll();
	}

	/**
	 * Basket aus Session entfernen
	 */
	public function removeBasket(){
		$this->userSession->removeBasket();
	}

}
?>