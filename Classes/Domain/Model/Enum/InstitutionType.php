<?php
declare(strict_types=1);

/*
 * This file is part of thecps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Cpsit\CpsAuthor\Domain\Model\Enum;

use Cpsit\CpsAuthor\Configuration\SettingsInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Author institution type enum
 * See: Resources/Private/Language/locallang.xlf:institutionTypeEnum for languages localizations
 */
final class InstitutionType extends \TYPO3\CMS\Core\Type\Enumeration
{
    /** @var int no type */

    const __default = 0;
    const ENERGY_AGENCIES = 1;
    const SCIENCE_INSTITUTES_UNIVERSITIES = 2;
    const TRAINING_INSTITUTIONS = 3;
    const PUBLIC_INSTITUTIONS = 4;
    const ASSOCIATIONS_CLUBS_CHAMBERS = 5;
    const OTHER = 6;

    /**
     * Local lang key name
     * See: Resources/Private/Language/locallang.xlf
     * @var string
     */
    public string $llKey = 'institutionTypeEnum';

    /**
     * Return value is expected to be an int
     */
    public function getValue(): int
    {
        return (int)$this->value;
    }

    public function getLocalizedConstants(bool $includeDefault = false): array
    {
        $localizedConstants = [];
        foreach ($this->getConstants($includeDefault) as $key => $constant) {
            $localizedConstants[] = [
                'const' => $key,
                'uid' => $constant,
                'label' => LocalizationUtility::translate(
                    $this->llKey . '.' . $constant,
                    SettingsInterface::NAME
                ),
            ];
        }
        return $localizedConstants;
    }
}
