<?php
declare(strict_types=1);
/*
 * This file is part of the gebaeudeforum-author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\CpsAuthor\Service;

use Cpsit\CpsAuthor\Domain\Model\Enum\InstitutionType;
use Cpsit\CpsAuthor\Domain\Model\Enum\Location;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class ItemsProcFunc
{

    public function getLocationsForTca(array &$configuration): void
    {
        $locationEnum = GeneralUtility::makeInstance(Location::class);

        foreach ($locationEnum->getLocalizedConstants(true) as $location) {
            $configuration['items'][] = [
                $location['label'],
                $location['uid']
            ];
        }
    }

    public function getInstitutionTypesForTca(array &$configuration): void
    {
        $institutionTypeEnum = GeneralUtility::makeInstance(InstitutionType::class);

        foreach ($institutionTypeEnum->getLocalizedConstants(true) as $institutionType) {
            $configuration['items'][] = [
                $institutionType['label'],
                $institutionType['uid']
            ];
        }
    }
}
