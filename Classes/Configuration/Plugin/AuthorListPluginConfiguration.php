<?php

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
 * Class AuthorListPluginConfiguration
 * Provides configuration for the Author
 */
class AuthorListPluginConfiguration implements PluginConfigurationInterface
{
    use PluginConfigurationTrait;

    static protected $pluginName = 'List';
    static protected $pluginSignature = 'cpsauthor_list';
    static protected $pluginTitle = 'LLL:EXT:cps_author/Resources/Private/Language/locallang_be.xlf:plugin.author.list.title';

    static protected $flexForm = 'FILE:EXT:cps_author/Configuration/FlexForms/AuthorListPlugin.xml';
    static protected $controllerActions = [
        AuthorController::class => 'list'
    ];

    static protected $nonCacheableControllerActions = [];
    static protected $vendorExtensionName = SI::KEY;
}
