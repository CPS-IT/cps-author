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

use Cpsit\CpsAuthor\Domain\Model\Category;
use Cpsit\CpsAuthor\Domain\Model\Enum\Location;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractDomainObject;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;
use TYPO3\CMS\Extbase\Annotation\ORM\Lazy;

class Author extends AbstractDomainObject
{
    public const TABLE_NAME = 'tx_cpsauthor_domain_model_author';
    public const FIELD_UID = 'uid';
    public const FIELD_SLUG = 'slug';
    public const FIELD_SORTING = 'sorting';
    public const FIELD_NO_PROFILE = 'no_profile';
    public const FIELD_TYPE = 'type';
    public const FIELD_CATEGORIES = 'categories';

    public const TYPE_AUTHOR = 1;
    public const TYPE_NETWORK_PARTNER = 2;
    public const TYPE_CONTACT = 3;

    protected int $type = 1;
    protected int $location = 0;
    protected int $institutionType = 0;
    protected string $slug = '';
    protected string $gender = '';
    protected string $firstName = '';
    protected string $middleName = '';
    protected string $lastName = '';
    protected string $email = '';
    protected string $phone = '';
    protected string $fax = '';
    protected string $mobile = '';
    protected string $www = '';
    protected string $company = '';
    protected string $position = '';
    protected string $description = '';
    protected string $skype = '';
    protected string $twitter = '';
    protected string $facebook = '';
    protected string $linkedin = '';
    protected string $instagram = '';
    protected bool $noProfile = false;


    //business logic values
    protected array $socialMediaLinkArray = []; //must be initialized

    /**
     * Images
     *
     * @var ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    #[Cascade(['value' => 'remove'])]
    #[Lazy]
    protected $images;

    /**
     * Categories
     *
     * @var ObjectStorage<\Cpsit\CpsAuthor\Domain\Model\Category>
     */
    #[Lazy]
    protected $categories;

    /**
     * @var ObjectStorage<\Cpsit\CpsAuthor\Domain\Model\TtContent>
     */
    #[Lazy]
    protected $contentElements;


    public function __construct()
    {
        $this->initStorageObjects();
        $this->getSocialMediaLinkArray();
    }

    /**
     * Initializes all object storage properties
     */
    protected function initStorageObjects(): void
    {
        $this->images = new ObjectStorage();
        $this->categories = new ObjectStorage();
        $this->contentElements = new ObjectStorage();
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }

    public function getIsAuthor(): bool
    {
        return $this->getType() == self::TYPE_AUTHOR;
    }

    public function getIsNetworkPartner(): bool
    {
        return $this->getType() == self::TYPE_NETWORK_PARTNER;
    }

