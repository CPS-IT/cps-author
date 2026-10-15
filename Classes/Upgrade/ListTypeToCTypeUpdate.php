<?php

declare(strict_types=1);

namespace Cpsit\CpsAuthor\Upgrade;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use TYPO3\CMS\Install\Attribute\UpgradeWizard;
use TYPO3\CMS\Install\Updates\AbstractListTypeToCTypeUpdate;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;

#[UpgradeWizard('cpsAuthor_listTypeToCType')]
final class ListTypeToCTypeUpdate extends AbstractListTypeToCTypeUpdate
{
    public function getTitle(): string
    {
        return 'Migrate cps_author plugins from list_type to CType';
    }

    public function getDescription(): string
    {
        return 'Migrates the content records of the cps_author plugins (cpsauthor_list, cpsauthor_show, '
            . 'cpsauthor_filter, cpsauthor_app) and the backend user group permissions from "list_type" to "CType". '
            . 'Backend groups in the legacy permission format are migrated first by the prerequisite '
            . '(console: typo3 upgrade:run). The Install Tool does not run prerequisites: '
            . 'run the core wizard "BackendGroupsExplicitAllowDenyMigration" before this wizard there.';
    }

    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
            BackendGroupsMigratedPrerequisite::class,
        ];
    }

    protected function getListTypeToCTypeMapping(): array
    {
        return [
            'cpsauthor_list' => 'cpsauthor_list',
            'cpsauthor_show' => 'cpsauthor_show',
            'cpsauthor_filter' => 'cpsauthor_filter',
            'cpsauthor_app' => 'cpsauthor_app',
        ];
    }
}
