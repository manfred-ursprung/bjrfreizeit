<?php
/*
 * Register necessary class names with autoloader
 */
$extensionClassPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('bjr_lend') .'Classes/';
return array(
	'tx_bjrlend_utility_user_session' => $extensionClassPath . 'Utility/UserSession.php',
	'\Bjr\\\BjrLend\\Utility' => $extensionClassPath . 'Utility/UserSession.php',
	//'tx_catenotemplates_viewHelpers_catenopagebrowsingviewhelper' => $extensionClassPath . 'ViewHelpers/CatenoPageBrowsingViewHelper.php',
	//'tx_vhs_viewhelpers_assetviewhelper' => $extensionClassesPath . 'ViewHelpers/AssetViewHelper.php',
);
?>