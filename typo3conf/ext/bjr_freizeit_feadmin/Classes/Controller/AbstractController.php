<?php
namespace MUM\BjrFreizeitFeadmin\Controller;

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
 * @package bjr_freizeit_feadmin
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {


    /**
     * organizationRepository
     *
     * @var \MUM\BjrFreizeit\Domain\Repository\OrganizationRepository
     * @inject
     */
    protected $organizationRepository;



    /**
     * @return array
     */
    protected function getFullTypoScript()
    {
        return $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

    }

    /**
     * @param $message
     * @param string $title
     * @param int $severity
     */
    protected function setFlashMessage($message, $title = '', $severity = \TYPO3\CMS\Core\Messaging\FlashMessage::OK)
    {
        //Flashmessage
        // eigene Message setzten, "OK" setzt hier den grauen Ausgabekasten im BE
        $this->controllerContext->getFlashMessageQueue()->enqueue(
            $this->objectManager->get(
                'TYPO3\\CMS\\Core\\Messaging\\FlashMessage',
                $message,
                $title,
                $severity,
                false
            )
        );
    }


    /**
     * @return \MUM\BjrFreizeit\Domain\Model\Organization
     */
    protected function findOrganizationBySession(){
        /** @var  $organization Organization */
        $organization =  $GLOBALS['TSFE']->fe_user->getKey('ses',  'organization');
        if(is_int($organization)){
            $organization = $this->organizationRepository->findByUid($organization);
        }
        //\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($organization, 'Organization in findOrganizationBySession');
        return $organization;
    }


    protected function findOrganizationByLogin(){
        $feUserId = $GLOBALS['TSFE']->fe_user->user['uid'];
        /** @var  $organization  \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult */
        $organization = $this->organizationRepository->findByFeusername($feUserId);
        if($organization->count() > 0){
            return $organization->getFirst();
        }else{
            return null;
        }
    }


    /**
     * This creates another stand-alone instance of the Fluid view to render a template
     * @param string $templateName the name of the template to use
     * @param string $format the format of the fluid template "html" or "txt"
     * @return  \TYPO3\CMS\Fluid\View\StandaloneView the Fluid instance
     */
    protected function getPlainRenderer($templateName = 'default', $format = 'html') {
        $view = $this->objectManager->create('TYPO3\\CMS\\Fluid\\View\\StandaloneView');
        $view->setFormat($format);

        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']);
        //echo 'TemplateRootPath: ' . $templateRootPath;
        $templatePathAndFilename = $templateRootPath . $this->request->getControllerName().'/' . $templateName . '.' . $format;
        //echo 'TemplatePathAndFilename: ' . $templatePathAndFilename;
        $view->setTemplatePathAndFilename($templatePathAndFilename);
        $layoutRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['layoutRootPath']);
        $view->setLayoutRootPath($layoutRootPath);
        $partialsRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['partialRootPath']);
        $view->setPartialRootPath($partialsRootPath);
        $view->assign('settings', $this->settings);
        return $view;
    }


}
