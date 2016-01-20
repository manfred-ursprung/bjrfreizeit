<?php

/** *************************************************************
 *
 * Extbase Dispatcher for Ajax Calls TYPO3 6.1 namespaces
 *
 * IMPORTANT Use this script only in Extensions with namespaces
 *
 * Klaus Heuer <klaus.heuer@t3-developer.com>
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/** ************************************************************
 * Usage of this script:
 *
 * - Copy this script in your Extension Dir in the Folder Classes
 * - Set the Vendor and Extension Name in Line 82 + 83
 * - Include the next line in the ext_localconf.php, change the ext name!
 * - $TYPO3_CONF_VARS['FE']['eID_include']['ajaxDispatcher'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('myExtension').'Classes/EidDispatcher.php';
 *
 * Use for Ajax Calls in your jQuery Code:
 *
 *     $('.jqAjax').click(function(e)  {
 *       var uid = $(this).find('.uid').html();
 *       var storagePid = '11';
 *
 *       $.ajax({
 *           async: 'true',
 *           url: 'index.php',
 *           type: 'POST',
 *
 *           data: {
 *               eID: "ajaxDispatcher",
 *               request: {
 *                   pluginName:  'patsystem',
 *                   controller:  'Todo',
 *                   action:      'findTodoByAjax',
 *                   arguments: {
 *                       'uid': uid,
 *                       'storagePid': storagePid
 *                   }
 *               }
 *           },
 *           dataType: "json",
 *
 *           success: function(result) {
 *               console.log(result);
 *           },
 *           error: function(error) {
 *              console.log(error);
 *           }
 *       });
 *************************************************************** */


/**
 * Gets the Ajax Call Parameters
 */
$ajax = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('request');

/**
 * Set Vendor and Extension Name
 *
 * Vendor Name like your Vendor Name in namespaces
 * ExtensionName in upperCamelCase
 */
$ajax['vendor'] =  'Bjr';  //'T3Developer';
$ajax['extensionName'] = 'BjrFeadmin';  //'ProjectsAndTasks';

/**
 * @var $TSFE \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
 */
$TSFE = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController', $TYPO3_CONF_VARS, $ajax['arguments']['pageId'], 0);
if(isset($ajax['arguments']['languageId'])){
    $languageId = $ajax['arguments']['languageId'];
}else{
    $languageId = 'default;';
}
\TYPO3\CMS\Frontend\Utility\EidUtility::initLanguage($languageId);

// Get FE User Information
$TSFE->initFEuser();
// Important: no Cache for Ajax stuff
$TSFE->set_no_cache();

//$TSFE->checkAlternativCoreMethods();
$TSFE->checkAlternativeIdMethods();
//$_SERVER['QUERY_STRING'] = '42';
$TSFE->determineId();
// echo 'after determineId   TSFE->id : ' . $TSFE->id;
list($theAlias) = explode('&', \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('QUERY_STRING'));
$theAlias = trim($theAlias);
//echo 'ALIAS : ' . $theAlias;
//echo 'QueryString : ' . \TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('QUERY_STRING');
if($TSFE->id == 1){
    //$pageId = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('pageId');
    $pageId = $_REQUEST['request']['arguments']['pageId'];
    $TSFE->id = $pageId;
};
//echo 'TSFE->id : ' . $TSFE->id .' PageId: ' .$pageId;
//exit();

\TYPO3\CMS\Core\Core\Bootstrap::getInstance()->loadCachedTca();
$TSFE->initTemplate();
/* echo 'TSFE Rootline: '."\n";
var_dump( $TSFE->rootLine );
echo 'Setup: ' ."\n";
var_dump($TSFE->tmpl->setup);
echo 'TSFE->all ';
var_dump($TSFE->all);
*/

$TSFE->getConfigArray();  //wirft immer Fehler !!!!
\TYPO3\CMS\Core\Core\Bootstrap::getInstance()->loadConfigurationAndInitialize();
/*echo 'TSFE->config ';
var_dump($TSFE->config);
*/

$TSFE->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer');

$TSFE->settingLanguage();
$TSFE->settingLocale();

/**
 * Initialize Database
 */
\TYPO3\CMS\Frontend\Utility\EidUtility::connectDB();
/**
 * @var $objectManager \TYPO3\CMS\Extbase\Object\ObjectManager
 */
$objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');


/**
 * Initialize Extbase bootstap
 */
$bootstrapConf['extensionName'] = $ajax['extensionName'];
$bootstrapConf['pluginName'] = $ajax['pluginName'];

$bootstrap = new TYPO3\CMS\Extbase\Core\Bootstrap();
$bootstrap->initialize($bootstrapConf);
$bootstrap->cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tslib_cObj');

/**
 * Build the request
 */
$request = $objectManager->get('TYPO3\CMS\Extbase\Mvc\Request');

$request->setControllerVendorName($ajax['vendor']);
$request->setcontrollerExtensionName($ajax['extensionName']);
$request->setPluginName($ajax['pluginName']);
$request->setControllerName($ajax['controller']);
$request->setControllerActionName($ajax['action']);
$request->setArguments($ajax['arguments']);

$response = $objectManager->create('TYPO3\CMS\Extbase\Mvc\ResponseInterface');

$dispatcher = $objectManager->get('TYPO3\CMS\Extbase\Mvc\Dispatcher');

$dispatcher->dispatch($request, $response);

echo $response->getContent();

//save all changed objects
$persistenceManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
$persistenceManager->persistAll();

//echo 'Hallo heir der Ajax-Dispatcher';
//die();
?>