<?php

declare(strict_types=1);
/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\CpsAuthor\Domain\Model\Dto\Factory;

use Cpsit\CpsAuthor\Domain\Model\Dto\CategoryDemand;
use Cpsit\CpsUtility\Utility\PageUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CategoryDemandFactory
{
    protected CategoryDemand $demand;

    public function __construct()
    {
        $this->demand = GeneralUtility::makeInstance(CategoryDemand::class);
    }

    /**
     * @param array<string, mixed> $settings
     */
    public function create(array $settings = []): CategoryDemand
    {
        if (empty($settings)) {
            return $this->demand;
        }

        $this->demand->setPageIds($this->resolveStoragePage($settings));

        if (!empty($settings['categorySorting'])) {
            $this->demand->setSorting($settings['categorySorting']);
        }

        if (!empty($settings['excludedCategoryIds'])) {
            $excludedCategoryIds = GeneralUtility::intExplode(',', $settings['excludedCategoryIds'], true);
            $this->demand->setExcludedCategoryIds($excludedCategoryIds);
        }

        return $this->demand;
    }

    /**
     * Get records storage pages array
     *
     * @param array<string, mixed> $settings
     * @return int[]
     */
    protected function resolveStoragePage(array $settings): array
    {
        /** @var PageUtility $pageUtility */
        $pageUtility = GeneralUtility::makeInstance(PageUtility::class);
        $recursive = (int)($settings['categoryRecursive'] ?? 0);
        return $pageUtility->resolveStoragePages($settings['categoryListPid'], $recursive);
    }
}