    public function getIsContact(): bool
    {
        return $this->getType() == self::TYPE_CONTACT;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     */
    public function setMiddleName(string $middleName): void
    {
        $this->middleName = $middleName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getFax(): string
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     */
    public function setFax(string $fax): void
    {
        $this->fax = $fax;
    }

    /**
     * @return string
     */
    public function getMobile(): string
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     */
    public function setMobile(string $mobile): void
    {
        $this->mobile = $mobile;
    }

    /**
     * @return string
     */
    public function getWww(): string
    {
        return $this->www;
    }

    /**
     * @param string $www
     */
    public function setWww(string $www): void
    {
        $this->www = $www;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getSkype(): string
    {
        return $this->skype;
    }

    /**
     * @param string $skype
     */
    public function setSkype(string $skype): void
    {
        $this->skype = $skype;
    }

    /**
     * @return string
     */
    public function getTwitter(): string
    {
        return $this->twitter;
    }

    /**
     * @param string $twitter
     */
    public function setTwitter(string $twitter): void
    {
        $this->twitter = $twitter;
    }

    /**
     * @return string
     */
    public function getFacebook(): string
    {
        return $this->facebook;
    }

    /**
     * @param string $facebook
     */
    public function setFacebook(string $facebook): void
    {
        $this->facebook = $facebook;
    }

    /**
     * @return string
     */
    public function getLinkedin(): string
    {
        return $this->linkedin;
    }

    /**
     * @param string $linkedin
     */
    public function setLinkedin(string $linkedin): void
    {
        $this->linkedin = $linkedin;
    }

    /**
     * @return string
     */
    public function getInstagram(): string
    {
        return $this->instagram;
    }

    /**
     * @param string $instagram
     */
    public function setInstagram(string $instagram): void
    {
        $this->instagram = $instagram;
    }

    /**
     * @return bool
     */
    public function isNoProfile(): bool
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
     * @return null|ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    public function getImages(): ?ObjectStorage
    {
        return $this->images;
    }

    /**
     * @param ObjectStorage $images
     */
    public function setImages(ObjectStorage $images): void
    {
        $this->images = $images;
    }

    /**
     * Adds a file
     *
     * @param FileReference $image
     * @return $this
     */
    public function addImage(FileReference $image): Author
    {
        if ($this->getImages() === null) {
            $this->images = new ObjectStorage();
        }
        $this->images->attach($image);
        return $this;
    }

    /**
     * Removes a file
     *
     * @param FileReference $image
     * @return $this
     */
    public function removeImage(FileReference $image): Author
    {
        $this->images->detach($image);
        return $this;
    }

    /**
     * Get first FileReference
     *
     * @return FileReference|null
     */
    public function getFirstImage(): ?FileReference
    {
        $images = $this->getImages();
        if (!is_null($images)) {
            $images->rewind();
            return $images->current();
        } else {
            return null;
        }
    }

    /**
     * Returns an array of social media urls,
     * filtered by network partner and empty value, both then not shown.
     */
    public function getSocialMediaLinkArray(): array
    {
        $this->socialMediaLinkArray =
            array_filter(
                [
                    "extern" => $this->getWww(),
                    "email" => $this->getEmail(),
                    "linkedin" => $this->getLinkedin(),
                    "twitter" => $this->getTwitter(),
                    "facebook" => $this->getFacebook(),
                    "skype" => $this->getSkype(),
                    "instagram" => $this->getInstagram()
                ],
                static function ($b) {
                    return $b;
                } //filtering by value is set or not
            );

        return $this->socialMediaLinkArray;
    }

    public function getCategories(): ?ObjectStorage
    {
        return $this->categories;
    }

    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }

    public function addCategory(Category $category): void
    {
        $this->categories->attach($category);
    }

    public function removeCategory(Category $category): void
    {
        $this->categories->detach($category);
    }

    public function getFirstCategory(): ?Category
    {
        $categories = $this->getCategories();
        if (!is_null($categories)) {
            $categories->rewind();
            return $categories->current();
        } else {
            return null;
        }
    }

    /**
     * @return int
     */
    public function getLocation(): int
    {
        return $this->location;
    }

    /**
     * @param int $location
     */
    public function setLocation(int $location): void
    {
        try {
            $location = Location::cast($location);
        } catch (\TYPO3\CMS\Core\Type\Exception\InvalidEnumerationValueException $exception) {
            $location = Location::cast(Location::__default);
        }
        $this->location = $location->getValue();
    }

    /**
     * @return int
     */
    public function getInstitutionType(): int
    {
        return $this->institutionType;
    }

    /**
     * @param int $institutionType
     */
    public function setInstitutionType(int $institutionType): void
    {
        try {
            $institutionType = Location::cast($institutionType);
        } catch (\TYPO3\CMS\Core\Type\Exception\InvalidEnumerationValueException $exception) {
            $institutionType = Location::cast(Location::__default);
        }
        $this->institutionType = $institutionType->getValue();
    }

    /**
     * Get content elements
     *
     * @return ObjectStorage
     */
    public function getContentElements(): ObjectStorage
    {
        return $this->contentElements;
    }

    /**
     * Set content element list
     *
     * @param ObjectStorage $contentElements content elements
     */
    public function setContentElements($contentElements): void
    {
        $this->contentElements = $contentElements;
    }

    /**
     * Adds a content element to the record
     *
     * @param TtContent $contentElement
     */
    public function addContentElement(TtContent $contentElement): void
    {
        if ($this->getContentElements() === null) {
            $this->contentElements = new ObjectStorage();
        }
        $this->contentElements->attach($contentElement);
    }

    /**
     * Get id list of content elements
     *
     * @return string
     */
    public function getContentElementIdList(): string
    {
        return $this->getIdOfContentElements();
    }

    /**
     * Get translated id list of content elements
     *
     * @return string
     */
    public function getTranslatedContentElementIdList(): string
    {
        return $this->getIdOfContentElements(false);
    }

    /**
     * Collect id list
     *
     * @param bool $original
     * @return string
     */
    protected function getIdOfContentElements($original = true): string
    {
        $idList = [];
        foreach ($this->getContentElements() as $contentElement) {
            if ($contentElement->getColPos() >= 0) {
                $idList[] = $original ? $contentElement->getUid() : $contentElement->_getProperty('_localizedUid');
            }
        }
        return implode(',', $idList);
    }
}
