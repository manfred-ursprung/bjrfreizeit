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
 * Basketitem
 *
 * @package bjr_lend
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class BasketItem extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity implements \Bjr\BjrLend\Domain\Model\PositionInterface {

	/**
	 * Reference zu Artikel, Artikeluid
	 * @var \int
	 */
	protected $articleUid;
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
	 * Ausleihbedignungen
	 *
	 * @var \string
	 */
	protected $lendConditions;

	/**
	 * Gebühr
	 *
	 * @var \string
	 */
	protected $fee;

	/**
	 * online buchbar
	 *
	 * @var boolean
	 */
	protected $bookingOnline = FALSE;

	/**
	 * telefonisch buchbar
	 *
	 * @var boolean
	 */
	protected $bookingPhone = FALSE;

	/**
	 * Telefonnummer
	 *
	 * @var \string
	 */
	protected $phone;

	/**
	 * Anfrage per Email
	 *
	 * @var \string
	 */
	protected $byEmail;

	/**
	 * Email Adresse
	 *
	 * @var \string
	 */
	protected $email;

	/**
	 * Bilder
	 *
	 * @var \string
	 */
	protected $image;


	/**
	 * Kategoriebeziehung
	 *
	 * @var \Bjr\BjrLend\Domain\Model\Category
	 */
	protected $category;



	/**
	 * Ausleihstelle
	 *
	 * @var \Bjr\BjrLend\Domain\Model\Organization
	 */
	protected $organization;


	/**
	 * @var \array
	 * Von - Bis Datum als Unixtimestamp oder lesbares Datumsformat
	 */
	protected $durationOfIssue;

    /**
     * @var \int
     * Position number, to identify a basket item
     */
    protected $posNo;


	/**
	 * @param int $articleUid
	 */
	public function setArticleUid($articleUid)
	{
		$this->articleUid = $articleUid;
	}

	/**
	 * @return int
	 */
	public function getArticleUid()
	{
		return $this->articleUid;
	}



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
	 * Returns the image
	 *
	 * @return \string $image
	 */
	public function getImage() {
		return $this->image;
	}

	/**
	 * Sets the image
	 *
	 * @param \string $image
	 * @return void
	 */
	public function setImage($image) {
		$this->image = $image;
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
     * @param int $posNo
     */
    public function setPosNo($posNo)
    {
        $this->posNo = $posNo;
    }

    /**
     * @return int
     */
    public function getPosNo()
    {
        return $this->posNo;
    }


	/**
	 * @param array $durationOfIssue
	 */
	public function setDurationOfIssue($durationOfIssue)
	{
		$this->durationOfIssue = $durationOfIssue;
	}

	/**
	 * @return array
	 */
	public function getDurationOfIssue()
	{
		return $this->durationOfIssue;
	}

	/**
	 * @return string
	 * Ausleihdatum Von
	 */
	public function getIssueStartDay(){
		$startDay = '';
		if(!empty($this->durationOfIssue)){
			$startDay = $this->durationOfIssue[0];
		}
		return $startDay;
	}

	/**
	 * @return string
	 * Ausleihdatum bis
	 */
	public function getIssueEndDay(){
		$endDay = '';
		if(!empty($this->durationOfIssue) && (count($this->durationOfIssue) > 1)){
			$endDay = $this->durationOfIssue[1];
		}
		return $endDay;
	}

	/**
	 * @return int
	 * convert issue start date to unix timestamp
	 */
	public function getIssueStartDayAsTimestamp(){
		$parts = preg_split("#\.#", $this->getIssueStartDay());
		$tstamp = mktime(0,0,0, $parts[1], $parts[0], $parts[2]);
		return $tstamp;
	}

	/**
	 * @return int
	 * * convert issue start date to unix timestamp
	 */
	public function getIssueEndDayAsTimestamp(){
		$parts = preg_split("#\.#", $this->getIssueEndDay());
		$tstamp = mktime(0,0,0, $parts[1], $parts[0], $parts[2]);
		return $tstamp;
	}

	/**
	 * @param \Bjr\BjrLend\Domain\Model\Article $article
	 * @return \Bjr\BjrLend\Domain\Model\BasketItem
	 */
	public static function getItemFromArticle(\Bjr\BjrLend\Domain\Model\Article $article){
		/* @var $newItem \Bjr\BjrLend\Domain\Model\BasketItem */
		$newItem = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Model\\BasketItem');
		$newItem->initializeFrom($article);
		return $newItem;
	}

	/**
	 * @param Article $article
	 * Initialisiert Item mit Artikeldaten
	 */
	protected function initializeFrom(\Bjr\BjrLend\Domain\Model\Article $article){
		$this->setArticleUid($article->getUid());
		$this->setTitle($article->getTitle());
		$this->setDescription($article->getDescription());
		$this->setShortDescription($article->getShortDescription());
		$this->setFee($article->getFee());
		$this->setOrganization($article->getOrganization());
		$this->setCategory($article->getCategory());
		//$this->setImage($article->getImage());
        $this->setImage($article->getUrlForImage());
		$this->setEmail($article->getEmail());
		$this->setPhone($article->getPhone());
		$this->setLendConditions($article->getLendConditions());

	}

	/**
	 * @return array
	 * for storing in session
	 */
	public function asArray(){
		$arr = array(
			'articleUid' => $this->articleUid,
			'title'		=>	$this->title,
			'fee'		=>	$this->fee,
			'issueStart'=>	(count($this->durationOfIssue) > 0 ? $this->durationOfIssue[0] : ''),
			'issueEnd'	=>	(count($this->durationOfIssue) > 1 ? $this->durationOfIssue[1] : ''),
		);
		return $arr;
	}


}
?>