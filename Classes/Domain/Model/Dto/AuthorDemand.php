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
 * Author demand object
 */
class AuthorDemand implements DemandInterface
{
    public const DEFAULT_LIMIT = 0;

    /**
     * Page Ids to search for
     * @var int[]
     */
    protected array $pageIds = [];

    /**
     * Author Ids to search for
     * @var int[]
     */
    protected array $authorIds = [];

    /**
     * Author Types
     * @var int[]
     */
    protected array $types = [];

    /**
     * @var bool
     */
    protected bool $noProfile = false;

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
     * @return AuthorDemand
     */
    public function setLimit(int $limit): AuthorDemand
    {
        $this->limit = $limit;
        return $this;
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
     * @return AuthorDemand
     */
    public function setPageIds(array $pages): AuthorDemand
    {
        $this->pageIds = $pages;
        return $this;
    }

    /**
     * @return int[]
     */
    public function getAuthorIds(): array
    {
        return $this->authorIds;
    }

    /**
     * @param int[] $authorIds
     */
    public function setAuthorIds(array $authorIds): AuthorDemand
    {
        $this->authorIds = $authorIds;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNoProfile(): bool
    {
        return $this->noProfile;
    }

    /**
     * @return bool
     */
    public function getNoProfile(): bool
    {
        return $this->noProfile;
    }

    /**
     * @param bool $noProfile
     */
    public function setNoProfile(bool $noProfile): void
    {
        $this->noProfile = $noProfile;
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
     * @return int[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @param int[] $types
     */
    public function setTypes(array $types): void
    {
        $this->types = $types;
    }
}
