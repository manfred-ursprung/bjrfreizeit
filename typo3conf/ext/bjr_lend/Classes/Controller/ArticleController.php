<?php
namespace Bjr\BjrLend\Controller;

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
class ArticleController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * articleRepository
	 *
	 * @var \Bjr\BjrLend\Domain\Repository\ArticleRepository
	 * @inject
	 */
	protected $articleRepository;

    /**
     * reservationRepository
     *
     * @var \Bjr\BjrLend\Domain\Repository\ReservationRepository
     * @inject
     */
    protected $reservationRepository;

    /**
     * @var array
     */
    protected $validationErrors;



    public function initializeAction(){
        parent::initializeAction();
        //$this->reservationRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Repository\\ReservationRepository');
        //fallback to current pid if no storagePid is defined
        if (version_compare(TYPO3_version, '6.0.0', '>=')) {
            $configuration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        } else {
            $configuration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        }
        //t3lib_utility_Debug::debugInPopUpWindow($configuration);
        if (empty($configuration['persistence']['storagePid'])) {
            $currentPid['persistence']['storagePid'] = $GLOBALS["TSFE"]->id;
            $currentPid['persistence']['storagePid'] = 41;
            $this->configurationManager->setConfiguration(array_merge($configuration, $currentPid));
            $this->storagePid = $currentPid['persistence']['storagePid'];
        }
        $this->configuration = $configuration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        //$this->response->addAdditionalHeaderData('<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAEcQo2dy8dM0fA429C0ZZIcKKyH71r2Tc&amp;sensor=false" type="text/javascript"></script>');

    }

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$args = $this->request->getArguments();
		if(isset($args['category'])){
			$articles = $this->articleRepository->findAllSorting($this->settings['sorting'], $args['category']);
		}else{
			$articles = $this->articleRepository->findAllSorting($this->settings['sorting']);
		}
		$this->view->assign('articles', $articles);
		$this->view->assign('articleImagePath', $this->settings['articleImagePath']);
		$this->view->assign('detailPage', $this->settings['detailPage']);
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listNewestAction() {
		$args = $this->request->getArguments();
		if(isset($args['cat'])){

		}else{
			$articles = $this->articleRepository->findNewestSorting($this->settings['sorting']);
		}
		$this->view->assign('articles', $articles);
		$this->view->assign('articleImagePath', $this->settings['articleImagePath']);
		$this->view->assign('detailPage', $this->settings['detailPage']);
	}


	/**
	 * action list
	 *
	 * @return void
	 */
	public function listMostPopularAction() {
		$args = $this->request->getArguments();
		if(isset($args['cat'])){

		}else{
			$articles = $this->articleRepository->findMostPopularSorting($this->settings['sorting']);
		}
		$this->view->assign('articles', $articles);
		$this->view->assign('articleImagePath', $this->settings['articleImagePath']);
		$this->view->assign('detailPage', $this->settings['detailPage']);
	}



    public function listRandomAction(){

        $args = $this->request->getArguments();
        if(isset($args['category'])){
            $articles = $this->articleRepository->findRandomSorting($this->settings['numberRandomList'], $args['category']);
        }else{
            $articles = $this->articleRepository->findRandomSorting($this->settings['numberRandomList']);
        }
        $this->view->assign('number', $this->settings['numberRandomList']);
        $this->view->assign('articles', $articles);
        $this->view->assign('articleImagePath', $this->settings['articleImagePath']);
        $this->view->assign('detailPage', $this->settings['detailPage']);

    }
	/**
	 * action show
	 *
	 * @param \Bjr\BjrLend\Domain\Model\Article $article
	 * @return void
	 */
	public function showAction(\Bjr\BjrLend\Domain\Model\Article $article) {

        //ini_set('display_errors', 1);
        $args = $this->request->getArguments();
        $basket = 'nicht initialisiert';
        if($args['bookArticle']){
            if($this->validateReservation($args, $article)){
                $basket = $this->bookArticle($article, $args);
            }else{
                $errors = $this->getValidationErrors();
                foreach($errors as $errorMessage){
                    $this->setFlashMessage(
                        $errorMessage,
                        '',
                        \TYPO3\CMS\Core\Messaging\FlashMessage::WARNING);
                }

            }
        }

        list($reservations, $reservedDates) = $this->findReservedDates($article);
        //echo "Add :" . $add;
        //exit();
		$this->view->assign('article', $article);
        $this->view->assign('reservations', $reservations);
        $this->view->assign('reservedDates', json_encode($reservedDates));
        $this->view->assign('basket', $basket);
		$this->view->assign('articleImagePath', $this->settings['articleImagePath']);
		$this->view->assign('pageId', $GLOBALS['TSFE']->id);
        $this->view->assign('args' , $args);
	}

	/**
	 * action search
	 *
	 * @return void
	 */
	public function searchAction() {
		/* @var $categoryRepository \Bjr\BjrLend\Domain\Repository\CategoryRepository */
		$categoryRepository = $this->objectManager->get('\\Bjr\\BjrLend\\Domain\\Repository\\CategoryRepository');
		$mainCategories = $categoryRepository->getMenuTree();
		$regionRepository = $this->objectManager->get('\\Bjr\\BjrLend\\Domain\\Repository\\RegionRepository');
        $organizationRepository = $this->objectManager->get('\\Bjr\\BjrLend\\Domain\\Repository\\OrganizationRepository');
		//$this->view->assign('subCategories', $categoryRepository->getSubCategories(1));
		$this->view->assign('categories', $mainCategories);
		$this->view->assign('regions', $regionRepository->findAll());
        $this->view->assign('organizations', $organizationRepository->findAll());
		$this->view->assign('pageId', $GLOBALS["TSFE"]->id);
		$this->view->assign('searchResultPid', $this->settings['searchResultPid']);
	}


	public function searchResultAction(){
		$args = $this->request->getArguments();
		$searchMatrix = array();
		if(is_array($args) &&
			(array_key_exists('simple', $args) || array_key_exists('advanced', $args)) ){
			$searchMatrix['stichwort'] = array_key_exists('stichwort', $args) ? $args['stichwort'] : '';
			if(array_key_exists('selectKat', $args) && $args['selectKat'] > 0){
				if(array_key_exists('selectSubKat', $args) && $args['selectSubKat'] > 0){
					$searchMatrix['selectSubKat'] = $args['selectSubKat'];
				}
			}
			if(array_key_exists('selectLoc', $args) && $args['selectLoc'] > 0){
				$searchMatrix['selectLoc'] = $args['selectLoc'];
			}
            if(array_key_exists('selectOrg', $args) && $args['selectOrg'] > 0){
                $searchMatrix['selectOrg'] = $args['selectOrg'];
            }

			$searchMatrix['online'] = array_key_exists('online', $args) ? $args['online'] : '';
			$searchMatrix['byPhone'] = array_key_exists('byPhone', $args) ? $args['byPhone'] : '';
            $valid = false; //prüfen, ob überhaupt irgendwas eingegeben wurde
            foreach($searchMatrix as $value){
                if(strlen($value) > 0){
                    $valid = true;
                    break;
                }
            }
            if($valid){
			    $articles = $this->articleRepository->searchFor($searchMatrix);
            }else{
                $this->setFlashMessage('Es muss wenigstens ein Suchkriterium eingegeben werden',
                    '',
                    \TYPO3\CMS\Core\Messaging\FlashMessage::INFO);
            }
		}else{
			$articles = array('test', 'in else-Zweig');
		}
		$this->view->assign('articles', $articles);
		$this->view->assign('debug', $searchMatrix);
		$this->view->assign('articleImagePath', $this->settings['articleImagePath']);
		$this->view->assign('detailPage', $this->settings['detailPage']);
	}


    public function searchResultFrameAction(){
        $args = $this->request->getArguments();
        $searchMatrix = array();

        if(is_array($args) &&
            (array_key_exists('simple', $args) || array_key_exists('advanced', $args)) ){
            $searchMatrix['stichwort'] = array_key_exists('stichwort', $args) ? $args['stichwort'] : '';

            if(array_key_exists('selectOrg', $args) && $args['selectOrg'] > 0){
                $searchMatrix['selectOrg'] = $args['selectOrg'];
            }

            $valid = false; //prüfen, ob überhaupt irgendwas eingegeben wurde
            foreach($searchMatrix as $value){
                if(strlen($value) > 0){
                    $valid = true;
                    break;
                }
            }
            if($valid){
                $articles = $this->articleRepository->searchFor($searchMatrix);
            }else{
                $this->setFlashMessage('Es muss wenigstens ein Suchkriterium eingegeben werden',
                    '',
                    \TYPO3\CMS\Core\Messaging\FlashMessage::INFO);
            }
        }else{
            $articles = array('test', 'in else-Zweig');
        }
        $this->view->assign('articles', $articles);
        $this->view->assign('debug', $searchMatrix);
        //$this->view->assign('articleImagePath', $this->settings['articleImagePath']);
        $this->view->assign('detailPage', $this->settings['detailPage']);
    }

    /**
     * @param \Bjr\BjrLend\Domain\Model\Article $article
     * @param $args
     */
    protected function bookArticle(\Bjr\BjrLend\Domain\Model\Article $article, $args){

        if(!empty($args['issueStartDay']) && !empty($args['issueEndDay'])){
            //we add on each 6 hours so we have no problems with calculation the booked calendar.
            //Because of summertime we hava otherwise a gap of 1 hour at the weekend the time is changed from summer to winter
            //$issue = array(($args['issueStartDay']+(5*60*60)), ($args['issueEndDay']+(5*60*60)));
            $issue = array(($args['issueStartDay']), ($args['issueEndDay']));
        }else{
            //fehlerfall
            throw new Exception("Keine IssueStartDay!");
        }


        //$article = $this->articleRepository->findByUid(4);
        $basketItem = \Bjr\BjrLend\Domain\Model\BasketItem::getItemFromArticle($article);
        $basketItem->setDurationOfIssue($issue);

        /* @var $basket \Bjr\BjrLend\Domain\Model\Basket */
        $basketRepository = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('Bjr\\BjrLend\\Domain\\Repository\\BasketRepository');
        $basket = $basketRepository->getBasket();

        $basket->addItem($basketItem);
        // in Session speichern
        $basket->storeInSession();

        //Flashmessage

        // eigene Message setzten, "OK" setzt hier den grauen Ausgabekasten im BE
        $this->controllerContext->getFlashMessageQueue()->enqueue(
            $this->objectManager->get(
                'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                'Der Artikel wurde dem Warenkorb hinzugefügt.',
                'Meldung',
                \TYPO3\CMS\Core\Messaging\FlashMessage::OK,
                false
            )
        );
        return $basket;
    }

    /**
     * @param $message  string
     * @param string $title
     * @param int $severity
     * @param bool $storeInSession
     */
    private function setFlashMessage($message, $title='', $severity = \TYPO3\CMS\Core\Messaging\FlashMessage::OK, $storeInSession=false ){
        $this->controllerContext->getFlashMessageQueue()->enqueue(
            $this->objectManager->get(
                'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                $message,
                $title,
                $severity,
                $storeInSession
            )
        );
    }




    protected function validateReservation($args, $article){
        $valid = true;
        $errors = array();

        list($reservations, $reservedDates) = $this->findReservedDates($article);
        if( empty($args['issueStartDay']) || empty($args['issueEndDay']) ){
            //fehlerfall
            $errors[] = "Keine vollständige Terminangabe!";
            $valid = false;
        }else {
            $issue = array(($args['issueStartDay']), ($args['issueEndDay']));
            /** @var  $validator \Bjr\BjrLend\Validation\Validator\ReservationValidator */
            $validator = $this->objectManager->create('Bjr\\BjrLend\\Validation\\Validator\\ReservationValidator', array(), $article, '%d.%m.%Y');

            $valid =  $validator->isValid($args);
            if(!$valid){
                $_errors = $validator->getErrors();
                foreach($_errors as $error){
                    $errors[] = $error->getMessage();
                }
                $this->setValidationErrors($errors);
            }
            return $valid;


        }



    }

    /**
     * @param \Bjr\BjrLend\Domain\Model\Article $article
     * @return array
     */
    private function findReservedDates(\Bjr\BjrLend\Domain\Model\Article $article)
    {
        $reservations = $this->reservationRepository->findByArticle($article);
        $reservedDates = array();
        /* @var $reservation \Bjr\BjrLend\Domain\Model\Reservation */
        foreach ($reservations as $reservation) {
            $list = $reservation->listIssueDays();
            foreach ($list as $dateTime) {
                $month = date('n', $dateTime);
                $day = date('j', $dateTime);
                $year = date('Y', $dateTime);
                $reservedDates[] = array('month' => $month,
                    'day' => $day,
                    'year' => $year);
            }
        }
        return array($reservations, $reservedDates);
    }

    /**
     * @return array
     */
    public function getValidationErrors()
    {
        return $this->validationErrors;
    }

    /**
     * @param array $validationErrors
     */
    public function setValidationErrors($validationErrors)
    {
        $this->validationErrors = $validationErrors;
    }



}
?>