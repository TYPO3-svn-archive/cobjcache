<?php

if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}


if (TYPO3_MODE == 'FE') {

	$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_content.php']['stdWrap'][] = 'EXT:cobjcache/class.tx_cobjcache.php:tx_cobjcache';
}

?>