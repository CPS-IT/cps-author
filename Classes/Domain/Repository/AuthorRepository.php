<?php

namespace Cpsit\CpsAuthor\Domain\Repository;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Doctrine\DBAL\Query\QueryBuilder;
use Cpsit\CpsAuthor\Domain\Model\Dto\DemandInterface;
use Cpsit\CpsAuthor\Domain\Model\Dto\AuthorDemand;
use Cpsit\CpsAuthor\Domain\Model\Author;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class AuthorRepository extends Repository
{
    use Orderings;

    /**
     * Datamaper
     *
     * @var DataMapper
     */
    protected $dataMapper;

    /**
     * @param DataMapper $dataMapper
     */
    public function injectDataMapper(DataMapper $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    protected $defaultOrderings = [
        Author::FIELD_SORTING => QueryInterface::ORDER_DESCENDING
    ];

    /**
     * @param DemandInterface $demand
     * @return QueryResultInterface
     * @throws InvalidQueryException
     */
    public function findDemanded(DemandInterface $demand): QueryResultInterface
    {
        /** @var Query $query */
        $query = $this->createQuery();

        if ($demand instanceof AuthorDemand) {
            $this->applyConstraints($query, $demand);
            $this->applyOrderings($query, $demand);
        }

        return $query->execute();
    }

    /**
     * @param QueryInterface $query
     * @param AuthorDemand $demand
     * @throws InvalidQueryException
     */
    protected function applyConstraints(QueryInterface $query, DemandInterface $demand): void
    {
        $constraints = [];

        if (!empty($pages = $demand->getPageIds())) {
            $context = GeneralUtility::makeInstance(Context::class);
            $configurationManager = GeneralUtility::getContainer()->get(ConfigurationManager::class);

            //@todo check if GeneralUtility::makeInstance solves injection problem
            $querySettings = new Typo3QuerySettings($context, $configurationManager);
            $querySettings->setRespectStoragePage(true)
                ->setStoragePageIds($pages);
            $query->setQuerySettings($querySettings);
        }

        if ($demand->isNoProfile() === false) {
            $constraints[] = $query->equals(Author::FIELD_NO_PROFILE, 0);
        }

        if (!empty($demand->getTypes())) {
            $constraints[] = $query->in(Author::FIELD_TYPE, $demand->getTypes());
        }

        if (!empty($constraints)) {
            $query->matching(
                $query->logicalAnd($constraints)
            );
        }
    }

    /**
     * Returns all matching records for the given list of uids and applies the uidList sorting for the result
     *
     * @param int[] $uidList
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function findByUidList(array $uidList): array
    {
        if (empty($uidList)) {
            return [];
        }

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable(Author::TABLE_NAME);

        $rows = $queryBuilder
            ->select('*')
            ->from(Author::TABLE_NAME)
            ->where($queryBuilder->expr()->in(Author::FIELD_UID, $uidList))
            ->add('orderBy',
                'FIELD(' . Author::TABLE_NAME . '.' . Author::FIELD_UID . ',' . implode(',', $uidList) . ')')
            ->execute()
            ->fetchAllAssociative();

        return $this->dataMapper->map(Author::class, $rows);
    }
}
