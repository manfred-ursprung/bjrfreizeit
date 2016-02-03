<?php
namespace Bjr\BjrFeadmin\Controller;

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
 * @package bjr_feadmin
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class OrderController extends AbstractController {

	/**
	 * orderRepository
	 *
	 * @var \Bjr\BjrLend\Domain\Repository\OrderRepository
	 * @inject
	 */
	protected $orderRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$orders = $this->orderRepository->findAll();
		$this->view->assign('orders', $orders);
	}

	/**
	 * action edit
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Order $order
	 * @return void
	 */
	public function editAction(\Bjr\BjrLend\Domain\Model\Order $order) {
		$this->view->assign('order', $order);
	}

}
?>