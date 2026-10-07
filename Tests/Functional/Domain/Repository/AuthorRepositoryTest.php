<?php

declare(strict_types=1);

namespace Cpsit\CpsAuthor\Tests\Functional\Domain\Repository;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\CpsAuthor\Domain\Model\Dto\AuthorDemand;
use Cpsit\CpsAuthor\Domain\Repository\AuthorRepository;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class AuthorRepositoryTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['cpsit/cps-author'];

    private AuthorRepository $subject;

    protected function setUp(): void
    {
        parent::setUp();
        $this->subject = $this->get(AuthorRepository::class);
        $this->importCSVDataSet(__DIR__ . '/../../Fixtures/Database/tx_cpsauthor_domain_model_author.csv');
    }

    public function testFindDemandedFindsAuthorsBySinglePageId(): void
    {
        $demand = new AuthorDemand();
        $demand->setPageIds([1]);

        self::assertCount(1, $this->subject->findDemanded($demand)->toArray());
    }

    public function testFindDemandedFindsAuthorsByPageIds(): void
    {
        $demand = new AuthorDemand();
        $demand->setPageIds([1, 3]);

        self::assertCount(2, $this->subject->findDemanded($demand));
    }
}
