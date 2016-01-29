<?php
namespace MUM\BjrFreizeit\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Manfred Ursprung <manfred@manfred-ursprung.de>, Webapplikationen Ursprung
 *  			
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class MUM\BjrFreizeit\Controller\LeisureController.
 *
 * @author Manfred Ursprung <manfred@manfred-ursprung.de>
 */
class LeisureControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \MUM\BjrFreizeit\Controller\LeisureController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('MUM\\BjrFreizeit\\Controller\\LeisureController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllLeisuresFromRepositoryAndAssignsThemToView()
	{

		$allLeisures = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$leisureRepository = $this->getMock('MUM\\BjrFreizeit\\Domain\\Repository\\LeisureRepository', array('findAll'), array(), '', FALSE);
		$leisureRepository->expects($this->once())->method('findAll')->will($this->returnValue($allLeisures));
		$this->inject($this->subject, 'leisureRepository', $leisureRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('leisures', $allLeisures);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenLeisureToView()
	{
		$leisure = new \MUM\BjrFreizeit\Domain\Model\Leisure();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('leisure', $leisure);

		$this->subject->showAction($leisure);
	}
}
