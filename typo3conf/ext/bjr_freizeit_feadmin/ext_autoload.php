<?php
/**
 * Created by PhpStorm.
 * User: manfred
 * Date: 07.02.16
 * Time: 11:01
 */

$extensionClassesPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('bjr_freizeit_feadmin') . 'Classes/';

$default = array(
    'LoadTypoScript' => $extensionClassesPath . 'Domain/Utility/LoadTypoScript.php',

);
return $default;