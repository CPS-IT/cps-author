<?php

declare(strict_types=1);

namespace Cpsit\CpsAuthor\Tests\Functional\Configuration;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use PHPUnit\Framework\Attributes\DataProvider;
use TYPO3\CMS\Core\Configuration\FlexForm\FlexFormTools;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class PluginRegistrationTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['cpsit/cps-author'];

    /**
     * @return array<string, array{string}>
     */
    public static function selectablePluginProvider(): array
    {
        return [
            'app' => ['cpsauthor_app'],
            'show' => ['cpsauthor_show'],
            'list' => ['cpsauthor_list'],
        ];
    }

    /**
     * @return array<string, array{string}>
     */
    public static function configuredPluginProvider(): array
    {
        return [
            'app' => ['App'],
            'show' => ['Show'],
            'list' => ['List'],
            'filter' => ['Filter'],
        ];
    }

    #[DataProvider('selectablePluginProvider')]
    public function testPluginIsSelectableContentType(string $signature): void
    {
        $item = $this->findCTypeItem($signature);

        self::assertNotNull($item);
        self::assertSame('plugins', $item['group']);
        self::assertNotEmpty($item['description']);
    }

    public function testFilterPluginIsNotSelectable(): void
    {
        self::assertNull($this->findCTypeItem('cpsauthor_filter'));
    }

    #[DataProvider('configuredPluginProvider')]
    public function testPluginIsConfiguredAsContentElement(string $pluginName): void
    {
        $plugin = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']['CpsAuthor']['plugins'][$pluginName] ?? null;

        self::assertIsArray($plugin);
        self::assertSame(ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT, $plugin['pluginType']);
        self::assertNotEmpty($plugin['controllers']);
    }

    public function testNoCpsAuthorListTypeIsRegistered(): void
    {
        $values = array_column($GLOBALS['TCA']['tt_content']['columns']['list_type']['config']['items'] ?? [], 'value');

        self::assertSame([], array_filter($values, static fn($value): bool => str_starts_with((string)$value, 'cpsauthor_')));
    }

    public function testAppAndListPluginsHaveFlexFormDataStructure(): void
    {
        $flexFormTools = $this->get(FlexFormTools::class);
        foreach (['cpsauthor_app', 'cpsauthor_list'] as $signature) {
            $identifier = $flexFormTools->getDataStructureIdentifier(
                $GLOBALS['TCA']['tt_content']['columns']['pi_flexform'],
                'tt_content',
                'pi_flexform',
                ['CType' => $signature, 'list_type' => '']
            );
            $dataStructure = $flexFormTools->parseDataStructureByIdentifier($identifier);

            self::assertNotEmpty($dataStructure['sheets'], $signature);
        }
    }

    public function testConfigurationTabLabelIsTranslatable(): void
    {
        $showItem = $GLOBALS['TCA']['tt_content']['types']['cpsauthor_app']['showitem'];

        self::assertStringContainsString(
            '--div--;LLL:EXT:cps_author/Resources/Private/Language/locallang_be.xlf:tab.configuration,pi_flexform',
            $showItem
        );
    }

    /**
     * @return array<string, array{string}>
     */
    public static function languageFileProvider(): array
    {
        return [
            'english' => ['locallang_be.xlf'],
            'german' => ['de.locallang_be.xlf'],
        ];
    }

    #[DataProvider('languageFileProvider')]
    public function testBackendLabelsOfSelectablePluginsExistInLanguageFile(string $fileName): void
    {
        $xml = simplexml_load_file(dirname(__DIR__, 3) . '/Resources/Private/Language/' . $fileName);
        self::assertInstanceOf(\SimpleXMLElement::class, $xml);
        $ids = [];
        foreach ($xml->xpath('//trans-unit') ?: [] as $unit) {
            $ids[] = (string)$unit['id'];
        }

        foreach (['app', 'show', 'list'] as $plugin) {
            self::assertContains('plugin.author.' . $plugin . '.title', $ids, $fileName);
            self::assertContains('plugin.author.' . $plugin . '.description', $ids, $fileName);
        }
        self::assertContains('tab.configuration', $ids, $fileName);
    }

    /**
     * @return array<string, mixed>|null
     */
    private function findCTypeItem(string $signature): ?array
    {
        foreach ($GLOBALS['TCA']['tt_content']['columns']['CType']['config']['items'] as $item) {
            if (($item['value'] ?? null) === $signature) {
                return $item;
            }
        }

        return null;
    }
}
