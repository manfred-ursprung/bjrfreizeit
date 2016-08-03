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
class Reservation extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    const STATUS_WAITING = 0;
    const STATUS_CONFIRMED = 1;
    const STATUS_REJECTED = 2;

	/**
	 * Ausleihdatum von
	 *
	 * @var \int
     * @validate Integer
	 */
	protected $issueStart;


	/**
	 * Ausleihdatum bis
	 *
	 * @var \int
     * @validate Integer
	 */
	protected $issueEnd;

	/**
	 * customerName
	 *
	 * @var \string
     * @validate StringLength(minimum=3, maximum=255)
	 */
	protected $customerName;

	/**
	 * customerPhone
	 *
	 * @var \string
	 */
	protected $customerPhone;

	/**
	 * customerEmail
	 *
	 * @var \string
     * @validate Email
	 */
	protected $customerEmail;

	/**
	 * Relation zu Artikel
	 *
	 * @var \Bjr\BjrLend\Domain\Model\Article
	 */
	protected $article;

    /**
     * @var \int
     */
    protected $status;


	/**
	 * @param int $issueStart
	 */
	public function setIssueStart($issueStart)
	{
		$this->issueStart = $issueStart;
	}

	/**
	 * @return int
	 */
	public function getIssueStart()
	{
		return $this->issueStart;
	}

	/**
	 * @param int $issueEnd
	 */
	public function setIssueEnd($issueEnd)
	{
		$this->issueEnd = $issueEnd;
	}

	/**
	 * @return int
	 */
	public function getIssueEnd()
	{
		return $this->issueEnd;
	}


		/**
	 * @param string $customerPhone
	 */
	public function setCustomerPhone($customerPhone)
	{
		$this->customerPhone = $customerPhone;
	}

	/**
	 * @return string
	 */
	public function getCustomerPhone()
	{
		return $this->customerPhone;
	}

	/**
	 * @param string $customerName
	 */
	public function setCustomerName($customerName)
	{
		$this->customerName = $customerName;
	}

	/**
	 * @return string
	 */
	public function getCustomerName()
	{
		return $this->customerName;
	}

	/**
	 * @param string $customerEmail
	 */
	public function setCustomerEmail($customerEmail)
	{
		$this->customerEmail = $customerEmail;
	}

	/**
	 * @return string
	 */
	public function getCustomerEmail()
	{
		return $this->customerEmail;
	}

	/**
	 * @param \Bjr\BjrLend\Domain\Model\Article $article
	 */
	public function setArticle($article)
	{
		$this->article = $article;
	}

	/**
	 * @return \Bjr\BjrLend\Domain\Model\Article
	 */
	public function getArticle()
	{
		return $this->article;
	}

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }



    /**
     * @return array
     * returns an array with all days between issueStart and issueEnd
     * elements in array are
     */
    public function _listIssueDays(){
        $list = array();
        $issueStart = \DateTime::createFromFormat('Y-m-d', date('Y-m-d', $this->getIssueStart()));
        $issueEnd = \DateTime::createFromFormat('Y-m-d', date('Y-m-d', $this->getIssueEnd()));
        $list[] = $issueStart;
        $tempDate = $issueStart;

        while( $tempDate !=  $issueEnd){
            $tempDate->add(new \DateInterval('P1D'));
            $list[] = $tempDate;
        }
        //var_dump($list);
        //exit();

        return $list;
    }

    /**
     * @return array
     * returns an array with all days between issueStart and issueEnd
     * elements in array are integer
     */
    public function listIssueDays(){
        $list = array();
        $dateStep =  $this->getIssueStart();
        $issueEnd = $this->getIssueEnd();
        $interval = 24 * 60 *60; // one day
        while($dateStep <= $issueEnd){
            $list[] = $dateStep;
            $dateStep += $interval;
        }
        return $list;
    }


    /**
     * @return string
     *
     */
    public function getStatusInfo(){
        $statusInfo = '';
        if($this->status == self::STATUS_WAITING){
            $statusInfo = "Wartet";
        }
        if($this->status == self::STATUS_CONFIRMED){
            $statusInfo = "Bestätigt";
        }
        if($this->status == self::STATUS_REJECTED){
            $statusInfo = "Abgelehnt";
        }
        return $statusInfo;
    }

    /**
     * @return string
     *
     */
    public function asString(){
        $string = date('d.m.y', $this->getIssueStart()) .' - ' . date('d.m.y', $this->getIssueEnd()) .', ';
        $string .= $this->getCustomerName() .', ' . $this->getCustomerEmail();
        return $string;
    }
}
?>