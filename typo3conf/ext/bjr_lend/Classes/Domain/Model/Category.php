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
class Category extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

	/**
	 * title
	 *
	 * @var \string
	 */
	protected $title;

	/**
	 * parent
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\Category>
	 */
	protected $parent;

	/**
	 * childs
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\Category>
	 */
	protected $childs;

	/**
	 * __construct
	 *
	 * @return Category
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
		$this->parent = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		
		$this->childs = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
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
	 * Adds a Category
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Category $parent
	 * @return void
	 */
	public function addParent(\Bjr\BjrLend\Domain\Model\Category $parent) {
		$this->parent->attach($parent);
	}

	/**
	 * Removes a Category
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Category $parentToRemove The Category to be removed
	 * @return void
	 */
	public function removeParent(\Bjr\BjrLend\Domain\Model\Category $parentToRemove) {
		$this->parent->detach($parentToRemove);
	}

	/**
	 * Returns the parent
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\Category> $parent
	 */
	public function getParent() {
		return $this->parent;
	}

    /**
     * @return \Bjr\BjrLend\Domain\Model\Category
     */
    public function getFirstParent(){
        $parents = $this->parent->toArray();
        return $parents[0];
    }


    public function hasParent(){
        $parents = $this->parent->toArray();
        return count($parents) > 0;
    }

	/**
	 * Sets the parent
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\Category> $parent
	 * @return void
	 */
	public function setParent(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $parent) {
		$this->parent = $parent;
	}

	/**
	 * Adds a Category
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Category $child
	 * @return void
	 */
	public function addChild(\Bjr\BjrLend\Domain\Model\Category $child) {
		$this->childs->attach($child);
	}

	/**
	 * Removes a Category
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Category $childToRemove The Category to be removed
	 * @return void
	 */
	public function removeChild(\Bjr\BjrLend\Domain\Model\Category $childToRemove) {
		$this->childs->detach($childToRemove);
	}

	/**
	 * Returns the childs
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\Category> $childs
	 */
	public function getChilds() {
		return $this->childs;
	}

	/**
	 * Sets the childs
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Bjr\BjrLend\Domain\Model\Category> $childs
	 * @return void
	 */
	public function setChilds(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $childs) {
		$this->childs = $childs;
	}


    public function hasChildren(){
        return $this->childs->count() > 0;
    }

	/**
	 * @return int
	 *
	 */
	public function articlesInCategorySubcategory(){
		/* @var $articleRepository \Bjr\BjrLend\Domain\Repository\ArticleRepository
		   @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager
		 */
		$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$articleRepository = $objectManager->get('\\Bjr\\BjrLend\\Domain\\Repository\\ArticleRepository');
		//$articleRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Repository\\ArticleRepository');

		$number = $articleRepository->numberArticlesInCategory($this->uid);
		foreach($this->childs as $subcategory){
			$number += $articleRepository->numberArticlesInCategory($subcategory->getUid());
		}
		return $number;
	}
}
?>