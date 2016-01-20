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



class SessionStorage implements \TYPO3\CMS\Core\SingletonInterface {

	const SESSIONNAMESPACE = 'bjrlend';

	/**
	 * Returns the object stored in the user´s session
	 * @param string $key
	 * @return Object the stored object
	 */
	public function get($key) {
		$sessionData = $this->getFrontendUser()->getKey('ses', self::SESSIONNAMESPACE.$key);
		if ($sessionData == '') {
			throw new LogicException('No value for key found in session '.$key);
		}
		return $sessionData;
	}

	/**
	 * checks if object is stored in the user´s session
	 * @param string $key
	 * @return boolean
	 */
	public function has($key) {
		$sessionData = $this->getFrontendUser()->getKey('ses', self::SESSIONNAMESPACE.$key);
		if ($sessionData == '') {
			return false;
		}
		return true;
	}

	/**
	 * Writes something to storage
	 * @param string $key
	 * @param string $value
	 * @return	void
	 */
	public function set($key,$value) {
		$this->getFrontendUser()->setKey('ses', self::SESSIONNAMESPACE.$key, $value);
		$this->getFrontendUser()->storeSessionData();
	}

	/**
	 * Writes a object to the session if the key is empty it used the classname
	 * @param object $object
	 * @param string $key
	 * @return	void
	 */
	public function storeObject($object,$key=null) {
		if (is_null($key)) {
			$key = get_class($object);
		}
		return $this->set($key,serialize($object));
	}

	/**
	 * Writes something to storage
	 * @param string $key
	 * @return	object
	 */
	public function getObject($key) {
		return unserialize($this->get($key));
		return $this->get($key);
	}

	/**
	 * Cleans up the session: removes the stored object from the PHP session
	 * @param string $key
	 * @return	void
	 */
	public function clean($key) {
		$this->getFrontendUser()->setKey('ses', self::SESSIONNAMESPACE.$key, NULL);
		$this->getFrontendUser()->storeSessionData();
	}

	/**
	 * Gets a frontend user which is taken from the global registry or as fallback from TSFE->fe_user.
	 *
	 * @return	\TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication   The current extended frontend user object
	 * @throws	LogicException
	 */
	public function getFrontendUser() {
		if ($GLOBALS ['TSFE']->fe_user) {
			return $GLOBALS ['TSFE']->fe_user;
		}
		throw new LogicException ( 'No Frontenduser found in session!' );
	}

	/**
	 *
	 * @return \TYPO3\CMS\Frontend\Authentication\FrontendUserAuthentication
	 */
	public function getUser() {
		return $this->getFeUser();
	}

	/**
	 *
	 * @param string $type
	 */
	public function setUserDataChanged($type = 'ses') {
		switch ($type) {
			case 'ses':
				$this->getFrontendUser()->sesData_change = 1;
				break;
			case 'user':
				$this->getFrontendUser()->userData_change = 1;
				break;
			default:
				$this->getFrontendUser()->sesData_change = 1;
				break;
		}
	}


}