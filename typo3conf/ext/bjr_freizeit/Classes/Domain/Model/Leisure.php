<?php
namespace MUM\BjrFreizeit\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Manfred Ursprung <manfred@manfred-ursprung.de>, Webapplikationen Ursprung
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
 * Leisure
 */
class Leisure extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     */
    protected $title = '';
    
    /**
     * shortDescription
     *
     * @var string
     */
    protected $shortDescription = '';
    
    /**
     * description
     *
     * @var string
     */
    protected $description = '';
    
    /**
     * price
     *
     * @var float
     */
    protected $price = 0.0;
    
    /**
     * serviceSpecification
     *
     * @var string
     */
    protected $serviceSpecification = '';
    
    /**
     * minimumParticipants
     *
     * @var int
     */
    protected $minimumParticipants = 0;
    
    /**
     * partner
     *
     * @var string
     */
    protected $partner = '';
    
    /**
     * cooperation
     *
     * @var string
     */
    protected $cooperation = '';
    
    /**
     * location
     *
     * @var string
     */
    protected $location = '';
    
    /**
     * leader
     *
     * @var string
     */
    protected $leader = '';
    
    /**
     * referent
     *
     * @var string
     */
    protected $referent = '';
    
    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $image = null;
    
    /**
     * file
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $file = null;
    
    /**
     * country
     *
     * @var \MUM\BjrFreizeit\Domain\Model\Country
     */
    protected $country = null;
    
    /**
     * targetGroup
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MUM\BjrFreizeit\Domain\Model\TargetGroup>
     */
    protected $targetGroup = null;
    
    /**
     * leisurePeriod
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MUM\BjrFreizeit\Domain\Model\LeisurePeriod>
     */
    protected $leisurePeriod = null;
    
    /**
     * organization
     *
     * @var \MUM\BjrFreizeit\Domain\Model\Organization
     */
    protected $organization = null;
    
    /**
     * tags
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MUM\BjrFreizeit\Domain\Model\Tags>
     */
    protected $tags = null;
    
    /**
     * holiday
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MUM\BjrFreizeit\Domain\Model\Holiday>
     */
    protected $holiday = null;
    
    /**
     * url
     *
     * @var string
     */
    protected $url = '';
    
    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * Returns the shortDescription
     *
     * @return string $shortDescription
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }
    
    /**
     * Sets the shortDescription
     *
     * @param string $shortDescription
     * @return void
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }
    
    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * Returns the price
     *
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Sets the price
     *
     * @param float $price
     * @return void
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    
    /**
     * Returns the serviceSpecification
     *
     * @return string $serviceSpecification
     */
    public function getServiceSpecification()
    {
        return $this->serviceSpecification;
    }
    
    /**
     * Sets the serviceSpecification
     *
     * @param string $serviceSpecification
     * @return void
     */
    public function setServiceSpecification($serviceSpecification)
    {
        $this->serviceSpecification = $serviceSpecification;
    }
    
    /**
     * Returns the minimumParticipants
     *
     * @return int $minimumParticipants
     */
    public function getMinimumParticipants()
    {
        return $this->minimumParticipants;
    }
    
    /**
     * Sets the minimumParticipants
     *
     * @param int $minimumParticipants
     * @return void
     */
    public function setMinimumParticipants($minimumParticipants)
    {
        $this->minimumParticipants = $minimumParticipants;
    }
    
    /**
     * Returns the partner
     *
     * @return string $partner
     */
    public function getPartner()
    {
        return $this->partner;
    }
    
    /**
     * Sets the partner
     *
     * @param string $partner
     * @return void
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;
    }
    
    /**
     * Returns the cooperation
     *
     * @return string $cooperation
     */
    public function getCooperation()
    {
        return $this->cooperation;
    }
    
    /**
     * Sets the cooperation
     *
     * @param string $cooperation
     * @return void
     */
    public function setCooperation($cooperation)
    {
        $this->cooperation = $cooperation;
    }
    
    /**
     * Returns the location
     *
     * @return string $location
     */
    public function getLocation()
    {
        return $this->location;
    }
    
    /**
     * Sets the location
     *
     * @param string $location
     * @return void
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }
    
    /**
     * Returns the leader
     *
     * @return string $leader
     */
    public function getLeader()
    {
        return $this->leader;
    }
    
    /**
     * Sets the leader
     *
     * @param string $leader
     * @return void
     */
    public function setLeader($leader)
    {
        $this->leader = $leader;
    }
    
    /**
     * Returns the referent
     *
     * @return string $referent
     */
    public function getReferent()
    {
        return $this->referent;
    }
    
    /**
     * Sets the referent
     *
     * @param string $referent
     * @return void
     */
    public function setReferent($referent)
    {
        $this->referent = $referent;
    }
    
    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->image = $image;
    }
    
    /**
     * Returns the file
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Sets the file
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $file
     * @return void
     */
    public function setFile(\TYPO3\CMS\Extbase\Domain\Model\FileReference $file)
    {
        $this->file = $file;
    }
    
    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }
    
    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->targetGroup = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->leisurePeriod = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->tags = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->holiday = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Returns the country
     *
     * @return \MUM\BjrFreizeit\Domain\Model\Country $country
     */
    public function getCountry()
    {
        return $this->country;
    }
    
    /**
     * Sets the country
     *
     * @param \MUM\BjrFreizeit\Domain\Model\Country $country
     * @return void
     */
    public function setCountry(\MUM\BjrFreizeit\Domain\Model\Country $country)
    {
        $this->country = $country;
    }
    
    /**
     * Adds a TargetGroup
     *
     * @param \MUM\BjrFreizeit\Domain\Model\TargetGroup $targetGroup
     * @return void
     */
    public function addTargetGroup(\MUM\BjrFreizeit\Domain\Model\TargetGroup $targetGroup)
    {
        $this->targetGroup->attach($targetGroup);
    }
    
    /**
     * Removes a TargetGroup
     *
     * @param \MUM\BjrFreizeit\Domain\Model\TargetGroup $targetGroupToRemove The TargetGroup to be removed
     * @return void
     */
    public function removeTargetGroup(\MUM\BjrFreizeit\Domain\Model\TargetGroup $targetGroupToRemove)
    {
        $this->targetGroup->detach($targetGroupToRemove);
    }
    
    /**
     * Returns the targetGroup
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MUM\BjrFreizeit\Domain\Model\TargetGroup> $targetGroup
     */
    public function getTargetGroup()
    {
        return $this->targetGroup;
    }
    
    /**
     * Sets the targetGroup
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MUM\BjrFreizeit\Domain\Model\TargetGroup> $targetGroup
     * @return void
     */
    public function setTargetGroup(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $targetGroup)
    {
        $this->targetGroup = $targetGroup;
    }
    
    /**
     * Adds a LeisurePeriod
     *
     * @param \MUM\BjrFreizeit\Domain\Model\LeisurePeriod $leisurePeriod
     * @return void
     */
    public function addLeisurePeriod(\MUM\BjrFreizeit\Domain\Model\LeisurePeriod $leisurePeriod)
    {
        $this->leisurePeriod->attach($leisurePeriod);
    }
    
    /**
     * Removes a LeisurePeriod
     *
     * @param \MUM\BjrFreizeit\Domain\Model\LeisurePeriod $leisurePeriodToRemove The LeisurePeriod to be removed
     * @return void
     */
    public function removeLeisurePeriod(\MUM\BjrFreizeit\Domain\Model\LeisurePeriod $leisurePeriodToRemove)
    {
        $this->leisurePeriod->detach($leisurePeriodToRemove);
    }
    
    /**
     * Returns the leisurePeriod
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MUM\BjrFreizeit\Domain\Model\LeisurePeriod> $leisurePeriod
     */
    public function getLeisurePeriod()
    {
        return $this->leisurePeriod;
    }
    
    /**
     * Sets the leisurePeriod
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MUM\BjrFreizeit\Domain\Model\LeisurePeriod> $leisurePeriod
     * @return void
     */
    public function setLeisurePeriod(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $leisurePeriod)
    {
        $this->leisurePeriod = $leisurePeriod;
    }
    
    /**
     * Returns the organization
     *
     * @return \MUM\BjrFreizeit\Domain\Model\Organization $organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }
    
    /**
     * Sets the organization
     *
     * @param \MUM\BjrFreizeit\Domain\Model\Organization $organization
     * @return void
     */
    public function setOrganization(\MUM\BjrFreizeit\Domain\Model\Organization $organization)
    {
        $this->organization = $organization;
    }
    
    /**
     * Adds a Holiday
     *
     * @param \MUM\BjrFreizeit\Domain\Model\Holiday $holiday
     * @return void
     */
    public function addHoliday(\MUM\BjrFreizeit\Domain\Model\Holiday $holiday)
    {
        $this->holiday->attach($holiday);
    }
    
    /**
     * Removes a Holiday
     *
     * @param \MUM\BjrFreizeit\Domain\Model\Holiday $holidayToRemove The Holiday to be removed
     * @return void
     */
    public function removeHoliday(\MUM\BjrFreizeit\Domain\Model\Holiday $holidayToRemove)
    {
        $this->holiday->detach($holidayToRemove);
    }
    
    /**
     * Returns the holiday
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MUM\BjrFreizeit\Domain\Model\Holiday> $holiday
     */
    public function getHoliday()
    {
        return $this->holiday;
    }
    
    /**
     * Sets the holiday
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MUM\BjrFreizeit\Domain\Model\Holiday> $holiday
     * @return void
     */
    public function setHoliday(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $holiday)
    {
        $this->holiday = $holiday;
    }
    
    /**
     * Adds a Tags
     *
     * @param \MUM\BjrFreizeit\Domain\Model\Tags $tag
     * @return void
     */
    public function addTag(\MUM\BjrFreizeit\Domain\Model\Tags $tag)
    {
        $this->tags->attach($tag);
    }
    
    /**
     * Removes a Tags
     *
     * @param \MUM\BjrFreizeit\Domain\Model\Tags $tagToRemove The Tags to be removed
     * @return void
     */
    public function removeTag(\MUM\BjrFreizeit\Domain\Model\Tags $tagToRemove)
    {
        $this->tags->detach($tagToRemove);
    }
    
    /**
     * Returns the tags
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MUM\BjrFreizeit\Domain\Model\Tags> $tags
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    /**
     * Sets the tags
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\MUM\BjrFreizeit\Domain\Model\Tags> $tags
     * @return void
     */
    public function setTags(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tags)
    {
        $this->tags = $tags;
    }
    
    /**
     * Returns the url
     *
     * @return string $url
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * Sets the url
     *
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

}