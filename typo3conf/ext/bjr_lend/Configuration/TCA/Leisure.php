<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_bjrlend_domain_model_leisure'] = array(
	'ctrl' => $TCA['tx_bjrlend_domain_model_leisure']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, short_description, description, lend_conditions, fee, booking_online, booking_phone, phone, by_email, email, image, show_calendar, category, organization, reservations, crdate',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, short_description, description, lend_conditions, fee, booking_online, booking_phone, phone, by_email, email, image, show_calendar, category, organization,--div--;LLL:EXT:bjr_lend/Resources/Private/Language/locallang.xlf:tx_bjrlend_domain_model_article.tab_reservations,reservations,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime, crdate'),
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
				'foreign_table' => 'tx_bjrlend_domain_model_article',
				'foreign_table_where' => 'AND tx_bjrlend_domain_model_article.pid=###CURRENT_PID### AND tx_bjrlend_domain_model_article.sys_language_uid IN (-1,0)',
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
        'crdate' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.releasedate',
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
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'short_description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.short_description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.description',
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
		'price' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.price',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		/* Leistungsbeschreibung */
		'service_specification' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.service_specification',
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
		'minimum_participants' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.minimum_participants',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'trim'
			),
		),
		'partner' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.partner',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'cooperation' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.cooperation',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),

		'image' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                array('maxitems' => 1),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
		),
		'location' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.location',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'time_period' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.time_period',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'leader' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.leader',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'referent' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.referent',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'target_group' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.target_group',
			'config' => array(
				'type'	=> 'inline',
				'foreign_table' => 'tx_bjrlend_domain_model_target_group',
				'foreign_field' => 'leisure',
				'maxitems'      => '9999',
				'appearance' => array(
					'collapseAll' => 1,
					'expandSingle' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'category' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.category',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_bjrlend_domain_model_category',
				'foreign_field' => 'leisure',
				'minitems' => 0,
				'maxitems' => 99,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),

				),
			),
		),
		'files' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_leisure.image',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'files',
				array('maxitems' => 3),
				$GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
			),
		),
		'organization' => array(
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_organization',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_bjrlend_domain_model_organization',
				'minitems' => 0,
				'maxitems' => 1,
				'size'		=> 5,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),

				),
			),
		),
		'lend_dates' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_lend_dates',
			'config' => array(
				'type'	=> 'inline',
				'foreign_table' => 'tx_bjrlend_domain_model_lenddates',
				'foreign_field' => 'leisure',
				'maxitems'      => '9999',
				'appearance' => array(
					'collapseAll' => 1,
					'expandSingle' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'country' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_country',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_bjrlend_domain_model_country',
				'minitems' => 0,
				'maxitems' => 1,
				'size'		=> 5,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
					),

				),
			),
		),

	),
);

?>