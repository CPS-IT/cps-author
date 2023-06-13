<?php
declare(strict_types=1);
/*
 * This file is part of thecps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\CpsAuthor\Domain\Repository;


use Cpsit\CpsAuthor\Domain\Model\Dto\CategoryDemand;
use Cpsit\CpsAuthor\Domain\Model\Dto\DemandInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

trait Orderings
{
    /**
     * @param QueryInterface $query
     * @param CategoryDemand $demand
     * @return array
     */
    protected function applyOrderings(QueryInterface $query, DemandInterface $demand): array
    {
        $orderings = [];
        $sorting = GeneralUtility::trimExplode(',', $demand->getSorting(), true);

        if (!empty($sorting)) {
            foreach ($sorting as $orderItem) {
                [$orderField, $ascDesc] = GeneralUtility::trimExplode(' ', $orderItem, true);
                // count == 1 means that no direction is given
                if ($ascDesc) {
                    $orderings[$orderField] = ((strtolower($ascDesc) === 'desc') ?
                        QueryInterface::ORDER_DESCENDING :
                        QueryInterface::ORDER_ASCENDING);
                } else {
                    $orderings[$orderField] = QueryInterface::ORDER_ASCENDING;
                }
            }
        }

        if (!empty($orderings)) {
            $query->setOrderings($orderings);
        }

        return $orderings;
    }
}
