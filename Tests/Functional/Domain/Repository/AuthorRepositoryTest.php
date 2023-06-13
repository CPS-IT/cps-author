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
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

class AuthorRepositoryTest extends FunctionalTestCase
{
    /**
     * @var AuthorRepository|MockObject
     */
    protected $subject;

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    protected $testExtensionsToLoad = ['typo3conf/ext/cps_author'];

    /**
     * @var QueryInterface|MockObject
     */
    protected $query;

    /**
     * @var QueryResultInterface|MockObject
     */
    protected $result;

    public function setUp(): void
    {
        parent::setUp();
        /** @var ObjectManager|ObjectManagerInterface $objectManager */
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->subject = $this->objectManager->get(AuthorRepository::class);

        $fixturePath = ORIGINAL_ROOT . 'typo3conf/ext/cps_author/Tests/Functional/Fixtures/Database/';
        $this->importDataSet($fixturePath . 'tx_cpsauthor_domain_model_author.xml');
    }

    public function testFindAll(): void
    {
        $result = $this->subject->findAll();
        self::assertEmpty($result);
    }

    public function testFindDemandedFindsAuthorsBySinglePageId(): void
    {
        $pages = [1];
        $demand = new AuthorDemand();
        $demand->setPageIds($pages);
        $result = $this->subject->findDemanded($demand);
        self::assertCount(
            1,
            $result->toArray()
        );
    }

    public function testFindDemandedFindsAuthorsByPageIds(): void
    {
        $pages = [1,3];
        $demand = new AuthorDemand();
        $demand->setPageIds($pages);
        $result = $this->subject->findDemanded($demand);
        self::assertCount(
            2,
            $result
        );
    }

}
