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

use Cpsit\CpsUtility\Utility\PageUtility;
use Cpsit\CpsAuthor\Domain\Model\Dto\AuthorDemand;
use Cpsit\CpsAuthor\Domain\Model\Dto\CategoryDemand;
use Cpsit\CpsAuthor\Domain\Model\Dto\DemandInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CategoryDemandFactory
{
    protected DemandInterface $demand;
    protected array $settings = [];

    public function __construct()
    {
        $this->demand = GeneralUtility::makeInstance(CategoryDemand::class);
    }

    public function create(array $settings = []): DemandInterface
    {
        if (empty($settings)) {
            return $this->demand;
        }

        $this->demand->setPageIds($this->resolveStoragePage($settings));

        if (!empty($settings['categorySorting'])) {
            $this->demand->setSorting($settings['categorySorting']);
        }

        if (!empty($settings['excludedCategoryIds'])) {
            $excludedCategoryIds = GeneralUtility::trimExplode(',', $settings['excludedCategoryIds'], true);
            $this->demand->setExcludedCategoryIds($excludedCategoryIds);
        }

        return $this->demand;
    }

    /**
     * Get records storage pages array
     *
     * @return array|int[]
     */
    protected function resolveStoragePage($settings): array
    {
        /** @var PageUtility $pageUtility */
        $pageUtility = GeneralUtility::makeInstance(PageUtility::class);
        $recursive = (int)$settings['categoryRecursive'] ?? 0;
        return $pageUtility->resolveStoragePages($settings['categoryListPid'], $recursive);
    }
}
