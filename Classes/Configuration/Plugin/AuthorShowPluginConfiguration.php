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
use DWenzel\T3extensionTools\Configuration\PluginRegistrationInterface;
use DWenzel\T3extensionTools\Configuration\PluginRegistrationTrait;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

/**
 * Class AuthorShowPluginConfiguration
 * Provides configuration for the Author
 * Plugin signature: cpsauthor_show
 */
#[AutoconfigureTag('t3extensionTools.pluginConfiguration')]
#[AutoconfigureTag('t3extensionTools.pluginRegistration')]
class AuthorShowPluginConfiguration implements PluginConfigurationInterface, PluginRegistrationInterface
{
    use PluginConfigurationTrait;
    use PluginRegistrationTrait;

    protected string $extensionName = SI::KEY;
    protected string $pluginName = 'Show';
    protected string $pluginTitle = 'LLL:EXT:cps_author/Resources/Private/Language/locallang_be.xlf:plugin.author.show.title';
    protected string $pluginDescription = 'Plugin for the newsletter registration form';
    protected string $pluginGroup = 'plugins';
    protected string $pluginType = ExtensionUtility::PLUGIN_TYPE_PLUGIN;
    protected string $pluginIcon = SI::ICON_AUTHOR;
    protected string $flexForm = '';
    protected array $controllerActions = [
        AuthorController::class => 'show'
    ];
    protected array $nonCacheableControllerActions = [];
}
