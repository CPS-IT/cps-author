<?php

declare(strict_types=1);

namespace Cpsit\CpsAuthor\Tests\Functional\Upgrade;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\CpsAuthor\Upgrade\ListTypeToCTypeUpdate;
use PHPUnit\Framework\Attributes\DataProvider;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class ListTypeToCTypeUpdateTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['cpsit/cps-author'];

    private ListTypeToCTypeUpdate $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = new ListTypeToCTypeUpdate(GeneralUtility::makeInstance(ConnectionPool::class));
    }

    public function testMappingIsOneToOne(): void
    {
        $mapping = (new \ReflectionMethod($this->subject, 'getListTypeToCTypeMapping'))->invoke($this->subject);

        self::assertSame(
            [
                'cpsauthor_list' => 'cpsauthor_list',
                'cpsauthor_show' => 'cpsauthor_show',
                'cpsauthor_filter' => 'cpsauthor_filter',
                'cpsauthor_app' => 'cpsauthor_app',
            ],
            $mapping
        );
    }

    /**
     * @return array<string, array{int, string}>
     */
    public static function migratedContentProvider(): array
    {
        return [
            'app' => [1, 'cpsauthor_app'],
            'show' => [2, 'cpsauthor_show'],
            'list' => [3, 'cpsauthor_list'],
            'filter' => [4, 'cpsauthor_filter'],
        ];
    }

    #[DataProvider('migratedContentProvider')]
    public function testContentRecordsAreMigrated(int $uid, string $expectedCType): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/ListTypeToCType.csv');

        self::assertTrue($this->subject->updateNecessary());
        self::assertTrue($this->subject->executeUpdate());

        $row = $this->fetchRow('tt_content', $uid);
        self::assertSame($expectedCType, $row['CType']);
        self::assertSame('', $row['list_type']);
    }

    public function testOtherContentRecordsStayUntouched(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/ListTypeToCType.csv');

        $this->subject->executeUpdate();

        $other = $this->fetchRow('tt_content', 5);
        self::assertSame('list', $other['CType']);
        self::assertSame('other_plugin', $other['list_type']);
        self::assertSame('cpsauthor_app', $this->fetchRow('tt_content', 6)['CType']);
        self::assertSame('text', $this->fetchRow('tt_content', 7)['CType']);
    }

    public function testBackendGroupPermissionsAreMigrated(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/ListTypeToCType.csv');

        $this->subject->executeUpdate();

        $permissions = explode(',', $this->fetchRow('be_groups', 1)['explicit_allowdeny']);
        sort($permissions);
        self::assertSame(
            ['tt_content:CType:cpsauthor_app', 'tt_content:CType:text', 'tt_content:list_type:other_plugin'],
            $permissions
        );
        self::assertSame('tt_content:CType:cpsauthor_show', $this->fetchRow('be_groups', 2)['explicit_allowdeny']);
    }

    public function testSecondRunChangesNothing(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/ListTypeToCType.csv');
        $this->subject->executeUpdate();
        $contentAfterFirstRun = $this->fetchAll('tt_content');
        $groupsAfterFirstRun = $this->fetchAll('be_groups');

        self::assertFalse($this->subject->updateNecessary());
        self::assertTrue($this->subject->executeUpdate());
        self::assertSame($contentAfterFirstRun, $this->fetchAll('tt_content'));
        self::assertSame($groupsAfterFirstRun, $this->fetchAll('be_groups'));
    }

    public function testLegacyGroupFormatSkipsPermissionsButMigratesContent(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/ListTypeToCTypeLegacyGroup.csv');

        $this->subject->executeUpdate();

        self::assertSame('cpsauthor_app', $this->fetchRow('tt_content', 1)['CType']);
        self::assertSame('tt_content:list_type:cpsauthor_app:ALLOW', $this->fetchRow('be_groups', 1)['explicit_allowdeny']);
        self::assertSame('tt_content:list_type:cpsauthor_show', $this->fetchRow('be_groups', 2)['explicit_allowdeny']);
    }

    /**
     * @return array<string, mixed>
     */
    private function fetchRow(string $table, int $uid): array
    {
        $row = $this->getConnectionPool()->getConnectionForTable($table)->select(['*'], $table, ['uid' => $uid])->fetchAssociative();
        self::assertIsArray($row);

        return $row;
    }

    /**
     * @return list<array<string, mixed>>
     */
    private function fetchAll(string $table): array
    {
        return $this->getConnectionPool()->getConnectionForTable($table)->select(['*'], $table, [], [], ['uid' => 'ASC'])->fetchAllAssociative();
    }
}
