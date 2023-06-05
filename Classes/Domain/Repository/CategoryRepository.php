<?php
declare(strict_types=1);

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\CpsAuthor\Domain\Repository;


use Cpsit\CpsAuthor\Domain\Model\Dto\CategoryDemand;
use Cpsit\CpsAuthor\Domain\Model\Dto\DemandInterface;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class CategoryRepository extends Repository
{
    use Orderings;

    /**
     * @param DemandInterface $demand
     * @return QueryResultInterface
     * @throws InvalidQueryException
     */
    public function findDemanded(DemandInterface $demand): QueryResultInterface
    {
        /** @var Query $query */
        $query = $this->createQuery();

        if ($demand instanceof CategoryDemand) {
            $this->applyConstraints($query, $demand);
            $this->applyOrderings($query, $demand);
        }

        return $query->execute();
    }

    /**
     * @param QueryInterface $query
     * @param CategoryDemand $demand
     * @throws InvalidQueryException
     */
    protected function applyConstraints(QueryInterface $query, DemandInterface $demand): void
    {
        $constraints = [];

        if (!empty($pages = $demand->getPageIds())) {
            $querySettings = new Typo3QuerySettings();
            $querySettings->setRespectStoragePage(true)
                ->setStoragePageIds($pages);
            $query->setQuerySettings($querySettings);
        }

        if (!empty($demand->getExcludedCategoryIds())) {
            $constraints[] = $query->logicalNot(
                $query->in(
                    'uid',
                    $demand->getExcludedCategoryIds()
                )
            );
        }

        if (!empty($constraints)) {
            $query->matching(
                $query->logicalAnd($constraints)
            );
        }
    }

}
