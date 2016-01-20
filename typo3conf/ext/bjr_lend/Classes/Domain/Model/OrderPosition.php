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
class OrderPosition extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity implements \Bjr\BjrLend\Domain\Model\PositionInterface {

	/**
	 * articleTitle
	 *
	 * @var \string
	 */
	protected $articleTitle;

	/**
	 * articleFee
	 *
	 * @var \string
	 */
	protected $articleFee;

	/**
	 * lendConditions
	 *
	 * @var \string
	 */
	protected $lendConditions;

	/**
	 * organizationName
	 *
	 * @var \string
	 */
	protected $organizationName;

	/**
	 * organizationStreet
	 *
	 * @var \string
	 */
	protected $organizationStreet;

	/**
	 * organizationZip
	 *
	 * @var \string
	 */
	protected $organizationZip;

	/**
	 * organizationCity
	 *
	 * @var \string
	 */
	protected $organizationCity;

	/**
	 * organizationPhone
	 *
	 * @var \string
	 */
	protected $organizationPhone;

	/**
	 * organizationEmail
	 *
	 * @var \string
	 */
	protected $organizationEmail;

	/**
	 * Relation zu Artikel
	 *
	 * @var \Bjr\BjrLend\Domain\Model\Article
	 */
	protected $article;

	/**
	 * @var \int
	 * Erster Tag der Ausleihe, Unix Timestamp
	 */
	protected $issueStart;

	/**
	 * @var \int
	 * Letzter Tag der Ausleihe, Unix Timestamp
	 */
	protected $issueEnd;


	/**
	 * Returns the articleTitle
	 *
	 * @return \string $articleTitle
	 */
	public function getArticleTitle() {
		return $this->articleTitle;
	}

	/**
	 * Sets the articleTitle
	 *
	 * @param \string $articleTitle
	 * @return void
	 */
	public function setArticleTitle($articleTitle) {
		$this->articleTitle = $articleTitle;
	}

	/**
	 * Returns the articleFee
	 *
	 * @return \string $articleFee
	 */
	public function getArticleFee() {
		return $this->articleFee;
	}

	/**
	 * Sets the articleFee
	 *
	 * @param \string $articleFee
	 * @return void
	 */
	public function setArticleFee($articleFee) {
		$this->articleFee = $articleFee;
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
	 * Returns the organizationName
	 *
	 * @return \string $organizationName
	 */
	public function getOrganizationName() {
		return $this->organizationName;
	}

	/**
	 * Sets the organizationName
	 *
	 * @param \string $organizationName
	 * @return void
	 */
	public function setOrganizationName($organizationName) {
		$this->organizationName = $organizationName;
	}

	/**
	 * Returns the organizationStreet
	 *
	 * @return \string $organizationStreet
	 */
	public function getOrganizationStreet() {
		return $this->organizationStreet;
	}

	/**
	 * Sets the organizationStreet
	 *
	 * @param \string $organizationStreet
	 * @return void
	 */
	public function setOrganizationStreet($organizationStreet) {
		$this->organizationStreet = $organizationStreet;
	}

	/**
	 * Returns the organizationZip
	 *
	 * @return \string $organizationZip
	 */
	public function getOrganizationZip() {
		return $this->organizationZip;
	}

	/**
	 * Sets the organizationZip
	 *
	 * @param \string $organizationZip
	 * @return void
	 */
	public function setOrganizationZip($organizationZip) {
		$this->organizationZip = $organizationZip;
	}

	/**
	 * Returns the organizationCity
	 *
	 * @return \string $organizationCity
	 */
	public function getOrganizationCity() {
		return $this->organizationCity;
	}

	/**
	 * Sets the organizationCity
	 *
	 * @param \string $organizationCity
	 * @return void
	 */
	public function setOrganizationCity($organizationCity) {
		$this->organizationCity = $organizationCity;
	}

	/**
	 * Returns the organizationPhone
	 *
	 * @return \string $organizationPhone
	 */
	public function getOrganizationPhone() {
		return $this->organizationPhone;
	}

	/**
	 * Sets the organizationPhone
	 *
	 * @param \string $organizationPhone
	 * @return void
	 */
	public function setOrganizationPhone($organizationPhone) {
		$this->organizationPhone = $organizationPhone;
	}

	/**
	 * Returns the organizationEmail
	 *
	 * @return \string $organizationEmail
	 */
	public function getOrganizationEmail() {
		return $this->organizationEmail;
	}

	/**
	 * Sets the organizationEmail
	 *
	 * @param \string $organizationEmail
	 * @return void
	 */
	public function setOrganizationEmail($organizationEmail) {
		$this->organizationEmail = $organizationEmail;
	}

	/**
	 * Returns the article
	 *
	 * @return  \Bjr\BjrLend\Domain\Model\Article
	 */
	public function getArticle() {
		return $this->article;
	}

	/**
	 * Sets the article
	 *
	 * @param  $article \Bjr\BjrLend\Domain\Model\Article
	 * @return void
	 */
	public function setArticle(Article $article) {
		$this->article = $article;
	}




	/**
	 * @return array
	 */
	public function getDurationOfIssue()
	{
		$duration = ($this->issueEndDay - $this->issueStartDay);
		return $duration;
	}

	/**
	 * @return string
	 * Ausleihdatum Von
	 */
	public function getIssueStartDay(){

		return strftime('%d.%m.%G', $this->issueStart);
	}
	/**
	 * @return \int
	 * Ausleihdatum Von als Unix Timestamp
	 */
	public function getIssueStart(){

		return $this->issueStart;
	}

	/**
	 * @param int $issueStart
	 */
	public function setIssueStart($issueStart)
	{
		$this->issueStart = $issueStart;
	}


	/**
	 * @return string
	 * Ausleihdatum bis
	 */
	public function getIssueEndDay(){
		return strftime('%d.%m.%G', $this->issueEnd);
	}

	/**
	 * @return \int
	 * Ausleihdatum bis als Unix Timestamp
	 */
	public function getIssueEnd(){
		return $this->issueEnd;
	}

	/**
	 * @param int $issueEnd
	 */
	public function setIssueEnd($issueEnd)
	{
		$this->issueEnd = $issueEnd;
	}



	/**
	 * @param \Bjr\BjrLend\Domain\Model\Article $item
	 * Initialisiert Position mit Artikeldaten
	 */
	public function initializeFrom(\Bjr\BjrLend\Domain\Model\Article $item){
		$this->setArticleTitle($item->getTitle());
		$this->setArticleFee($item->getFee());
		$this->setLendConditions(($item->getLendConditions()));

		$this->setOrganizationName($item->getOrganization()->getName());
		if(is_object($item->getOrganization()->getAddress())){
			$this->setOrganizationStreet($item->getOrganization()->getAddress()->getStreet());
			$this->setOrganizationZip($item->getOrganization()->getAddress()->getZip());
			$this->setOrganizationCity($item->getOrganization()->getAddress()->getCity());
			$this->setOrganizationPhone($item->getOrganization()->getAddress()->getPhone());
			$this->setOrganizationEmail($item->getOrganization()->getAddress()->getEmail());
		}

		$this->setArticle($item);
	}

}
?>