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
class Article extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * Titel
	 *
	 * @var \string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * Kurzbeschreibung
	 *
	 * @var \string
	 */
	protected $shortDescription;

	/**
	 * Beschreibung
	 *
	 * @var \string
	 */
	protected $description;

	/**
	 * Preis
	 *
	 * @var \string
	 */
	protected $price;

	/**
	 * Leistungsbeschreibung
	 *
	 * @var \string
	 */
	protected $serviceSpecification;

	/**
	 * Mindestteilnehmerzahl
	 *
	 * @var \int
	 */
	protected $minimumParticipants;

	/**
	 * Partner
	 *
	 * @var \string
	 */
	protected $partner;

	/**
	 * Kooperation
	 *
	 * @var \string
	 */
	protected $cooperation;

	/**
	 * Bilder
	 *
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $image;

	/**
	 * Ort ganz allgemein
	 *
	 * @var \string
	 */
	protected $location;

	/**
	 * Zeitraum
	 *
	 * @var \string
	 */
	protected $timePeriod;

	/**
	 * Leiter
	 *
	 * @var \string
	 */
	protected $leader;

	/**
	 * Referent
	 *
	 * @var \string
	 */
	protected $referent;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\TargetGroup>
	 */
	protected $targetGroup;


	/**
	 * Kategoriebeziehung
	 *
	 * @var \Bjr\BjrLend\Domain\Model\Category
	 */
	protected $category;


	/**
	 * Veranstalter
	 *
	 * @var \Bjr\BjrLend\Domain\Model\Organization
	 */
	protected $organization;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\LendDates>
	 */
	protected $lendDates;



    /**
     * @var \int
     */
    protected $crdate;



	/**
	 * Returns the title
	 *
	 * @return \string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param \string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the shortDescription
	 *
	 * @return \string $shortDescription
	 */
	public function getShortDescription() {
		return $this->shortDescription;
	}

	/**
	 * Sets the shortDescription
	 *
	 * @param \string $shortDescription
	 * @return void
	 */
	public function setShortDescription($shortDescription) {
		$this->shortDescription = $shortDescription;
	}

	/**
	 * Returns the description
	 *
	 * @return \string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param \string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the lendConditions
	 *
	 * @return \string $lendConditions
	 */
	public function getLendConditions() {
		return $this->lendConditions;
	}

	/**
	 * Sets the lendConditions
	 *
	 * @param \string $lendConditions
	 * @return void
	 */
	public function setLendConditions($lendConditions) {
		$this->lendConditions = $lendConditions;
	}

	/**
	 * Returns the fee
	 *
	 * @return \string $fee
	 */
	public function getFee() {
		return $this->fee;
	}

	/**
	 * Sets the fee
	 *
	 * @param \string $fee
	 * @return void
	 */
	public function setFee($fee) {
		$this->fee = $fee;
	}

	/**
	 * Returns the bookingOnline
	 *
	 * @return boolean $bookingOnline
	 */
	public function getBookingOnline() {
		return $this->bookingOnline;
	}

	/**
	 * Sets the bookingOnline
	 *
	 * @param boolean $bookingOnline
	 * @return void
	 */
	public function setBookingOnline($bookingOnline) {
		$this->bookingOnline = $bookingOnline;
	}

	/**
	 * Returns the boolean state of bookingOnline
	 *
	 * @return boolean
	 */
	public function isBookingOnline() {
		return $this->getBookingOnline();
	}

	/**
	 * Returns the bookingPhone
	 *
	 * @return boolean $bookingPhone
	 */
	public function getBookingPhone() {
		return $this->bookingPhone;
	}

	/**
	 * Sets the bookingPhone
	 *
	 * @param boolean $bookingPhone
	 * @return void
	 */
	public function setBookingPhone($bookingPhone) {
		$this->bookingPhone = $bookingPhone;
	}

	/**
	 * Returns the boolean state of bookingPhone
	 *
	 * @return boolean
	 */
	public function isBookingPhone() {
		return $this->getBookingPhone();
	}

	/**
	 * Returns the phone
	 *
	 * @return \string $phone
	 */
	public function getPhone() {
		return $this->phone;
	}

	/**
	 * Sets the phone
	 *
	 * @param \string $phone
	 * @return void
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
	}

	/**
	 * Returns the byEmail
	 *
	 * @return \string $byEmail
	 */
	public function getByEmail() {
		return $this->byEmail;
	}

	/**
	 * Sets the byEmail
	 *
	 * @param \string $byEmail
	 * @return void
	 */
	public function setByEmail($byEmail) {
		$this->byEmail = $byEmail;
	}

	/**
	 * Returns the email
	 *
	 * @return \string $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * Sets the email
	 *
	 * @param \string $email
	 * @return void
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }


    public function getUrlForImage(){
        $path = '';
        //<f:image src="{article.image.originalResource.publicUrl}" width="200" alt="Produktbild" treatIdAsReference="TRUE"/>
        if(is_a($this->image, '\TYPO3\CMS\Extbase\Domain\Model\FileReference')){
            $path = $this->image->getOriginalResource()->getPublicUrl();
        }else{
            //default path
            $path = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::siteRelPath('bjr_lend') .'Resources/Public/Images/defaultArticle.png';

        }
        return $path;
    }

	/**
	 * Returns the isLend
	 *
	 * @return boolean $isLend
	 */
	public function getIsLend() {
		return $this->isLend;
	}

	/**
	 * Sets the isLend
	 *
	 * @param boolean $isLend
	 * @return void
	 */
	public function setIsLend($isLend) {
		$this->isLend = $isLend;
	}

	/**
	 * Returns the boolean state of isLend
	 *
	 * @return boolean
	 */
	public function isIsLend() {
		return $this->getIsLend();
	}

	/**
	 * Returns the showCalendar
	 *
	 * @return boolean $showCalendar
	 */
	public function getShowCalendar() {
		return $this->showCalendar;
	}

	/**
	 * Sets the showCalendar
	 *
	 * @param boolean $showCalendar
	 * @return void
	 */
	public function setShowCalendar($showCalendar) {
		$this->showCalendar = $showCalendar;
	}

	/**
	 * Returns the boolean state of showCalendar
	 *
	 * @return boolean
	 */
	public function isShowCalendar() {
		return $this->getShowCalendar();
	}

	/**
	 * Returns the category
	 *
	 * @return \Bjr\BjrLend\Domain\Model\Category $category
	 */
	public function getCategory() {
		return $this->category;
	}

	/**
	 * Sets the category
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Category $category
	 * @return void
	 */
	public function setCategory(\Bjr\BjrLend\Domain\Model\Category $category) {
		$this->category = $category;
	}

	/**
	 * @param \Bjr\BjrLend\Domain\Model\Organization $organization
	 */
	public function setOrganization($organization)
	{
		$this->organization = $organization;
	}

	/**
	 * @return \Bjr\BjrLend\Domain\Model\Organization
	 */
	public function getOrganization()
	{
		return $this->organization;
	}

    /**
     * @param int $crdate
     */
    public function setCrdate($crdate)
    {
        $this->crdate = $crdate;
    }

    /**
     * @return int
     */
    public function getCrdate()
    {
        return $this->crdate;
    }




	/**
	 * initializeObject
	 *
	 * @return Basket
	 */
	public function initializeObject() {
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
		$this->lendDates = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->reservations = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Adds a lendDate
	 *
	 * @param \Bjr\BjrLend\Domain\Model\LendDates $date
	 * @return void
	 */
	public function addLendDate(\Bjr\BjrLend\Domain\Model\LendDates $date) {
		$this->lendDates->attach($date);
	}

	/**
	 * Removes a lendDate
	 *
	 * @param \Bjr\BjrLend\Domain\Model\LendDates $date The date to be removed
	 * @return void
	 */
	public function removeLendDate(\Bjr\BjrLend\Domain\Model\LendDates $date) {
		$this->lendDates->detach($date);
	}


	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $lendDates
	 */
	public function setLendDates($lendDates)
	{
		$this->lendDates = $lendDates;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getLendDates()
	{
		return $this->lendDates;
	}


	//Reservatioins
	/**
	 * Adds a Reservation
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Reservation $reservation
	 * @return void
	 */
	public function addReservation(\Bjr\BjrLend\Domain\Model\Reservation $reservation) {
		$this->reservations->attach($reservation);
	}

	/**
	 * Removes a reservation
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Reservation $reservation The reservation to be removed
	 * @return void
	 */
	public function removeReservation(\Bjr\BjrLend\Domain\Model\Reservation $reservation) {
		$this->reservations->detach($reservation);
	}


	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $reservations
	 */
	public function setReservations($reservations)
	{
		$this->reservations = $reservations;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getReservations()
	{
		return $this->reservations;
	}


    /**
     * @param Organization $organization
     * set article with data from organization
     */
    public function copyDataFromOrganization(\Bjr\BjrLend\Domain\Model\Organization $organization){
        $this->setPhone($organization->getAddress()->getPhone());
        $this->setByEmail($organization->getAddress()->getEmail());
        $this->setEmail($organization->getAddress()->getEmail());
        $this->setOrganization($organization);
        $this->setShowCalendar(true);
        $this->setPid($organization->getArticleFolderPid());
        //$this->setPhone($organization->getAddress()->getPhone());

    }

    public function saveImage($filename){

    }
}
?>