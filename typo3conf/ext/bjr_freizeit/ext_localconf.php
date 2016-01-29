<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'MUM.' . $_EXTKEY,
	'Display',
	array(
		'Leisure' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Leisure' => '',
		
	)
);
