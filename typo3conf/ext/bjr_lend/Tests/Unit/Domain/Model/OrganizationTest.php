<?php

namespace Bjr\BjrLend\Tests;
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
 * Test case for class \Bjr\BjrLend\Domain\Model\Organization.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Ausleih Datenbank
 *
 * @author Manfred Ursprung <manfred@manfred-ursprung.de>
 */
class OrganizationTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \Bjr\BjrLend\Domain\Model\Organization
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \Bjr\BjrLend\Domain\Model\Organization();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setNameForStringSetsName() { 
		$this->fixture->setName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getName()
		);
	}
	
	/**
	 * @test
	 */
	public function getLendConditionsReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLendConditionsForStringSetsLendConditions() { 
		$this->fixture->setLendConditions('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLendConditions()
		);
	}
	
	/**
	 * @test
	 */
	public function getOpeningTimesReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setOpeningTimesForStringSetsOpeningTimes() { 
		$this->fixture->setOpeningTimes('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getOpeningTimes()
		);
	}
	
	/**
	 * @test
	 */
	public function getAddressReturnsInitialValueForAddress() { }

	/**
	 * @test
	 */
	public function setAddressForAddressSetsAddress() { }
	
	/**
	 * @test
	 */
	public function getContactReturnsInitialValueForContact() { }

	/**
	 * @test
	 */
	public function setContactForContactSetsContact() { }
	
}
?>