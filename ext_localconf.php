<?php

defined('TYPO3') or die();

use Cpsit\CpsAuthor\Configuration\Extension;
use Cpsit\CpsAuthor\Configuration\SettingsInterface as SI;
use Cpsit\CpsAuthor\Controller\AuthorController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

foreach (Extension::PLUGIN_ACTIONS as $pluginName => $action) {
    ExtensionUtility::configurePlugin(
        SI::KEY,
        $pluginName,
        [AuthorController::class => $action],
        [],
        ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
    );
}
