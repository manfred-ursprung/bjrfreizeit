<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Bjr.' . $_EXTKEY,
	'Pi1',
	array(
		'Article' => 'list, show, search, listNewest, listMostPopular,listRandom, searchResult, searchResultFrame',
		'Category' => 'list, show, menuTree, menuTreeTop',
		
	),
	// non-cacheable actions
	array(
		'Article' => '',

		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Bjr.' . $_EXTKEY,
	'Pi2',
	array(
		'Order' => 'list, show', 'printReservation', 'printReservationAjax',
		'Basket' => 'listShort', 'listLong', 'addArticle', 'removeArticle', 'confirmation','complete','sendMail',
		
	),
	// non-cacheable actions
	array(
		'Order' => '',
		'Basket' => '',
	)
);

// Ajax request
$TYPO3_CONF_VARS['FE']['eID_include']['bjrlend'] = 'EXT:' . $_EXTKEY . '/Classes/Ajax/AjaxDispatcher.php';

?>