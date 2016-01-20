<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Bjr.' . $_EXTKEY,
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
    'Bjr.' . $_EXTKEY,
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
	'Bjr.' . $_EXTKEY,
	'Region',
	array(
		'Region' => 'list, edit, update, successUpdate, new, create, delete ',
		
	),
	// non-cacheable actions
	array(
		'Region' => 'list, edit, update, successUpdate, new, create, delete',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Bjr.' . $_EXTKEY,
	'Categories',
	array(
		'Category' => 'list, edit, update, successUpdate, new, create,delete, rename',
		
	),
	// non-cacheable actions
	array(
		'Category' => 'list, edit, update, successUpdate, new, create, delete, rename',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Bjr.' . $_EXTKEY,
	'Article',
	array(
		'Article' => 'list, edit, update, successUpdate, new, create, organizationList, delete, showReservations, error',
		
	),
	// non-cacheable actions
	array(
		'Article' => 'list, edit, update, successUpdate, new, create, organizationList, delete, showReservations, error',
		
	)
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Bjr.' . $_EXTKEY,
    'Reservation',
    array(
        'Reservation' => 'list, delete, edit, update, successUpdate, new, create, showCustomer,sendMail',

    ),
    // non-cacheable actions
    array(
        'Reservation' => 'list, delete, edit, update, successUpdate, new, create, showCustomer,sendMail',

    )
);

// Ajax request
$TYPO3_CONF_VARS['FE']['eID_include']['bjrfeadmin'] = 'EXT:' . $_EXTKEY . '/Classes/Ajax/AjaxDispatcher.php';

//Hook after Login
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['login_confirmed'][] = 'EXT:' . $_EXTKEY . '/Classes/Hook/LoginHook.php:Bjr\BjrFeadmin\Hook\LoginHook->afterLogin';
?>