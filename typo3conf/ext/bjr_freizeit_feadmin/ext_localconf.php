<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'MUM.' . $_EXTKEY,
	'Organization',
	array(
		'Organization' => 'list, edit, update, successUpdate, new, create, delete',

	),
	// non-cacheable actions
	array(
		'Organization' => 'list, edit, update, successUpdate, new, create, delete',

	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'MUM.' . $_EXTKEY,
    'FrontendUser',
    array(
        'FrontendUser' => 'new, create, edit, delete, update, successUpdate',
    ),
    // non-cacheable actions
    array(
        'FrontendUser' => 'new, create, edit',
    )
);



\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'MUM.' . $_EXTKEY,
	'Leisure',
	array(
		'Leisure' => 'list, edit, update, successUpdate, new, create, organizationList, delete, showReservations, error',
		
	),
	// non-cacheable actions
	array(
		'Leisure' => 'list, edit, update, successUpdate, new, create, organizationList, delete, showReservations, error',
		
	)
);


// Ajax request
$TYPO3_CONF_VARS['FE']['eID_include']['bjrfreizeitfeadmin'] = 'EXT:' . $_EXTKEY . '/Classes/Ajax/AjaxDispatcher.php';

//Hook after Login
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['login_confirmed'][] = 'EXT:' . $_EXTKEY . '/Classes/Hook/LoginHook.php:Bjr\BjrFeadmin\Hook\LoginHook->afterLogin';
?>