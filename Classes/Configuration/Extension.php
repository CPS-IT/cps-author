<?php
declare(strict_types=1);

namespace Cpsit\CpsAuthor\Configuration;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use DWenzel\T3extensionTools\Configuration\ExtensionConfiguration;
use Cpsit\CpsAuthor\Configuration\Plugin\AuthorAppPluginConfiguration;
use Cpsit\CpsAuthor\Configuration\Plugin\AuthorFilterPluginConfiguration;
use Cpsit\CpsAuthor\Configuration\Plugin\AuthorListPluginConfiguration;
use Cpsit\CpsAuthor\Configuration\Plugin\AuthorShowPluginConfiguration;
use Cpsit\CpsAuthor\Domain\Model\Author;
use Cpsit\CpsAuthor\Configuration\SettingsInterface as SI;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Extension
 *
 * provides configuration for the extension cps_author
 */
final class Extension extends ExtensionConfiguration
{

    public const NAME = SI::NAME;
    public const KEY = SI::KEY;
    public const VENDOR_NAME = SI::VENDOR_NAME;

    public const TABLES_ALLOWED_ON_STANDARD_PAGES = [
        Author::TABLE_NAME
    ];

    /**
     * SVG icons to register
     */
    protected const SVG_ICONS_TO_REGISTER = [
        SI::ICON_AUTHOR => 'EXT:cps_author/Resources/Public/Icons/icon_author.svg',
        SI::ICON_NETWORK_PARTNER => 'EXT:cps_author/Resources/Public/Icons/icon_network_partner.svg',
        SI::ICON_GEBAEUDEFORUM_AUTHOR => 'EXT:cps_author/Resources/Public/Icons/icon_cps_author.svg',
        SI::ICON_CONTACT => 'EXT:cps_author/Resources/Public/Icons/icon_contact.svg',
    ];

    protected const PLUGINS_TO_REGISTER = [
        AuthorListPluginConfiguration::class,
        AuthorShowPluginConfiguration::class,
        AuthorFilterPluginConfiguration::class,
        AuthorAppPluginConfiguration::class
    ];

    /**
     * Array of strings to add as TSconfig content.
     * @var string[]
     */
    protected const ADD_PAGE_TSCONFIG = [
        "@import 'EXT:cps_author/Configuration/TSconfig/ContentElementWizard.tsconfig'"
    ];

    protected const REGISTER_PAGE_TSCONFIG_FILES = [
        'Configuration/TSconfig/NetworkPartnerOnly.tsconfig' => 'Allow Network partner (Authors) records only on this page',
        'Configuration/TSconfig/AuthorOnly.tsconfig' => 'Allow author records only on this page',
        'Configuration/TSconfig/ContactOnly.tsconfig' => 'Allow contact records only on this page',
    ];

    /**
     * Add page TSconfig content
     */
    public static function addPageTSconfig(): void
    {
        foreach (self::ADD_PAGE_TSCONFIG as $TSconfig) {
            ExtensionManagementUtility::addPageTSConfig($TSconfig);
        }
    }

    /**
     * Register TsConfig files
     */
    public static function registerPageTSConfigFiles(): void
    {
        foreach (self::REGISTER_PAGE_TSCONFIG_FILES as $TsConfigFile => $label) {
            ExtensionManagementUtility::registerPageTSConfigFile(self::KEY, $TsConfigFile, $label);
        }
    }
}
