<?php
/*
 * This file is part of the gebaeudeforum-bundle project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\CpsAuthor\Configuration\Plugin;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use DWenzel\T3extensionTools\Configuration\PluginConfigurationInterface;
use DWenzel\T3extensionTools\Configuration\PluginConfigurationTrait;
use Cpsit\CpsAuthor\Configuration\SettingsInterface as SI;
use Cpsit\CpsAuthor\Controller\AuthorController;

/**
 * Class AuthorFilterPluginConfiguration
 * Provides configuration for the Author
 */
class AuthorFilterPluginConfiguration implements PluginConfigurationInterface
{
    use PluginConfigurationTrait;

    static protected $pluginName = 'Filter';
    static protected $pluginSignature = 'cpsauthor_filter';
    static protected $pluginTitle = 'LLL:EXT:cps_author/Resources/Private/Language/locallang_be.xlf:plugin.author.filter.title';

    static protected $flexForm = '';
    static protected $controllerActions = [
        AuthorController::class => 'filter'
    ];

    static protected $nonCacheableControllerActions = [];
    static protected $vendorExtensionName = SI::VENDOR_NAME . '.' . SI::KEY;
}
