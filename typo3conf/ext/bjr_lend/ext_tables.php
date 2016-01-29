<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'Leihartikel anzeigen'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_pi1';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_pi1.xml');

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	$_EXTKEY,
	'Pi2',
	'Reservierung der Leihartikel'
);
$pluginSignature = str_replace('_','',$_EXTKEY) . '_pi2';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_pi2.xml');



\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Ausleih Datenbank');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrlend_domain_model_article', 'EXT:bjr_lend/Resources/Private/Language/locallang_csh_tx_bjrlend_domain_model_article.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrlend_domain_model_article');
$TCA['tx_bjrlend_domain_model_article'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article',
		'label' => 'title',
		'label_userFunc' => 'EXT:bjr_lend/Configuration/TCA/Classes/Labelmanager.php:&Bjr\\BjrLend\\Configuration\\TCA\\Classes\\Labelmanager->labelForArticle',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,short_description,description,lend_conditions,fee,booking_online,booking_phone,phone,by_email,email,image,is_lend,show_calendar,category,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Article.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bjrlend_domain_model_article.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrlend_domain_model_category', 'EXT:bjr_lend/Resources/Private/Language/locallang_csh_tx_bjrlend_domain_model_category.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrlend_domain_model_category');
$TCA['tx_bjrlend_domain_model_category'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_category',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
        'adminOnly' => 1,
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,parent,childs,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Category.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bjrlend_domain_model_category.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrlend_domain_model_organization', 'EXT:bjr_lend/Resources/Private/Language/locallang_csh_tx_bjrlend_domain_model_organization.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrlend_domain_model_organization');
$TCA['tx_bjrlend_domain_model_organization'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_organization',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,lend_conditions,opening_times,address,contact,feusername, article_folder_pid, online_administration, local_only',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Organization.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bjrlend_domain_model_organization.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrlend_domain_model_contact', 'EXT:bjr_lend/Resources/Private/Language/locallang_csh_tx_bjrlend_domain_model_contact.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrlend_domain_model_contact');
$TCA['tx_bjrlend_domain_model_contact'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_contact',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,address,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Contact.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bjrlend_domain_model_contact.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrlend_domain_model_address', 'EXT:bjr_lend/Resources/Private/Language/locallang_csh_tx_bjrlend_domain_model_address.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrlend_domain_model_address');
$TCA['tx_bjrlend_domain_model_address'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_address',
		'label' => 'street',
		'label_userFunc' => 'EXT:bjr_lend/Configuration/TCA/Classes/Labelmanager.php:&Bjr\\BjrLend\\Configuration\\TCA\\Classes\\Labelmanager->labelForAddress',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'street,zip,city,phone,mobil,email,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Address.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bjrlend_domain_model_address.png'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrlend_domain_model_customer', 'EXT:bjr_lend/Resources/Private/Language/locallang_csh_tx_bjrlend_domain_model_customer.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrlend_domain_model_customer');
$TCA['tx_bjrlend_domain_model_customer'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_customer',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,address,orders,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Customer.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bjrlend_domain_model_customer.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrlend_domain_model_order', 'EXT:bjr_lend/Resources/Private/Language/locallang_csh_tx_bjrlend_domain_model_order.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrlend_domain_model_order');
$TCA['tx_bjrlend_domain_model_order'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_order',
		'label' => 'customer_name',
		'label_userFunc' => 'EXT:bjr_lend/Configuration/TCA/Classes/Labelmanager.php:&Bjr\\BjrLend\\Configuration\\TCA\\Classes\\Labelmanager->labelForOrder',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'customer_name,customer_phone,customer_email,positions,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Order.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bjrlend_domain_model_order.png'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrlend_domain_model_orderposition', 'EXT:bjr_lend/Resources/Private/Language/locallang_csh_tx_bjrlend_domain_model_orderposition.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrlend_domain_model_orderposition');
$TCA['tx_bjrlend_domain_model_orderposition'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_orderposition',
		'label' => 'article_title',
		'label_userFunc' => 'EXT:bjr_lend/Configuration/TCA/Classes/Labelmanager.php:&Bjr\\BjrLend\\Configuration\\TCA\\Classes\\Labelmanager->labelForOrderposition',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'article_title,article_fee,lend_conditions,organization_name,organization_street,organization_zip,organization_city,organization_phone,organization_email,article,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/OrderPosition.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bjrlend_domain_model_orderposition.png'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrlend_domain_model_region', 'EXT:bjr_lend/Resources/Private/Language/locallang_csh_tx_bjrlend_domain_model_region.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrlend_domain_model_region');
$TCA['tx_bjrlend_domain_model_region'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_region',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Region.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bjrlend_domain_model_region.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrlend_domain_model_lenddates', 'EXT:bjr_lend/Resources/Private/Language/locallang_csh_tx_bjrlend_domain_model_lenddates.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrlend_domain_model_lenddates');
$TCA['tx_bjrlend_domain_model_lenddates'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_lenddates',
		'label' => 'date_from',
		'label_userFunc' => 'EXT:bjr_lend/Configuration/TCA/Classes/Labelmanager.php:&Bjr\\BjrLend\\Configuration\\TCA\\Classes\\Labelmanager->labelForLendDates',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'date_from, date_to',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/LendDates.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bjrlend_domain_model_lenddates.png'
	),
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrlend_domain_model_reservation', 'EXT:bjr_lend/Resources/Private/Language/locallang_csh_tx_bjrlend_domain_model_reservation.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrlend_domain_model_reservation');
$TCA['tx_bjrlend_domain_model_reservation'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_reservation',
		'label' => 'issue_start',
		'label_userFunc' => 'EXT:bjr_lend/Configuration/TCA/Classes/Labelmanager.php:&Bjr\\BjrLend\\Configuration\\TCA\\Classes\\Labelmanager->labelForReservation',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'issue_start, issue_end, article, status',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Reservation.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bjrlend_domain_model_reservation.png'
	),
);


\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrlend_domain_model_leisure', 'EXT:bjr_lend/Resources/Private/Language/locallang_csh_tx_bjrlend_domain_model_leisure.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrlend_domain_model_leisure');
$TCA['tx_bjrlend_domain_model_leisure'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure',
		'label' => 'title',
		'label_userFunc' => 'EXT:bjr_lend/Configuration/TCA/Classes/Labelmanager.php:&Bjr\\BjrLend\\Configuration\\TCA\\Classes\\Labelmanager->labelForArticle',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,short_description,description,lend_conditions,fee,booking_online,booking_phone,phone,by_email,email,image,is_lend,show_calendar,category,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Leisure.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bjrlend_domain_model_leisure.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrlend_domain_model_country', 'EXT:bjr_lend/Resources/Private/Language/locallang_csh_tx_bjrlend_domain_model_region.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrlend_domain_model_country');
$TCA['tx_bjrlend_domain_model_country'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_country',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/Country.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_bjrlend_domain_model_country.gif'
	),
);



?>