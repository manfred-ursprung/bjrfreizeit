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
 * Test case for class \MUM\BjrFreizeit\Domain\Model\Leisure.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Manfred Ursprung <manfred@manfred-ursprung.de>
 */
class LeisureTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \MUM\BjrFreizeit\Domain\Model\Leisure
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \MUM\BjrFreizeit\Domain\Model\Leisure();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle()
	{
		$this->subject->setTitle('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'title',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getShortDescriptionReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getShortDescription()
		);
	}

	/**
	 * @test
	 */
	public function setShortDescriptionForStringSetsShortDescription()
	{
		$this->subject->setShortDescription('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'shortDescription',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getDescription()
		);
	}

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription()
	{
		$this->subject->setDescription('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'description',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getPriceReturnsInitialValueForFloat()
	{
		$this->assertSame(
			0.0,
			$this->subject->getPrice()
		);
	}

	/**
	 * @test
	 */
	public function setPriceForFloatSetsPrice()
	{
		$this->subject->setPrice(3.14159265);

		$this->assertAttributeEquals(
			3.14159265,
			'price',
			$this->subject,
			'',
			0.000000001
		);
	}

	/**
	 * @test
	 */
	public function getServiceSpecificationReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getServiceSpecification()
		);
	}

	/**
	 * @test
	 */
	public function setServiceSpecificationForStringSetsServiceSpecification()
	{
		$this->subject->setServiceSpecification('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'serviceSpecification',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getMinimumParticipantsReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setMinimumParticipantsForIntSetsMinimumParticipants()
	{	}

	/**
	 * @test
	 */
	public function getPartnerReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getPartner()
		);
	}

	/**
	 * @test
	 */
	public function setPartnerForStringSetsPartner()
	{
		$this->subject->setPartner('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'partner',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getCooperationReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getCooperation()
		);
	}

	/**
	 * @test
	 */
	public function setCooperationForStringSetsCooperation()
	{
		$this->subject->setCooperation('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'cooperation',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getLocationReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getLocation()
		);
	}

	/**
	 * @test
	 */
	public function setLocationForStringSetsLocation()
	{
		$this->subject->setLocation('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'location',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getLeaderReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getLeader()
		);
	}

	/**
	 * @test
	 */
	public function setLeaderForStringSetsLeader()
	{
		$this->subject->setLeader('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'leader',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getReferentReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getReferent()
		);
	}

	/**
	 * @test
	 */
	public function setReferentForStringSetsReferent()
	{
		$this->subject->setReferent('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'referent',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getImageReturnsInitialValueForFileReference()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getImage()
		);
	}

	/**
	 * @test
	 */
	public function setImageForFileReferenceSetsImage()
	{
		$fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$this->subject->setImage($fileReferenceFixture);

		$this->assertAttributeEquals(
			$fileReferenceFixture,
			'image',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getFileReturnsInitialValueForFileReference()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getFile()
		);
	}

	/**
	 * @test
	 */
	public function setFileForFileReferenceSetsFile()
	{
		$fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$this->subject->setFile($fileReferenceFixture);

		$this->assertAttributeEquals(
			$fileReferenceFixture,
			'file',
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
	public function getCountryReturnsInitialValueForCountry()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getCountry()
		);
	}

	/**
	 * @test
	 */
	public function setCountryForCountrySetsCountry()
	{
		$countryFixture = new \MUM\BjrFreizeit\Domain\Model\Country();
		$this->subject->setCountry($countryFixture);

		$this->assertAttributeEquals(
			$countryFixture,
			'country',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTargetGroupReturnsInitialValueForTargetGroup()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getTargetGroup()
		);
	}

	/**
	 * @test
	 */
	public function setTargetGroupForObjectStorageContainingTargetGroupSetsTargetGroup()
	{
		$targetGroup = new \MUM\BjrFreizeit\Domain\Model\TargetGroup();
		$objectStorageHoldingExactlyOneTargetGroup = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneTargetGroup->attach($targetGroup);
		$this->subject->setTargetGroup($objectStorageHoldingExactlyOneTargetGroup);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneTargetGroup,
			'targetGroup',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addTargetGroupToObjectStorageHoldingTargetGroup()
	{
		$targetGroup = new \MUM\BjrFreizeit\Domain\Model\TargetGroup();
		$targetGroupObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$targetGroupObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($targetGroup));
		$this->inject($this->subject, 'targetGroup', $targetGroupObjectStorageMock);

		$this->subject->addTargetGroup($targetGroup);
	}

	/**
	 * @test
	 */
	public function removeTargetGroupFromObjectStorageHoldingTargetGroup()
	{
		$targetGroup = new \MUM\BjrFreizeit\Domain\Model\TargetGroup();
		$targetGroupObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$targetGroupObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($targetGroup));
		$this->inject($this->subject, 'targetGroup', $targetGroupObjectStorageMock);

		$this->subject->removeTargetGroup($targetGroup);

	}

	/**
	 * @test
	 */
	public function getLeisurePeriodReturnsInitialValueForLeisurePeriod()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getLeisurePeriod()
		);
	}

	/**
	 * @test
	 */
	public function setLeisurePeriodForObjectStorageContainingLeisurePeriodSetsLeisurePeriod()
	{
		$leisurePeriod = new \MUM\BjrFreizeit\Domain\Model\LeisurePeriod();
		$objectStorageHoldingExactlyOneLeisurePeriod = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneLeisurePeriod->attach($leisurePeriod);
		$this->subject->setLeisurePeriod($objectStorageHoldingExactlyOneLeisurePeriod);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneLeisurePeriod,
			'leisurePeriod',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addLeisurePeriodToObjectStorageHoldingLeisurePeriod()
	{
		$leisurePeriod = new \MUM\BjrFreizeit\Domain\Model\LeisurePeriod();
		$leisurePeriodObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$leisurePeriodObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($leisurePeriod));
		$this->inject($this->subject, 'leisurePeriod', $leisurePeriodObjectStorageMock);

		$this->subject->addLeisurePeriod($leisurePeriod);
	}

	/**
	 * @test
	 */
	public function removeLeisurePeriodFromObjectStorageHoldingLeisurePeriod()
	{
		$leisurePeriod = new \MUM\BjrFreizeit\Domain\Model\LeisurePeriod();
		$leisurePeriodObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$leisurePeriodObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($leisurePeriod));
		$this->inject($this->subject, 'leisurePeriod', $leisurePeriodObjectStorageMock);

		$this->subject->removeLeisurePeriod($leisurePeriod);

	}

	/**
	 * @test
	 */
	public function getOrganizationReturnsInitialValueForOrganization()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getOrganization()
		);
	}

	/**
	 * @test
	 */
	public function setOrganizationForOrganizationSetsOrganization()
	{
		$organizationFixture = new \MUM\BjrFreizeit\Domain\Model\Organization();
		$this->subject->setOrganization($organizationFixture);

		$this->assertAttributeEquals(
			$organizationFixture,
			'organization',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getTagsReturnsInitialValueForTags()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getTags()
		);
	}

	/**
	 * @test
	 */
	public function setTagsForObjectStorageContainingTagsSetsTags()
	{
		$tag = new \MUM\BjrFreizeit\Domain\Model\Tags();
		$objectStorageHoldingExactlyOneTags = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneTags->attach($tag);
		$this->subject->setTags($objectStorageHoldingExactlyOneTags);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneTags,
			'tags',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addTagToObjectStorageHoldingTags()
	{
		$tag = new \MUM\BjrFreizeit\Domain\Model\Tags();
		$tagsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$tagsObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($tag));
		$this->inject($this->subject, 'tags', $tagsObjectStorageMock);

		$this->subject->addTag($tag);
	}

	/**
	 * @test
	 */
	public function removeTagFromObjectStorageHoldingTags()
	{
		$tag = new \MUM\BjrFreizeit\Domain\Model\Tags();
		$tagsObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$tagsObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($tag));
		$this->inject($this->subject, 'tags', $tagsObjectStorageMock);

		$this->subject->removeTag($tag);

	}

	/**
	 * @test
	 */
	public function getHolidayReturnsInitialValueForHoliday()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getHoliday()
		);
	}

	/**
	 * @test
	 */
	public function setHolidayForObjectStorageContainingHolidaySetsHoliday()
	{
		$holiday = new \MUM\BjrFreizeit\Domain\Model\Holiday();
		$objectStorageHoldingExactlyOneHoliday = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneHoliday->attach($holiday);
		$this->subject->setHoliday($objectStorageHoldingExactlyOneHoliday);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneHoliday,
			'holiday',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addHolidayToObjectStorageHoldingHoliday()
	{
		$holiday = new \MUM\BjrFreizeit\Domain\Model\Holiday();
		$holidayObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$holidayObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($holiday));
		$this->inject($this->subject, 'holiday', $holidayObjectStorageMock);

		$this->subject->addHoliday($holiday);
	}

	/**
	 * @test
	 */
	public function removeHolidayFromObjectStorageHoldingHoliday()
	{
		$holiday = new \MUM\BjrFreizeit\Domain\Model\Holiday();
		$holidayObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$holidayObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($holiday));
		$this->inject($this->subject, 'holiday', $holidayObjectStorageMock);

		$this->subject->removeHoliday($holiday);

	}
}
