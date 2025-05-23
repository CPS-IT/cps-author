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

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;


/**
 * This model represents a category (for anything).
 */
class Category extends AbstractEntity
{
    public const TABLE = 'sys_category';

    protected bool $hidden = false;

    /**
     * @var string
     */
    #[Extbase\Validate(['validator' => 'NotEmpty'])]
    protected $title = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\Category|null
     */
    #[Extbase\ORM\Lazy]
    protected $parent;

    public function getHidden(): bool
    {
        return $this->hidden;
    }

    public function setHidden(bool $hidden): void
    {
        $this->hidden = $hidden;
    }

    /**
     * Gets the title.
     *
     * @return string the title, might be empty
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title.
     *
     * @param string $title the title to set, may be empty
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * Gets the description.
     *
     * @return string the description, might be empty
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description.
     *
     * @param string $description the description to set, may be empty
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * Gets the parent category.
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\Category|null the parent category
     */
    public function getParent()
    {
        if ($this->parent instanceof LazyLoadingProxy) {
            $this->parent->_loadRealInstance();
        }
        return $this->parent;
    }

    /**
     * Sets the parent category.
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\Category $parent the parent category
     */
    public function setParent(\TYPO3\CMS\Extbase\Domain\Model\Category $parent): void
    {
        $this->parent = $parent;
    }
}

