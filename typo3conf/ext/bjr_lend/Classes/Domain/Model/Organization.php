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

use  \TYPO3\CMS\Core\Utility\GeneralUtility;
use   \Bjr\BjrLend\Domain\Repository\ArticleRepository;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class Organization extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * name
	 *
	 * @var \string
     * @validate Text
	 */
	protected $name;

	/**
	 * Ausleihbedingungen
	 *
	 * @var \string
     * @validate Text
	 */
	protected $lendConditions;

	/**
	 * Infos zur Ausleihstelle
	 *
	 * @var \string
     * @validate Text
	 */
	protected $info;

	/**
	 * AGB
	 *
	 * @var \string
     * @validate Text
	 */
	protected $agb;


	/**
	 * openingTimes
	 *
	 * @var \string
     * @validate Text
	 */
	protected $openingTimes;

	/**
	 * address
	 *
	 * @var \Bjr\BjrLend\Domain\Model\Address
     * @validate NotEmpty
	 */
	protected $address;

	/**
	 * Ansprechpartner
	 *
	 * @var \Bjr\BjrLend\Domain\Model\Contact
	 * @lazy
	 */
	protected $contact;

	/**
	 * Region
	 *
	 * @var \Bjr\BjrLend\Domain\Model\Region
	 * @lazy
     *
	 */
	protected $region;

	/**
	 * Artikel
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\Article>
	 */
	protected $articles;
/* \TYPO3\CMS\Extbase\Domain\Model\FrontendUser */

    /**
     * Username zum Anmelden im FE
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     * @lazy
     */
    protected  $feusername;

    /**
     * @var string
     *
     */
    protected $password;

    /**
     * @var string
     *
     */
    protected $passwordConfirmation;


    /**
     * @var int
     */
    protected $articleFolderPid;

    /**
     * @var boolean
     */
    protected $onlineAdministration;


    /**
     * @var boolean
     */
    protected $localOnly;



	/**
	 * Returns the name
	 *
	 * @return \string $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Sets the name
	 *
	 * @param \string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
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
	 * @param string $info
	 */
	public function setInfo($info)
	{
		$this->info = $info;
	}

	/**
	 * @return string
	 */
	public function getInfo()
	{
		return $this->info;
	}

	/**
	 * @param string $agb
	 */
	public function setAgb($agb)
	{
		$this->agb = $agb;
	}

	/**
	 * @return string
	 */
	public function getAgb()
	{
		return $this->agb;
	}



	/**
	 * Returns the openingTimes
	 *
	 * @return \string $openingTimes
	 */
	public function getOpeningTimes() {
		return $this->openingTimes;
	}

	/**
	 * Sets the openingTimes
	 *
	 * @param \string $openingTimes
	 * @return void
	 */
	public function setOpeningTimes($openingTimes) {
		$this->openingTimes = $openingTimes;
	}

	/**
	 * Returns the address
	 *
	 * @return \Bjr\BjrLend\Domain\Model\Address $address
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Sets the address
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Address $address
	 * @return void
	 */
	public function setAddress(\Bjr\BjrLend\Domain\Model\Address $address) {
		$this->address = $address;
	}

	/**
	 * Returns the contact
	 *
	 * @return \Bjr\BjrLend\Domain\Model\Contact $contact
	 */
	public function getContact() {
		return $this->contact;
	}

	/**
	 * Sets the contact
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Contact $contact
	 * @return void
	 */
	public function setContact(\Bjr\BjrLend\Domain\Model\Contact $contact) {
		$this->contact = $contact;
	}

	/**
	 * @param \Bjr\BjrLend\Domain\Model\Region $region
	 */
	public function setRegion($region)
	{
		$this->region = $region;
	}

	/**
	 * @return \Bjr\BjrLend\Domain\Model\Region
	 */
	public function getRegion()
	{
		return $this->region;
	}

    /* \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feusername */


    /**
     * @param  \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feusername
     */
    public function setFeusername($feusername)
    {
        $this->feusername = $feusername;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feusername
     */
    public function getFeusername()
    {
        return $this->feusername;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $passwordConfirmation
     */
    public function setPasswordConfirmation($passwordConfirmation)
    {
        $this->passwordConfirmation = $passwordConfirmation;
    }


    /**
     * @return string
     */
    public function getPasswordConfirmation()
    {
        return $this->passwordConfirmation;
    }

    /**
     * @param int $articleFolderPid
     */
    public function setArticleFolderPid($articleFolderPid)
    {
        $this->articleFolderPid = $articleFolderPid;
    }

    /**
     * @return int
     */
    public function getArticleFolderPid()
    {
        return $this->articleFolderPid;
    }

    public function getArticleFolderPidTitle(){
        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        /** @var  $pageRepository    \TYPO3\CMS\Frontend\Page\PageRepository */
        $pageRepository = $objectManager->get('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
        $row = $pageRepository->getPage($this->getArticleFolderPid());

        return $row['title'];
    }

    /**
     * @param boolean $onlineAdministration
     */
    public function setOnlineAdministration($onlineAdministration)
    {
        $this->onlineAdministration = $onlineAdministration;
    }

    /**
     * @return boolean
     */
    public function getOnlineAdministration()
    {
        return $this->onlineAdministration;
    }

    /**
     * @param boolean $localOnly
     */
    public function setLocalOnly($localOnly)
    {
        $this->localOnly = $localOnly;
    }

    /**
     * @return boolean
     */
    public function getLocalOnly()
    {
        return $this->localOnly;
    }




	/**
	 * __construct
	 *
	 * @return Order
	 */
	public function __construct() {
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
		$this->articles = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Adds a article
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Article $article
	 * @return void
	 */
	public function addArticle(\Bjr\BjrLend\Domain\Model\Article $article) {
		$this->articles->attach($article);
	}

	/**
	 * Removes a Organization
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Article $positionToRemove The Organization to be removed
	 * @return void
	 */
	public function removeArticle(\Bjr\BjrLend\Domain\Model\Article $articleToRemove) {
		$this->articles->detach($articleToRemove);
	}

	/**
	 * Returns the organizations
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\Articles> $articles
	 */
	public function getArticles() {
		return $this->articles;
	}

	/**
	 * Sets the organizations
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\Articles> $articles
	 * @return void
	 */
	public function setArticles(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $articles) {
		$this->articles = $articles;
	}

    /**
     * @return bool
     */
    public function hasArticles(){
        /** @var  $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        /** @var  $articleRepository ArticleRepository */
        $articleRepository = $objectManager->get('Bjr\\BjrLend\\Domain\\Repository\\ArticleRepository');
        /** @var  $articles \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult */
        $articles = $articleRepository->findByOrganization($this);

        return $articles->count() > 0;

    }

    /**
     * @return array
     */
    public function validToRemove(){
        $valid = true;
        $messages = array();

        if($this->hasArticles()){
            $valid = false;
            $messages[] = "Es gibt noch Artikel zu dieser Ausleihstelle";
        }
        return array($valid, $messages);
    }

}
?>