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
class CategoryRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {


	public function getMenuTree(){
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(false);
		$query->matching($query->equals('parent', 0));
		$result = $query->execute();
		return $result;
	}

	/**
	 * @param $parentId \string
	 * @return array
	 */
	public function getSubCategories($parentId){
		/* $query = $this->createQuery();
		$query->matching($query->equals('parent', $parentId));
		$result = $query->execute();
		return $result;
		*/
        /** @var  $parent \Bjr\BjrLend\Domain\Model\Category */
        $parent = $this->findByUid($parentId);
        return $parent->getChilds()->toArray();
	}

	/**
	 * @param $categoryId  int
	 * @return int
	 * Returns number of article in category
	 */
	public function numberArticlesInCategory($categoryId){
		$number = 0;



		return $number;
	}
}
?>