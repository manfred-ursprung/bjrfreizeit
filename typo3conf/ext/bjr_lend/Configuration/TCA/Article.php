<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_bjrlend_domain_model_article'] = array(
	'ctrl' => $TCA['tx_bjrlend_domain_model_article']['ctrl'],
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
            'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.releasedate',
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
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'short_description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.short_description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.description',
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
		'lend_conditions' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.lend_conditions',
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
		'fee' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.fee',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'booking_online' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.booking_online',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'booking_phone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.booking_phone',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'phone' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.phone',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'by_email' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.by_email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'email' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.email',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'image' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                array('maxitems' => 1),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
		),
		'is_lend' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.is_lend',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'show_calendar' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.show_calendar',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'category' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_article.category',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_bjrlend_domain_model_category',
				'minitems' => 0,
				'maxitems' => 1,
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
/*		'lend_dates' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_lenddates',
			'config' => array(
				'type'	=> 'select',
				'foreign_table' => 'tx_bjrlend_domain_model_lenddates',
				'MM' => 'tx_bjrlend_domain_model_article_lenddates_mm',
				'maxitems'      => '9999',
				'size'			=> '5',
				'multiple' 		=> 0,
			),
		),
*/		'reservations' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:bjr_lend/Resources/Private/Language/locallang_db.xlf:tx_bjrlend_domain_model_reservation',
			'config' => array(

				'type' => 'inline',
				'foreign_table' => 'tx_bjrlend_domain_model_reservation',
				'foreign_field' => 'article',
				'maxitems'      => 9999,
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
	),
);

?>