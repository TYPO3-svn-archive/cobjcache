<?php

########################################################################
# Extension Manager/Repository config file for ext "cobjcache".
#
# Auto generated 20-02-2012 23:10
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'cObject cache',
	'description' => 'Per cObject caching.',
	'category' => 'fe',
	'shy' => 0,
	'version' => '0.0.1',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Fabrizio Branca',
	'author_email' => 'typo3@fabrizio-branca.de',
	'author_company' => 'AOE media GmbH',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.5.0-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'_md5_values_when_last_written' => 'a:2:{s:22:"class.tx_cobjcache.php";s:4:"cb29";s:17:"ext_localconf.php";s:4:"1457";}',
);

?>