<?php
namespace Bjr\BjrLend\Domain\Repository;

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
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 *
 *
 * @package bjr_lend
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ReservationRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {


    /**
     * @param \Bjr\BjrLend\Domain\Model\Article $article
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByArticle(\Bjr\BjrLend\Domain\Model\Article $article){
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setStoragePageIds(array($article->getPid()));
        $this->setDefaultQuerySettings($querySettings);

        $query = $this->createQuery();
        $query->matching($query->equals('article', $article->getUid()));
        $result = $query->execute();
        return $result;
    }


    /**
     * @param \Bjr\BjrLend\Domain\Model\Organization $organization
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * find all articles for pid which belongs to organization
     */
    public function findByOrganization(\Bjr\BjrLend\Domain\Model\Organization $organization, $sortBy='issueStart', $sortOrder = 'desc'){
        $pid = $organization->getArticleFolderPid();
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setStoragePageIds(array($pid));
        $this->setDefaultQuerySettings($querySettings);

        if(strtoupper($sortOrder) == 'ASC'){
            $sortOrder = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING;
        }elseif(strtoupper($sortOrder) == 'DESC'){
            $sortOrder = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING;
        }

        $query = $this->createQuery();
        return $query->matching($query->equals('pid', $pid))
            ->setOrderings(array($sortBy => $sortOrder))
            ->execute();

    }

    /**
     * @param \Bjr\BjrLend\Domain\Model\Article $article
     * @param $period
     * @return array|null|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     *
     */
    public function checkPeriodForArticle(\Bjr\BjrLend\Domain\Model\Article $article, $period){
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setStoragePageIds(array($article->getPid()));
        $this->setDefaultQuerySettings($querySettings);

        $query = $this->createQuery();
        $constraints = array();

        foreach($period as $date) {
            $tempConstraints = array();
            $tempConstraints[] = $query->equals('article', $article->getUid());
            $tempConstraints[] = $query->lessThanOrEqual('issueStart', $date);
            $tempConstraints[] = $query->greaterThanOrEqual('issueEnd', $date);
            $constraints[] = $query->logicalAnd($tempConstraints);
        }

        if(count($constraints) > 0){
            $query->matching(
                $query->logicalOr(
                    $constraints
                )
            );
            $result = $query->execute();
            
        }else{
            $result = NULL;
        }

        return $result;
    }

}
?>