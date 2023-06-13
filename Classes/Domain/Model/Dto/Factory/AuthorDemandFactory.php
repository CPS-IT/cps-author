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
use Cpsit\CpsAuthor\Domain\Model\Dto\DemandInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AuthorDemandFactory
{
    protected DemandInterface $demand;
    protected array $settings = [];

    public function __construct()
    {
        $this->demand = GeneralUtility::makeInstance(AuthorDemand::class);
    }

    public function create(array $settings = []): DemandInterface
    {
        if (empty($settings)) {
            return $this->demand;
        }

        $this->demand->setPageIds($this->resolveStoragePage($settings));

        if (!empty($settings['singleAuthor'])) {
            $this->demand->setAuthorIds(GeneralUtility::intExplode(',', $settings['singleAuthor']));
        }

        if (!empty($settings['listSelectedAuthors'])) {
            $this->demand->setAuthorIds(GeneralUtility::intExplode(',', $settings['listSelectedQuestions']));
        }

        if (!empty($settings['sorting'])) {
            $this->demand->setSorting($settings['sorting']);
        }

        if (!empty($settings['allowedTypes'])) {
            $this->demand->setTypes(
                GeneralUtility::intExplode(',', $settings['allowedTypes'], true)
            );
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
        $recursive = (int)$settings['recursive'] ?? 0;
        return $pageUtility->resolveStoragePages($settings['listPid'], $recursive);
    }
}
