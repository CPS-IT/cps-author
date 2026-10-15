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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class FlexFormTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['cpsit/cps-author'];

    /**
     * @return array<string, array{string}>
     */
    public static function flexFormFileProvider(): array
    {
        return [
            'app' => ['AuthorAppPlugin.xml'],
            'list' => ['AuthorListPlugin.xml'],
        ];
    }

    #[DataProvider('flexFormFileProvider')]
    public function testDataStructureHasNoTceformsWrapper(string $file): void
    {
        $dataStructure = GeneralUtility::xml2array((string)file_get_contents(__DIR__ . '/../../../Configuration/FlexForms/' . $file));

        self::assertIsArray($dataStructure);
        self::assertNotEmpty($dataStructure['sheets']);
        self::assertFalse($this->containsKey($dataStructure, 'TCEforms'));
        foreach ($dataStructure['sheets'] as $sheet) {
            self::assertArrayHasKey('sheetTitle', $sheet['ROOT']);
        }
    }

    /**
     * @param array<mixed> $data
     */
    private function containsKey(array $data, string $key): bool
    {
        foreach ($data as $name => $value) {
            if ($name === $key || (is_array($value) && $this->containsKey($value, $key))) {
                return true;
            }
        }

        return false;
    }
}
