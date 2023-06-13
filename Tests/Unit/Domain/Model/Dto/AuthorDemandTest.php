<?php

namespace Cpsit\CpsAuthor\Tests\Unit\Domain\Model\Dto;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */
use Cpsit\CpsAuthor\Domain\Model\Dto\AuthorDemand;
use PHPUnit\Framework\TestCase;

class AuthorDemandTest extends TestCase
{

    /**
     * @var AuthorDemand
     */
    protected $subject;

    public function setUp(): void
    {
        $this->subject = new AuthorDemand();
    }

    public function testGetPagIdsInitiallyReturnsEmptyArray(): void
    {
        $expected = [];
        self::assertSame(
            $expected,
            $this->subject->getPageIds()
        );
    }

    public function testPagIdsCanBeSet(): void
    {
        $pages = [1,2];
        $this->subject->setPageIds($pages);

        self::assertSame(
            $pages,
            $this->subject->getPageIds()
        );
    }

    public function testGetLimitInitiallyReturnsDefaultLimit(): void
    {
        self::assertSame(
            AuthorDemand::DEFAULT_LIMIT,
            $this->subject->getLimit()
        );
    }

    public function testLimitCanBeSet(): void
    {
        $limit = 1000;
        $this->subject->setLimit($limit);

        self::assertSame(
            $limit,
            $this->subject->getLimit()
        );
    }
}
