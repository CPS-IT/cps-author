<?php

declare(strict_types=1);

namespace Cpsit\CpsAuthor\Controller;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\CpsAuthor\Configuration\SettingsInterface as SI;
use Cpsit\CpsAuthor\Domain\Model\Author;
use Cpsit\CpsAuthor\Domain\Model\Dto\AuthorDemand;
use Cpsit\CpsAuthor\Domain\Model\Dto\CategoryDemand;
use Cpsit\CpsAuthor\Domain\Model\Dto\Factory\AuthorDemandFactory;
use Cpsit\CpsAuthor\Domain\Model\Dto\Factory\CategoryDemandFactory;
use Cpsit\CpsAuthor\Domain\Model\Enum\InstitutionType;
use Cpsit\CpsAuthor\Domain\Model\Enum\Location;
use Cpsit\CpsAuthor\Domain\Repository\AuthorRepository;
use Cpsit\CpsAuthor\Domain\Repository\CategoryRepository;
use Cpsit\CpsUtility\Traits\ExtBaseTypoScriptStdWrapParserTrait;
use Cpsit\CpsUtility\Traits\FeCacheTagsTrait;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Frontend\Controller\ErrorController;
use TYPO3\CMS\Frontend\Page\PageInformation;

/**
 * Class AuthorController
 */
class AuthorController extends ActionController
{
    use ExtBaseTypoScriptStdWrapParserTrait;
    use FeCacheTagsTrait;

    public function __construct(
        protected Location $locationEnum,
        protected InstitutionType $institutionTypeEnum,
        protected AuthorRepository $authorRepository,
        protected CategoryRepository $categoryRepository
    ) {}

    /**
     * @inheritDoc
     */
    public function initializeAction(): void
    {
        if (isset($this->settings['format'])) {
            $this->request = $this->request->withFormat($this->settings['format']);
        }

        $this->addCacheTags([SI::FE_CACHE_TAG_AUTHOR]);
        $this->settings = $this->parseTypoScriptStdWrap($this->settings);
    }

    protected function prepareView(): void
    {
        $this->view->assign('contentObjectData', $this->request->getAttribute('currentContentObject')->data);
        $pageInformation = $this->request->getAttribute('frontend.page.information');
        if ($pageInformation instanceof PageInformation) {
            $this->view->assign('pageData', $pageInformation->getPageRecord());
        }
    }

    public function listAction(): ResponseInterface
    {
        $authorDemand = $this->createAuthorDemandFromSettings();
        $authors = $this->authorRepository->findDemanded($authorDemand);
        $this->prepareView();
        $this->view->assign(SI::VIEW_VAR_AUTHORS, $authors);
        return $this->htmlResponse();
    }

    public function appAction(): ResponseInterface
    {
        return $this->htmlResponse();
    }

    public function filterAction(): ResponseInterface
    {
        $categoryDemand = $this->createCategoryDemandFromSettings();
        $this->prepareView();
        $this->view->assignMultiple(
            [
                SI::VIEW_VAR_LOCATIONS => $this->locationEnum->getLocalizedConstants(false),
                SI::VIEW_VAR_INSTITUTION_TYPES => $this->institutionTypeEnum->getLocalizedConstants(false),
                SI::VIEW_VAR_CATEGORIES => $this->categoryRepository->findDemanded($categoryDemand),
            ]
        );
        return $this->htmlResponse();
    }

    public function listSelectedAction(): ResponseInterface
    {
        $authorDemand = $this->createAuthorDemandFromSettings();

        $authors = $this->authorRepository->findByUidList($authorDemand->getAuthorIds());
        $this->prepareView();
        $variables = [
            SI::VIEW_VAR_AUTHORS => $authors,
        ];

        $this->view->assignMultiple(
            $variables
        );
        return $this->htmlResponse();
    }

    /**
     * @param Author|null $author
     * @param int $currentPage
     * @throws PropagateResponseException
     * @throws InvalidQueryException
     */
    public function showAction(?Author $author = null, int $currentPage = 1): ResponseInterface
    {
        if ($author == null && (int)$this->settings['singleAuthor'] > 0) {
            $authorDemand = $this->createAuthorDemandFromSettings();
            $author = $this->authorRepository->findDemanded($authorDemand)->getFirst();
        }
        if ($author == null) {
            $message = 'No project entry found!';
            $response = GeneralUtility::makeInstance(ErrorController::class)->pageNotFoundAction(
                $this->request,
                $message
            );
            throw new PropagateResponseException($response, 1624891925);
        }
        $this->prepareView();
        $this->view->assignMultiple([
            SI::VIEW_VAR_AUTHOR => $author,
            SI::VIEW_VAR_CURRENT_PAGE => (int)$currentPage,
        ]);
        return $this->htmlResponse();

    }

    protected function createAuthorDemandFromSettings(): AuthorDemand
    {
        return GeneralUtility::makeInstance(AuthorDemandFactory::class)->create($this->settings);
    }

    protected function createCategoryDemandFromSettings(): CategoryDemand
    {
        return GeneralUtility::makeInstance(CategoryDemandFactory::class)->create($this->settings);
    }
}
