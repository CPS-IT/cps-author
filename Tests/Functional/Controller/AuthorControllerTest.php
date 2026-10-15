<?php

declare(strict_types=1);

namespace Cpsit\CpsAuthor\Tests\Functional\Controller;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

use Cpsit\CpsAuthor\Controller\AuthorController;
use Cpsit\CpsAuthor\Domain\Model\Enum\InstitutionType;
use Cpsit\CpsAuthor\Domain\Model\Enum\Location;
use Cpsit\CpsAuthor\Domain\Repository\AuthorRepository;
use Cpsit\CpsAuthor\Domain\Repository\CategoryRepository;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Http\ServerRequest;
use TYPO3\CMS\Core\View\ViewInterface;
use TYPO3\CMS\Extbase\Mvc\ExtbaseRequestParameters;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Page\PageInformation;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

class AuthorControllerTest extends FunctionalTestCase
{
    protected array $testExtensionsToLoad = ['cpsit/cps-author'];

    public function testInitializeActionAppliesConfiguredFormatToRequest(): void
    {
        $controller = $this->createController(['format' => 'json'], 'html');

        $controller->initializeAction();

        self::assertSame('json', $this->getRequest($controller)->getFormat());
    }

    public function testInitializeActionKeepsFormatWithoutSetting(): void
    {
        $controller = $this->createController([], 'html');

        $controller->initializeAction();

        self::assertSame('html', $this->getRequest($controller)->getFormat());
    }

    public function testPrepareViewAssignsPageDataFromPageInformationAttribute(): void
    {
        $pageInformation = new PageInformation();
        $pageInformation->setPageRecord(['uid' => 42, 'title' => 'Page']);
        $controller = $this->createController([], 'html', $pageInformation);
        $view = $this->createMock(ViewInterface::class);
        $view->expects($this->exactly(2))->method('assign')->willReturnCallback(
            function (string $key, mixed $value) use (&$assigned, $view): ViewInterface {
                $assigned[$key] = $value;
                return $view;
            }
        );
        $this->setProperty($controller, 'view', $view);

        $this->callPrepareView($controller);

        self::assertSame(['uid' => 42, 'title' => 'Page'], $assigned['pageData']);
        self::assertArrayHasKey('contentObjectData', $assigned);
    }

    public function testPrepareViewSkipsPageDataWithoutPageInformationAttribute(): void
    {
        $controller = $this->createController([], 'html');
        $view = $this->createMock(ViewInterface::class);
        $view->expects($this->once())->method('assign')->with('contentObjectData', self::anything())->willReturnSelf();
        $this->setProperty($controller, 'view', $view);

        $this->callPrepareView($controller);
    }

    public function testShowActionWithoutAuthorThrowsPropagateResponseExceptionWith404(): void
    {
        $controller = $this->createController(['singleAuthor' => 0], 'html');

        try {
            $controller->showAction();
            self::fail('Expected PropagateResponseException');
        } catch (PropagateResponseException $exception) {
            self::assertSame(404, $exception->getResponse()->getStatusCode());
        }
    }

    private function callPrepareView(AuthorController $controller): void
    {
        (new \ReflectionMethod(AuthorController::class, 'prepareView'))->invoke($controller);
    }

    /**
     * @param array<string, mixed> $settings
     */
    private function createController(array $settings, string $format, ?PageInformation $pageInformation = null): AuthorController
    {
        $controller = new AuthorController(
            (new \ReflectionClass(Location::class))->newInstanceWithoutConstructor(),
            (new \ReflectionClass(InstitutionType::class))->newInstanceWithoutConstructor(),
            self::createStub(AuthorRepository::class),
            self::createStub(CategoryRepository::class)
        );

        $serverRequest = (new ServerRequest('https://example.com/'))
            ->withHeader('Accept', 'application/json')
            ->withAttribute('extbase', new ExtbaseRequestParameters())
            ->withAttribute('currentContentObject', new ContentObjectRenderer());
        if ($pageInformation !== null) {
            $serverRequest = $serverRequest->withAttribute('frontend.page.information', $pageInformation);
        }
        $request = (new Request($serverRequest))->withFormat($format);

        $this->setProperty($controller, 'request', $request);
        $this->setProperty($controller, 'settings', $settings);

        return $controller;
    }

    private function getRequest(AuthorController $controller): Request
    {
        $property = new \ReflectionProperty(AuthorController::class, 'request');

        return $property->getValue($controller);
    }

    private function setProperty(AuthorController $controller, string $name, mixed $value): void
    {
        $property = new \ReflectionProperty(AuthorController::class, $name);
        $property->setValue($controller, $value);
    }
}
