<?php
namespace Bjr\BjrLend\Utility;

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
 **************************************************************
 */
/**
 * Utility class
 *
 *
 *
 * @author        Manfred Ursprung <manfred@manfred-ursprung.de>
 * @package       TYPO3
 * @subpackage    bjr_lend
 */

class UserSession implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var \Bjr\BjrLend\Utility\SessionStorage
	 * @inject
	*/
	public $sessionStorage;

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;


	public function __construct(){
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->sessionStorage = $this->objectManager->get('Bjr\\BjrLend\\Utility\\SessionStorage');
	}



	public function getBasket() {
		if ($this->sessionStorage->has('Basket')) {
			return $this->sessionStorage->getObject('Basket');
		}
		else {
			//return $this->objectManager->create('Basket');
			//return array('basket', 'basketContainer');
			return false;
		}
	}



	public function saveBasket(array $basket, $key = 'Basket') {
		$this->sessionStorage->storeObject($basket, $key);
	}

	public function set($key, array $basket) {
		$this->sessionStorage->set($key, $basket);
	}

    public function setKey($key, $value) {
        $this->sessionStorage->set($key, $value);
    }

    public function get($key){
        if ($this->sessionStorage->has($key)) {
            return $this->sessionStorage->get($key);
        }
        else {
            return false;
        }
    }

    public function getKey($key, $value) {
        $this->get($key, $value);
    }


	/**
	 * Basket löschen
	 */
	public function removeBasket(){
		if ($this->sessionStorage->has('Basket')) {
			return $this->sessionStorage->clean('Basket');
		}
	}
}