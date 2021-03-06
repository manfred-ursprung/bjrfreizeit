<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:bjr_freizeit/Resources/Private/Language/locallang_db.xlf:tx_bjrfreizeit_domain_model_organization',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'name,url,address,contact,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('bjr_freizeit') . 'Resources/Public/Icons/tx_bjrfreizeit_domain_model_organization.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, url, address, contact, feusername, leisure_folder_pid, online_administration',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name, url, address, contact, online_administration, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime, feusername, leisure_folder_pid'),
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
				'renderType' => 'selectSingle',
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
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_bjrfreizeit_domain_model_organization',
				'foreign_table_where' => 'AND tx_bjrfreizeit_domain_model_organization.pid=###CURRENT_PID### AND tx_bjrfreizeit_domain_model_organization.sys_language_uid IN (-1,0)',
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

		'name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bjr_freizeit/Resources/Private/Language/locallang_db.xlf:tx_bjrfreizeit_domain_model_organization.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'url' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bjr_freizeit/Resources/Private/Language/locallang_db.xlf:tx_bjrfreizeit_domain_model_organization.url',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'address' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bjr_freizeit/Resources/Private/Language/locallang_db.xlf:tx_bjrfreizeit_domain_model_organization.address',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_bjrfreizeit_domain_model_address',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'contact' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:bjr_freizeit/Resources/Private/Language/locallang_db.xlf:tx_bjrfreizeit_domain_model_organization.contact',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_bjrfreizeit_domain_model_contact',
				'minitems' => 0,
				'maxitems' => 1,
				'appearance' => array(
					'collapseAll' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'feusername' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_freizeit/Resources/Private/Language/locallang_db.xlf:tx_bjrfreizeit_domain_model_organization.feusername',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
				'foreign_table_where' => 'AND fe_users.usergroup=2',
				'size' => 3,
				'autoMaxSize' => 10,
				'maxitems' => 9999,
				'multiple' => 0,
			),
		),
		'leisure_folder_pid' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_freizeit/Resources/Private/Language/locallang_db.xlf:tx_bjrfreizeit_domain_model_organization.leisure_folder_pid',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'wizards' => array(
					'_PADDING' => 2,
					'link' => array(
						'type' => 'popup',
						'title' => 'Link',
						'icon' => 'EXT:example/Resources/Public/Images/FormFieldWizard/wizard_link.gif',
						'module' => array(
							'name' => 'wizard_element_browser',
							'urlParameters' => array(
								'mode' => 'wizard'
							) ,
						) ,
						'JSopenParams' => 'height=600,width=500,status=0,menubar=0,scrollbars=1'
					)
				),
			),

		),
		'online_administration' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_freizeit/Resources/Private/Language/locallang_db.xlf:tx_bjrfreizeit_domain_model_organization.online_administration',
			'config' => array(
				'type' => 'check',
			),
		),

	),
);