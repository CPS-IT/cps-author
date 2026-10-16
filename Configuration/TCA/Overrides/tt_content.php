<?php

defined('TYPO3') or die();

use Cpsit\CpsAuthor\Configuration\SettingsInterface as SI;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

$languageFile = 'LLL:EXT:cps_author/Resources/Private/Language/locallang_be.xlf:';

$plugins = [
    'App' => 'AuthorAppPlugin.xml',
    'Show' => null,
    'List' => 'AuthorListPlugin.xml',
    // Registered so migrated rows keep a valid CType; removed from the wizard in page.tsconfig
    'Filter' => null,
];

foreach ($plugins as $pluginName => $flexForm) {
    $key = strtolower($pluginName);
    $signature = ExtensionUtility::registerPlugin(
        SI::KEY,
        $pluginName,
        $languageFile . 'plugin.author.' . $key . '.title',
        SI::ICON_GEBAEUDEFORUM_AUTHOR,
        'plugins',
        $languageFile . 'plugin.author.' . $key . '.description'
    );

    if ($flexForm !== null) {
        ExtensionManagementUtility::addToAllTCAtypes('tt_content', '--div--;' . $languageFile . 'tab.configuration,pi_flexform,', $signature, 'after:subheader');
        ExtensionManagementUtility::addPiFlexFormValue('*', 'FILE:EXT:cps_author/Configuration/FlexForms/' . $flexForm, $signature);
    }
}
