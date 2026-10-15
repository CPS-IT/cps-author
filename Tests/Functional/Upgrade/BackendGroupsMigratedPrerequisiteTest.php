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

use Cpsit\CpsAuthor\Upgrade\BackendGroupsMigratedPrerequisite;
use Cpsit\CpsAuthor\Upgrade\ListTypeToCTypeUpdate;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class BackendGroupsMigratedPrerequisiteTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['cpsit/cps-author'];

    public function testWizardRequiresDatabaseAndMigratedBackendGroups(): void
    {
        $wizard = new ListTypeToCTypeUpdate(GeneralUtility::makeInstance(ConnectionPool::class));

        self::assertSame(
            [DatabaseUpdatedPrerequisite::class, BackendGroupsMigratedPrerequisite::class],
            $wizard->getPrerequisites()
        );
    }

    public function testIsFulfilledWithoutLegacyGroups(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/ListTypeToCType.csv');

        self::assertTrue((new BackendGroupsMigratedPrerequisite())->isFulfilled());
    }

    public function testEnsureMigratesLegacyGroupsSoThatPermissionsCanFollow(): void
    {
        $this->importCSVDataSet(__DIR__ . '/Fixtures/ListTypeToCTypeLegacyGroup.csv');
        $prerequisite = new BackendGroupsMigratedPrerequisite();

        self::assertFalse($prerequisite->isFulfilled());
        self::assertTrue($prerequisite->ensure());
        self::assertTrue($prerequisite->isFulfilled());

        $wizard = new ListTypeToCTypeUpdate(GeneralUtility::makeInstance(ConnectionPool::class));
        $wizard->executeUpdate();

        $permissions = $this->getConnectionPool()
            ->getConnectionForTable('be_groups')
            ->select(['uid', 'explicit_allowdeny'], 'be_groups', [], [], ['uid' => 'ASC'])
            ->fetchAllKeyValue();
        self::assertSame(
            [
                1 => 'tt_content:CType:cpsauthor_app',
                2 => 'tt_content:CType:cpsauthor_show',
            ],
            $permissions
        );
    }
}
