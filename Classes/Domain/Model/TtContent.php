<?php
declare(strict_types=1);

namespace Cpsit\CpsAuthor\Domain\Model;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;


/**
 * Model of tt_content
 */
class TtContent extends AbstractEntity
{
    public const TABLE = 'tt_content';

    protected int $colPos = 0;
    protected string $CType = '';

    /**
     * @return int
     */
    public function getColPos(): int
    {
        return $this->colPos;
    }

    /**
     * @param int $colPos
     */
    public function setColPos(int $colPos): void
    {
        $this->colPos = $colPos;
    }

    /**
     * @return string
     */
    public function getCType(): string
    {
        return $this->CType;
    }

    /**
     * @param string $CType
     */
    public function setCType(string $CType): void
    {
        $this->CType = $CType;
    }
}

