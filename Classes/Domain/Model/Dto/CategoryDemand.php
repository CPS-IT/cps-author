<?php

namespace Cpsit\CpsAuthor\Domain\Model\Dto;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

/**
 * Category demand object
 */
class CategoryDemand implements DemandInterface
{
    public const DEFAULT_LIMIT = 0;

    /**
     * Page Ids to search for
     * @var int[]
     */
    protected array $pageIds = [];

    /**
     * Category Ids to search for
     * @var int[]
     */
    protected array $categoryIds = [];

    /**
     * Category Ids to search for
     * @var int[]
     */
    protected array $excludedCategoryIds = [];

    /**
     * @var int
     */
    protected int $limit = self::DEFAULT_LIMIT;

    /**
     * @var string
     */
    protected string $sorting = '';

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return int[]
     */
    public function getPageIds(): array
    {
        return $this->pageIds;
    }

    /**
     * @param int[] $pages
     */
    public function setPageIds(array $pages): void
    {
        $this->pageIds = $pages;
    }

    /**
     * @return int[]
     */
    public function getCategoryIds(): array
    {
        return $this->categoryIds;
    }

    /**
     * @param int[] $categoryIds
     */
    public function setCategoryIds(array $categoryIds): void
    {
        $this->categoryIds = $categoryIds;
    }

    /**
     * @return string
     */
    public function getSorting(): string
    {
        return $this->sorting;
    }

    /**
     * @param string $sorting
     */
    public function setSorting(string $sorting): void
    {
        $this->sorting = $sorting;
    }

    /**
     * @return array
     */
    public function getExcludedCategoryIds(): array
    {
        return $this->excludedCategoryIds;
    }

    /**
     * @param array $excludedCategoryIds
     */
    public function setExcludedCategoryIds(array $excludedCategoryIds): void
    {
        $this->excludedCategoryIds = $excludedCategoryIds;
    }
}
