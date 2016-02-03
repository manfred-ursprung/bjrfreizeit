<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'MUM.' . $_EXTKEY,
	'Display',
	'Freizeiten Listen'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_display';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_display.xml');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Freizeiten anzeigen');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrfreizeit_domain_model_targetgroup', 'EXT:bjr_freizeit/Resources/Private/Language/locallang_csh_tx_bjrfreizeit_domain_model_targetgroup.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrfreizeit_domain_model_targetgroup');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrfreizeit_domain_model_country', 'EXT:bjr_freizeit/Resources/Private/Language/locallang_csh_tx_bjrfreizeit_domain_model_country.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrfreizeit_domain_model_country');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrfreizeit_domain_model_organization', 'EXT:bjr_freizeit/Resources/Private/Language/locallang_csh_tx_bjrfreizeit_domain_model_organization.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrfreizeit_domain_model_organization');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrfreizeit_domain_model_tags', 'EXT:bjr_freizeit/Resources/Private/Language/locallang_csh_tx_bjrfreizeit_domain_model_tags.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrfreizeit_domain_model_tags');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrfreizeit_domain_model_leisure', 'EXT:bjr_freizeit/Resources/Private/Language/locallang_csh_tx_bjrfreizeit_domain_model_leisure.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrfreizeit_domain_model_leisure');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrfreizeit_domain_model_holiday', 'EXT:bjr_freizeit/Resources/Private/Language/locallang_csh_tx_bjrfreizeit_domain_model_holiday.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrfreizeit_domain_model_holiday');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrfreizeit_domain_model_address', 'EXT:bjr_freizeit/Resources/Private/Language/locallang_csh_tx_bjrfreizeit_domain_model_address.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrfreizeit_domain_model_address');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_bjrfreizeit_domain_model_contact', 'EXT:bjr_freizeit/Resources/Private/Language/locallang_csh_tx_bjrfreizeit_domain_model_contact.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_bjrfreizeit_domain_model_contact');
