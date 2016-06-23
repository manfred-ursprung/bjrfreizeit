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
 * Test case for class \Bjr\BjrLend\Domain\Model\OrderPosition.
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
class OrderPositionTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \Bjr\BjrLend\Domain\Model\OrderPosition
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \Bjr\BjrLend\Domain\Model\OrderPosition();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getArticleTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setArticleTitleForStringSetsArticleTitle() { 
		$this->fixture->setArticleTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getArticleTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getArticleFeeReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setArticleFeeForStringSetsArticleFee() { 
		$this->fixture->setArticleFee('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getArticleFee()
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
	public function getOrganizationNameReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setOrganizationNameForStringSetsOrganizationName() { 
		$this->fixture->setOrganizationName('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getOrganizationName()
		);
	}
	
	/**
	 * @test
	 */
	public function getOrganizationStreetReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setOrganizationStreetForStringSetsOrganizationStreet() { 
		$this->fixture->setOrganizationStreet('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getOrganizationStreet()
		);
	}
	
	/**
	 * @test
	 */
	public function getOrganizationZipReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setOrganizationZipForStringSetsOrganizationZip() { 
		$this->fixture->setOrganizationZip('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getOrganizationZip()
		);
	}
	
	/**
	 * @test
	 */
	public function getOrganizationCityReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setOrganizationCityForStringSetsOrganizationCity() { 
		$this->fixture->setOrganizationCity('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getOrganizationCity()
		);
	}
	
	/**
	 * @test
	 */
	public function getOrganizationPhoneReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setOrganizationPhoneForStringSetsOrganizationPhone() { 
		$this->fixture->setOrganizationPhone('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getOrganizationPhone()
		);
	}
	
	/**
	 * @test
	 */
	public function getOrganizationEmailReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setOrganizationEmailForStringSetsOrganizationEmail() { 
		$this->fixture->setOrganizationEmail('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getOrganizationEmail()
		);
	}
	
	/**
	 * @test
	 */
	public function getArticleReturnsInitialValueFor() { }

	/**
	 * @test
	 */
	public function setArticleForSetsArticle() { }
	
}
?>