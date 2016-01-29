<?php

namespace MUM\BjrFreizeit\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Manfred Ursprung <manfred@manfred-ursprung.de>, Webapplikationen Ursprung
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
 * Test case for class \MUM\BjrFreizeit\Domain\Model\Organization.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Manfred Ursprung <manfred@manfred-ursprung.de>
 */
class OrganizationTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \MUM\BjrFreizeit\Domain\Model\Organization
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \MUM\BjrFreizeit\Domain\Model\Organization();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getName()
		);
	}

	/**
	 * @test
	 */
	public function setNameForStringSetsName()
	{
		$this->subject->setName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'name',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getUrlReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getUrl()
		);
	}

	/**
	 * @test
	 */
	public function setUrlForStringSetsUrl()
	{
		$this->subject->setUrl('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'url',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAddressReturnsInitialValueForAddress()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getAddress()
		);
	}

	/**
	 * @test
	 */
	public function setAddressForAddressSetsAddress()
	{
		$addressFixture = new \MUM\BjrFreizeit\Domain\Model\Address();
		$this->subject->setAddress($addressFixture);

		$this->assertAttributeEquals(
			$addressFixture,
			'address',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getContactReturnsInitialValueForContact()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getContact()
		);
	}

	/**
	 * @test
	 */
	public function setContactForContactSetsContact()
	{
		$contactFixture = new \MUM\BjrFreizeit\Domain\Model\Contact();
		$this->subject->setContact($contactFixture);

		$this->assertAttributeEquals(
			$contactFixture,
			'contact',
			$this->subject
		);
	}
}
