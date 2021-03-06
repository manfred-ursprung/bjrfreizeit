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
 * Test case for class \Bjr\BjrLend\Domain\Model\Order.
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
class OrderTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \Bjr\BjrLend\Domain\Model\Order
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \Bjr\BjrLend\Domain\Model\Order();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getCustomerNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setCustomerNameForStringSetsCustomerName() { 
		$this->fixture->setCustomerName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getCustomerName()
		);
	}
	
	/**
	 * @test
	 */
	public function getCustomerPhoneReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setCustomerPhoneForStringSetsCustomerPhone() { 
		$this->fixture->setCustomerPhone('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getCustomerPhone()
		);
	}
	
	/**
	 * @test
	 */
	public function getCustomerEmailReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setCustomerEmailForStringSetsCustomerEmail() { 
		$this->fixture->setCustomerEmail('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getCustomerEmail()
		);
	}
	
	/**
	 * @test
	 */
	public function getPositionsReturnsInitialValueForOrderPosition() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getPositions()
		);
	}

	/**
	 * @test
	 */
	public function setPositionsForObjectStorageContainingOrderPositionSetsPositions() { 
		$position = new \Bjr\BjrLend\Domain\Model\OrderPosition();
		$objectStorageHoldingExactlyOnePositions = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOnePositions->attach($position);
		$this->fixture->setPositions($objectStorageHoldingExactlyOnePositions);

		$this->assertSame(
			$objectStorageHoldingExactlyOnePositions,
			$this->fixture->getPositions()
		);
	}
	
	/**
	 * @test
	 */
	public function addPositionToObjectStorageHoldingPositions() {
		$position = new \Bjr\BjrLend\Domain\Model\OrderPosition();
		$objectStorageHoldingExactlyOnePosition = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOnePosition->attach($position);
		$this->fixture->addPosition($position);

		$this->assertEquals(
			$objectStorageHoldingExactlyOnePosition,
			$this->fixture->getPositions()
		);
	}

	/**
	 * @test
	 */
	public function removePositionFromObjectStorageHoldingPositions() {
		$position = new \Bjr\BjrLend\Domain\Model\OrderPosition();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($position);
		$localObjectStorage->detach($position);
		$this->fixture->addPosition($position);
		$this->fixture->removePosition($position);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getPositions()
		);
	}
	
}
?>