<?php
namespace MUM\BjrFreizeit\Domain\Repository;

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
 * The repository for Leisures
 */
class LeisureRepository extends AbstractRepository
{
    const SORTING_ALFABETICAL = 0;
    const SORTING_CREATIONDATE = 1;

    const SORTING_RANDOM = 4;


    /**
     * @param $sorting
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * Searches for all articles, taking sorting into consideration
     */
    public function findAllSorting($sorting, $category = -1){
        $query = $this->createQuery();

        switch($sorting){
            case self::SORTING_ALFABETICAL:
                $sorting = array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
                break;
            case self::SORTING_CREATIONDATE:
                $sorting = array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
                break;

            default:
                $sorting = array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
        }
        $query->setOrderings($sorting);
        if($category != -1){
            $query->matching($query->equals('category', $category));
        }
        $result = $query->execute();
        return $result;
    }

    /**
     * @param $sorting
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * Searches for all articles, taking sorting into consideration
     */
    public function findNewestSorting($sorting, $limit = 3){
        $query = $this->createQuery();

        switch($sorting){
            case self::SORTING_ALFABETICAL:
                $sorting = array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
                break;
            case self::SORTING_CREATIONDATE:
                $sorting = array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING);
                break;
            case self::SORTING_AVAILABILITY:
                $sorting = array('isLend' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
                break;
            case self::SORTING_REGION:
                $sorting = array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
                break;

            default:
                $sorting = array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
        }
        $query->setOrderings($sorting);
        $result = $query->setLimit((int)$limit)->execute();
        return $result;
    }


    public function findRandomSorting($number){
        //echo 'Sorting :' .$sorting;
        //exit();
        $number = intval($number) > 0 ? intval($number) : 4;
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        $query->getQuerySettings()->setRespectSysLanguage(FALSE);
        //$query->getQuerySettings()->getReturnRawQueryResult(TRUE);
        $statement = 'SELECT * from tx_bjrlend_domain_model_article WHERE deleted != 1 AND hidden != 1 ORDER BY RAND() LIMIT ' . $number;
        $query->statement($statement);
        $result = $query->execute();

        return $result;

    }


    /**
     * @param $sorting
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * Searches for all articles, taking sorting into consideration
     */
    public function findMostPopularSorting($sorting){
        $query = $this->createQuery();

        switch($sorting){
            case self::SORTING_ALFABETICAL:
                $sorting = array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
                break;
            case self::SORTING_CREATIONDATE:
                $sorting = array('crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING);
                break;
            case self::SORTING_AVAILABILITY:
                $sorting = array('isLend' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
                break;
            case self::SORTING_REGION:
                $sorting = array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
                break;
            default:
                $sorting = array('title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING);
        }
        $query->setOrderings($sorting);
        $result = $query->setLimit(4)->execute();
        return $result;
    }


    public function searchFor($searchMatrix){
        $query = $this->createQuery();
        $constraints = array();
        foreach($searchMatrix as $param => $value){
            if(strlen($value) > 0){
                switch($param){
                    case 'stichwort':
                        $searchValue = '%' . $value .'%';
                        $constraints[] = $query->like('title', $searchValue);
                        break;
                    case 'selectSubKat':
                        $constraints[] = $query->equals('category', $value);
                        break;
                    case 'selectOrg':
                        $constraints[] = $query->equals('organization', $value);
                        break;
                    case 'online':
                        $constraints[] = $query->equals('booking_online', $value);
                        break;
                    case 'byPhone':
                        $constraints[] = $query->equals('booking_phone', $value);
                        break;
                    case 'selectLoc':
                        $constraints[] = $query->equals('organization.region.uid', $value);
                        break;
                }
            }
        }
        $query->matching(
            $query->logicalAnd(
                $constraints
            )
        );
        $result = $query->execute();
        return $result;

    }


    /**
     * @param \MUM\BjrFreizeit\Domain\Model\Organization
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * find all articles for pid which belongs to organization
     */
    public function findByOrganization(\MUM\BjrFreizeit\Domain\Model\Organization $organization){
        $pid = $organization->getLeisureFolderPid();
        $querySettings = $this->createQuery()->getQuerySettings();
        $querySettings->setStoragePageIds(array($pid));

        $this->setDefaultQuerySettings($querySettings);
        return $this->findByPid($pid);
    }



    /**
     * @param $categoryId  int
     * @return int
     * Returns number of article in category
     */
    public function numberArticlesInCategory($categoryId){
        $number = 0;
        $query = $this->createQuery();
        $query->matching($query->equals('category', $categoryId));
        $number = $query->count();

        return $number;
    }


    /**
     * Save an image with FAL
     * @param \TYPO3\CMS\Core\Resource\File $fileObject
     * @param \MUM\BjrFreizeit\Domain\Model\Leisure $leisure
     * @param $pid
     * @return int last insert id, file reference uid
     *
     */
    public function saveImage(\TYPO3\CMS\Core\Resource\File $fileObject, \MUM\BjrFreizeit\Domain\Model\Leisure $leisure){
        //$dateiname = $filename; // Dateinamen auslesen
        $tabellenName = 'tx_bjrfreizeit_domain_model_leisure';
        $feldName = 'image';

        $data = array(
            'uid_local'     => $fileObject->getUid(),
            'uid_foreign'   => $leisure->getUid(), // uid Inhaltselement oder Datensatz
            'tablenames'    => $tabellenName,
            'fieldname'     => $feldName,
            'pid'           => $leisure->getPid(), // Seite wo der Datensatz lliegt
            'table_local'   => 'sys_file',
            'tstamp'        => time(),
            'crdate'        => time(),
            'cruser_id'     => 100
        );
        $where = 'deleted ="0" AND hidden ="0" AND tablenames ="' . $tabellenName
            . '" AND uid_foreign=' . (int)$leisure->getUid() . ' AND table_local="sys_file"'
            . ' AND fieldname ="' . $feldName . '"';
        $row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('*',
            'sys_file_reference',
            $where
        );
        if(empty($row)) {

            $GLOBALS['TYPO3_DB']->exec_INSERTquery('sys_file_reference',
                $data,
                FALSE);
            $res = $GLOBALS['TYPO3_DB']->sql_insert_id();
        }else{
            $data = array(
                'uid_local' => $fileObject->getUid(),
                'tstamp' => time(),
                'cruser_id' => 100
            );

            $res =$GLOBALS['TYPO3_DB']->exec_UPDATEquery('sys_file_reference',
                $where,
                $data,
                FALSE);

        }
        return $res;
    }




}