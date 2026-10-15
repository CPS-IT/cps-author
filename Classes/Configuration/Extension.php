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

use Cpsit\CpsAuthor\Configuration\SettingsInterface as SI;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Extension
 *
 * provides configuration for the extension cps_author
 */
final class Extension
{
    public const KEY = SI::KEY;

    public const PLUGIN_ACTIONS = [
        'List' => 'list',
        'Show' => 'show',
        'Filter' => 'filter',
        'App' => 'app',
    ];

    private const REGISTER_PAGE_TSCONFIG_FILES = [
        'Configuration/TSconfig/NetworkPartnerOnly.tsconfig' => 'Allow Network partner (Authors) records only on this page',
        'Configuration/TSconfig/AuthorOnly.tsconfig' => 'Allow author records only on this page',
        'Configuration/TSconfig/ContactOnly.tsconfig' => 'Allow contact records only on this page',
    ];

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
