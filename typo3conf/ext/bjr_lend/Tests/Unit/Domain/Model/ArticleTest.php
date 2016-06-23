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
 * Test case for class \Bjr\BjrLend\Domain\Model\Article.
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
class ArticleTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \Bjr\BjrLend\Domain\Model\Article
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \Bjr\BjrLend\Domain\Model\Article();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() { 
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}
	
	/**
	 * @test
	 */
	public function getShortDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setShortDescriptionForStringSetsShortDescription() { 
		$this->fixture->setShortDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getShortDescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() { 
		$this->fixture->setDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDescription()
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
	public function getFeeReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setFeeForStringSetsFee() { 
		$this->fixture->setFee('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getFee()
		);
	}
	
	/**
	 * @test
	 */
	public function getBookingOnlineReturnsInitialValueForOolean() { }

	/**
	 * @test
	 */
	public function setBookingOnlineForOoleanSetsBookingOnline() { }
	
	/**
	 * @test
	 */
	public function getBookingPhoneReturnsInitialValueForOolean() { }

	/**
	 * @test
	 */
	public function setBookingPhoneForOoleanSetsBookingPhone() { }
	
	/**
	 * @test
	 */
	public function getPhoneReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setPhoneForStringSetsPhone() { 
		$this->fixture->setPhone('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getPhone()
		);
	}
	
	/**
	 * @test
	 */
	public function getByEmailReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setByEmailForStringSetsByEmail() { 
		$this->fixture->setByEmail('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getByEmail()
		);
	}
	
	/**
	 * @test
	 */
	public function getEmailReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setEmailForStringSetsEmail() { 
		$this->fixture->setEmail('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getEmail()
		);
	}
	
	/**
	 * @test
	 */
	public function getImageReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setImageForStringSetsImage() { 
		$this->fixture->setImage('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getImage()
		);
	}
	
	/**
	 * @test
	 */
	public function getIsLendReturnsInitialValueForOolean() { }

	/**
	 * @test
	 */
	public function setIsLendForOoleanSetsIsLend() { }
	
	/**
	 * @test
	 */
	public function getShowCalendarReturnsInitialValueForOolean() { }

	/**
	 * @test
	 */
	public function setShowCalendarForOoleanSetsShowCalendar() { }
	
	/**
	 * @test
	 */
	public function getCategoryReturnsInitialValueForCategory() { }

	/**
	 * @test
	 */
	public function setCategoryForCategorySetsCategory() { }
	
}
?>