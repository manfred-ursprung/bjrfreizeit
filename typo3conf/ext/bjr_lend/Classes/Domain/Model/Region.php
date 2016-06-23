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
class Region extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Name
	 *
	 * @var \string
     * @validate StringLength(minimum=3, maximum=50)
	 */
	protected $name;


	/**
	 * Organisationen
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\Organization>
	 */
	protected $organizations;

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
		$this->organizations = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Returns the name
	 *
	 * @return \string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the Name
	 *
	 * @param \string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * Adds a Organization
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Organization $organization
	 * @return void
	 */
	public function addOrganization(\Bjr\BjrLend\Domain\Model\Organization $organization) {
		$this->organizations->attach($organization);
	}

	/**
	 * Removes a Organization
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Organization $positionToRemove The Organization to be removed
	 * @return void
	 */
	public function removeOrganization(\Bjr\BjrLend\Domain\Model\Organization $organizationToRemove) {
		$this->organizations->detach($organizationToRemove);
	}

	/**
	 * Returns the organizations
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\Organizations> $organizations
	 */
	public function getOrganizations() {
		return $this->organizations;
	}

	/**
	 * Sets the organizations
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\Organizations> $organizations
	 * @return void
	 */
	public function setOrganizations(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $organizations) {
		$this->organizations = $organizations;
	}

}
?>