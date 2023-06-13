<?php
/*
 * This file is part of thecps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

declare(strict_types=1);

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\CpsAuthor\Slug;

use Cpsit\CpsAuthor\Domain\Model\Author;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\DataHandling\SlugHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AuthorSlugModifier
{
    /**
     * Modify slug for authors depending on type
     *
     * @param $arguments
     * @return string
     */
    public function modifySlugByAuthorType($arguments): string
    {
        $configuration = $arguments['configuration'];
        $record = $arguments['record'];

        if (isset($arguments['record']['uid'])) {
            $savedRecord = BackendUtility::getRecord(Author::TABLE_NAME, $arguments['record']['uid']);
            $record['type'] = $savedRecord['type'];
        }

        // Remove current modifier from configuration
        foreach ($configuration['generatorOptions']['postModifiers'] as $key => $postModifier) {
            if (strpos($postModifier, __FUNCTION__) !== false) {
                unset($configuration['generatorOptions']['postModifiers'][$key]);
            }
        }

        // Apply new
        if ($record['type'] == Author::TYPE_AUTHOR) {
            $this->setAuthorFieldsConfiguration($record, $configuration);
        }

        if ($record['type'] == Author::TYPE_NETWORK_PARTNER) {
            $this->setNetworkPartnerFieldsConfiguration($record, $configuration);
        }

        /** @var SlugHelper $slugHelper */
        $slugHelper = GeneralUtility::makeInstance(SlugHelper::class,
            Author::TABLE_NAME,
            Author::FIELD_SLUG,
            $configuration,
        );

        return $slugHelper->generate($record, $arguments['pid']);
    }


    /**
     * @param array $record
     * @param array $configuration
     */
    protected function setAuthorFieldsConfiguration(array $record, array &$configuration): void
    {
        if ($this->checkGeneratorOptionsFields($record, $configuration, 'authorFields')) {
            $configuration['generatorOptions']['fields'] = $configuration['generatorOptions']['authorFields'];
        }
    }

    protected function setNetworkPartnerFieldsConfiguration(array $record, array &$configuration): void
    {
        if ($this->checkGeneratorOptionsFields($record, $configuration, 'networkPartnerFields')) {
            $configuration['generatorOptions']['fields'] = $configuration['generatorOptions']['networkPartnerFields'];
        }
    }

    /**
     * Return false if check fails
     *
     * @param array $record
     * @param array $configuration
     * @param string $fieldsConfKey
     * @return bool
     */
    protected function checkGeneratorOptionsFields(array $record, array $configuration, string $fieldsConfKey): bool
    {
        if (empty($configuration['generatorOptions'][$fieldsConfKey])) {
            return false;
        }

        foreach ($configuration['generatorOptions'][$fieldsConfKey] as $key) {
            if (!empty($record[$key])) {
                return true;
            }
        }
        return false;
    }
}
