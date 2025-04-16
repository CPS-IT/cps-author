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
use Cpsit\CpsAuthor\Configuration\SettingsInterface as SI;
use Cpsit\CpsAuthor\Controller\AuthorController;
use DWenzel\T3extensionTools\Configuration\PluginConfigurationTrait;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

/**
 * Class AuthorListPluginConfiguration
 * Provides configuration for the Author
 */
#[AutoconfigureTag('t3extensionTools.pluginConfiguration')]
class AuthorListPluginConfiguration implements PluginConfigurationInterface
{
    use PluginConfigurationTrait;

    protected string $extensionName = SI::KEY;
    protected string $pluginName = 'List';
    protected string $pluginSignature = 'cpsauthor_list';
    protected string $pluginTitle = 'LLL:EXT:cps_author/Resources/Private/Language/locallang_be.xlf:plugin.author.list.title';
    protected string $pluginType = ExtensionUtility::PLUGIN_TYPE_PLUGIN;
    protected string $flexForm = 'FILE:EXT:cps_author/Configuration/FlexForms/AuthorListPlugin.xml';
    protected array $controllerActions = [
        AuthorController::class => 'list'
    ];
    protected array $nonCacheableControllerActions = [];
}
