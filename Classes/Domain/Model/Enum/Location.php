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
 * Author location enum
 * See: Resources/Private/Language/locallang.xlf:locationEnum for languages localizations
 */
final class Location extends \TYPO3\CMS\Core\Type\Enumeration
{
    /** @var int not location */
    const __default = 0;
    const BADEN_WUERTTEMBERG = 1;
    const BAYERN = 2;
    const BERLIN = 3;
    const BRANDENBURG = 4;
    const BREMEN = 5;
    const HAMBURG = 6;
    const HESSEN = 7;
    const MECKLENBURG_VORPOMMERN = 8;
    const NIEDERSACHSEN = 9;
    const NORDRHEIN_WESTFALEN = 10;
    const RHEINLAND_PFALZ = 11;
    const SAARLAND = 12;
    const SACHSEN = 13;
    const SACHSEN_ANHALT = 14;
    const SCHLESWIG_HOLSTEIN = 15;
    const THUERINGEN = 16;

    /**
     * Local lang key name
     * See: Resources/Private/Language/locallang.xlf
     * @var string
     */
    public string $llKey = 'locationEnum';

    /**
     * Value is spected to be an int
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
