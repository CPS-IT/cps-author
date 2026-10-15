<?php

namespace Cpsit\CpsAuthor\Domain\Repository;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\CpsAuthor\Domain\Model\Author;
use Cpsit\CpsAuthor\Domain\Model\Dto\AuthorDemand;
use Cpsit\CpsAuthor\Domain\Model\Dto\DemandInterface;
use Doctrine\DBAL\ArrayParameterType;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Generic\Query;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * @extends Repository<Author>
 */
class AuthorRepository extends Repository
{
    use Orderings;

    /**
     * Datamaper
     *
     * @var DataMapper
     */
    protected $dataMapper;

    protected $defaultOrderings = [
        Author::FIELD_SORTING => QueryInterface::ORDER_DESCENDING,
    ];

    public function __construct(
        DataMapper $dataMapper,
        private readonly ConnectionPool $connectionPool,
        private readonly Context $context,
        private readonly ConfigurationManagerInterface $configurationManager,
    ) {
        parent::__construct();
        $this->dataMapper = $dataMapper;
    }

    /**
     * @param DemandInterface $demand
     * @return QueryResultInterface<int, Author>
     * @throws InvalidQueryException
     */
    public function findDemanded(DemandInterface $demand): QueryResultInterface
    {
        /** @var Query<Author> $query */
        $query = $this->createQuery();

        if ($demand instanceof AuthorDemand) {
            $this->applyConstraints($query, $demand);
            $this->applyOrderings($query, $demand);
        }

        return $query->execute();
    }

    /**
     * @param QueryInterface<Author> $query
     * @throws InvalidQueryException
     */
    protected function applyConstraints(QueryInterface $query, AuthorDemand $demand): void
    {
        $constraints = [];

        if (!empty($pages = $demand->getPageIds())) {
            $querySettings = new Typo3QuerySettings($this->context, $this->configurationManager);
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
                $query->logicalAnd(...$constraints)
            );
        }
    }

    /**
     * Returns all matching records for the given list of uids and applies the uidList sorting for the result
     *
     * @param int[] $uidList
     * @return Author[]
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function findByUidList(array $uidList): array
    {
        if (empty($uidList)) {
            return [];
        }

        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->connectionPool
            ->getQueryBuilderForTable(Author::TABLE_NAME);

        $rows = $queryBuilder
            ->select('*')
            ->from(Author::TABLE_NAME)
            ->where($queryBuilder->expr()->in(Author::FIELD_UID, $queryBuilder->createNamedParameter($uidList, ArrayParameterType::INTEGER)))
            ->executeQuery()
            ->fetchAllAssociative();

        $rowsByUid = [];
        foreach ($rows as $row) {
            $rowsByUid[(int)$row[Author::FIELD_UID]] = $row;
        }

        $sortedRows = [];
        foreach (array_unique(array_map('intval', $uidList)) as $uid) {
            if (isset($rowsByUid[$uid])) {
                $sortedRows[] = $rowsByUid[$uid];
            }
        }

        return $this->dataMapper->map(Author::class, $sortedRows);
    }
}
