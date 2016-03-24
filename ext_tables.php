<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'EdRush.' . $_EXTKEY,
		'help',	 // Make module a submodule of 'help'
		'extensiondependecies',	// Submodule key
		'',						// Position
		array(
			'Default' => 'showDependencies',
			
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_extensiondependecies.xlf',
		)
	);

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Extension dependency tree');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_edrushdependencytree_domain_model_default', 'EXT:edrush_dependency_tree/Resources/Private/Language/locallang_csh_tx_edrushdependencytree_domain_model_default.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_edrushdependencytree_domain_model_default');
