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
 * Organization
 */
use TYPO3\CMS\Core\Utility\GeneralUtility;


class Organization extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $name = '';
    
    /**
     * url
     *
     * @var string
     */
    protected $url = '';
    
    /**
     * address
     *
     * @var \MUM\BjrFreizeit\Domain\Model\Address
     */
    protected $address = null;
    
    /**
     * contact
     *
     * @var \MUM\BjrFreizeit\Domain\Model\Contact
     */
    protected $contact = null;


    /* \TYPO3\CMS\Extbase\Domain\Model\FrontendUser */

    /**
     * Username zum Anmelden im FE
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     * @lazy
     */
    protected  $feusername;


    /**
     * @var int
     */
    protected $leisureFolderPid;


    /**
     * @var boolean
     */
    protected $onlineAdministration;



    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Returns the address
     *
     * @return \MUM\BjrFreizeit\Domain\Model\Address $address
     */
    public function getAddress()
    {
        return $this->address;
    }
    
    /**
     * Sets the address
     *
     * @param \MUM\BjrFreizeit\Domain\Model\Address $address
     * @return void
     */
    public function setAddress(\MUM\BjrFreizeit\Domain\Model\Address $address)
    {
        $this->address = $address;
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
    
    /**
     * Returns the contact
     *
     * @return \MUM\BjrFreizeit\Domain\Model\Contact $contact
     */
    public function getContact()
    {
        return $this->contact;
    }
    
    /**
     * Sets the contact
     *
     * @param \MUM\BjrFreizeit\Domain\Model\Contact $contact
     * @return void
     */
    public function setContact(\MUM\BjrFreizeit\Domain\Model\Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    public function getFeusername()
    {
        return $this->feusername;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feusername
     */
    public function setFeusername($feusername)
    {
        $this->feusername = $feusername;
    }

    /**
     * @return int
     */
    public function getLeisureFolderPid()
    {
        return $this->leisureFolderPid;
    }

    /**
     * @param int $leisureFolderPid
     */
    public function setLeisureFolderPid($leisureFolderPid)
    {
        $this->leisureFolderPid = $leisureFolderPid;
    }

    /**
     * @return mixed Page title of folder with leisures for organization, needed in view
     */
    public function getLeisureFolderPidTitle(){
        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        /** @var  $pageRepository    \TYPO3\CMS\Frontend\Page\PageRepository */
        $pageRepository = $objectManager->get('TYPO3\\CMS\\Frontend\\Page\\PageRepository');
        $row = $pageRepository->getPage($this->getLeisureFolderPid());

        return $row['title'];
    }


    /**
     * @return boolean
     */
    public function isOnlineAdministration()
    {
        return $this->onlineAdministration;
    }


    /**
     * @param boolean $onlineAdministration
     */
    public function setOnlineAdministration($onlineAdministration)
    {
        $this->onlineAdministration = $onlineAdministration;
    }


}