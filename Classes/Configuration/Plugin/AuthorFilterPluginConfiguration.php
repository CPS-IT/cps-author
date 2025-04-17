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
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

/**
 * Class AuthorFilterPluginConfiguration
 * Provides configuration for the Author
 * Plugin signature: cpsauthor_filter
 */
#[AutoconfigureTag('t3extensionTools.pluginConfiguration')]
class AuthorFilterPluginConfiguration implements PluginConfigurationInterface
{
    use PluginConfigurationTrait;

    protected string $pluginName = 'Filter';
    protected string $pluginTitle = 'LLL:EXT:cps_author/Resources/Private/Language/locallang_be.xlf:plugin.author.filter.title';
    protected string $pluginType = ExtensionUtility::PLUGIN_TYPE_PLUGIN;
    protected string $flexForm = '';
    protected array $controllerActions = [
        AuthorController::class => 'filter'
    ];
    protected array $nonCacheableControllerActions = [];
    protected string $extensionName = SI::KEY;
}
