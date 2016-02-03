<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "bjr_freizeit_feadmin"
 *
 *
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Frontend Administration der Freizeiten Datenbank',
	'description' => 'Bereitstellung der erforderlichen Masken, um die Freizeitdatenbank im Frontend zu administrieren',
	'category' => 'plugin',
	'author' => 'Manfred Ursprung',
	'author_email' => 'manfred@manfred-ursprung.de',
	'author_company' => 'Webapplikationen Ursprung',
	'shy' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.1.0',
	'constraints' => array(
		'depends' => array(
			'extbase' => '7.6.0-7.6.99',
			'fluid' =>  '7.6.0-7.6.99',
			'typo3' => '7.6.0-7.6.99',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
);

?>