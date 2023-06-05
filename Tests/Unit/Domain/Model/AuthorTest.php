<?php
declare(strict_types=1);

namespace Cpsit\CpsAuthor\Tests\Unit\Domain\Model;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\CpsAuthor\Domain\Model\Author;
use PHPUnit\Framework\TestCase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class AuthorTest extends TestCase
{
    /**
     * @var Author
     */
    protected $subject;

    public function setUp(): void
    {
        $this->subject = new Author();
    }

    public function testGetFirstNameInitiallyReturnsEmptyString(): void
    {
        self::assertSame(
            '',
            $this->subject->getFirstName()
        );
    }

    public function testGetLastNameInitiallyReturnsEmptyString(): void
    {
        self::assertSame(
            '',
            $this->subject->getLastName()
        );
    }

    public function testTypeInitiallyReturnsOne(): void
    {
        self::assertSame(
            1,
            $this->subject->getType()
        );
    }

    public function testFirstNameCanBeSet(): void
    {
        $assertValue = 'foo';
        $this->subject->setFirstName($assertValue);
        self::assertSame(
            $assertValue,
            $this->subject->getFirstName()
        );
    }

    public function testLastNameCanBeSet(): void
    {
        $assertValue = '42';
        $this->subject->setLastName($assertValue);
        self::assertSame(
            $assertValue,
            $this->subject->getLastName()
        );
    }

    public function testTypeCanBeSet(): void
    {
        $assertValue = 2;
        $this->subject->setType($assertValue);
        self::assertSame(
            $assertValue,
            $this->subject->getType()
        );
    }

    public function testGetImagesInitiallyReturnsEmptyObjectStorage(): void
    {
        $images = $this->subject->getImages();
        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf(
            ObjectStorage::class,
            $images
        );

        self::assertEmpty($images);
    }

    public function testImagesCanBeSet(): void
    {
        $image = new FileReference();
        $storage = new ObjectStorage();
        $storage->attach($image);

        $this->subject->setImages($storage);

        self::assertSame(
            $storage,
            $this->subject->getImages()
        );
    }

    public function testImageCanBeAdded(): void
    {
        $image = new FileReference();
        $this->subject->addImage($image);
        $storage = $this->subject->getImages();

        self::assertContains(
            $image,
            $storage
        );
    }

    public function testImageCanBeRemoved(): void
    {
        $image = new FileReference();
        $storage = new ObjectStorage();
        $storage->attach($image);

        $this->subject->setImages($storage);
        $this->subject->removeImage($image);

        self::assertNotContains(
            $image,
            $this->subject->getImages()
        );
    }
}
