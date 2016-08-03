<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_bjrlend_domain_model_orderposition'] = array(
	'ctrl' => $TCA['tx_bjrlend_domain_model_orderposition']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, article_title, issue_start, issue_end, article_fee, lend_conditions, organization_name, organization_street, organization_zip, organization_city, organization_phone, organization_email, article',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, article_title, issue_start, issue_end, article_fee, lend_conditions, organization_name, organization_street, organization_zip, organization_city, organization_phone, organization_email, article,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_bjrlend_domain_model_orderposition',
				'foreign_table_where' => 'AND tx_bjrlend_domain_model_orderposition.pid=###CURRENT_PID### AND tx_bjrlend_domain_model_orderposition.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'article_title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_orderposition.article_title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'article_fee' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_orderposition.article_fee',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'lend_conditions' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_orderposition.lend_conditions',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim',
				'wizards' => array(
					'RTE' => array(
						'icon' => 'wizard_rte2.gif',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'script' => 'wizard_rte.php',
						'title' => 'LLL:EXT:cms/locallang_ttc.xlf:bodytext.W.RTE',
						'type' => 'script'
					)
				)
			),
			'defaultExtras' => 'richtext:rte_transform[flag=rte_enabled|mode=ts]',
		),
		'organization_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_orderposition.organization_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'organization_street' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_orderposition.organization_street',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'organization_zip' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_orderposition.organization_zip',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'organization_city' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_orderposition.organization_city',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'organization_phone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_orderposition.organization_phone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'organization_email' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_orderposition.organization_email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'article' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_orderposition.article',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_bjrlend_domain_model_article',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'order_parent' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'issue_start' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_orderposition.issue_start',
			'config' => array(
				'type' => 'input',
				'size' => 15,
				'eval' => 'trim,date'
			),
		),
		'issue_end' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_orderposition.issue_end',
			'config' => array(
				'type' => 'input',
				'size' => 15,
				'eval' => 'trim,date'
			),
		),

	),
);

?>