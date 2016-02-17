<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'MUM.' . $_EXTKEY,
	'Display',
	array(
		'Leisure' => 'list, show, search, listNewest, listMostPopular,listRandom',
		
	),
	// non-cacheable actions
	array(
		'Leisure' => '',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'MUM.' . $_EXTKEY,
	'Search',
	array(
		'Search' => 'quickSearch, extendedSearch, search, searchResult',
	),
	// non-cacheable actions
	array(
		'Search' => 'quickSearch, extendedSearch, search',
	)
);

