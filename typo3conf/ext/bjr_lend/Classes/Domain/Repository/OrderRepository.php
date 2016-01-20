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

/**
 *
 *
 * @package bjr_lend
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class OrderRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	public function createModel(){
		$order = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Model\\Order');
		return $order;
	}


    public function findByUid($identifier){
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(FALSE);
        $query->getQuerySettings()->setRespectSysLanguage(FALSE);
        $query->getQuerySettings()->getReturnRawQueryResult(FALSE);
        $statement = 'SELECT * from tx_bjrlend_domain_model_order WHERE uid=' . $identifier . ' AND deleted != 1 AND hidden != 1 ';
        $query->statement($statement);
        $result = $query->execute()->getFirst();
        //$object = $query->matching($query->equals('uid', $identifier))->execute()->toArray(); //->getFirst();
        return array($statement, $result);
    }

}
?>