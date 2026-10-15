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
    public const __default = 0;
    public const BADEN_WUERTTEMBERG = 1;
    public const BAYERN = 2;
    public const BERLIN = 3;
    public const BRANDENBURG = 4;
    public const BREMEN = 5;
    public const HAMBURG = 6;
    public const HESSEN = 7;
    public const MECKLENBURG_VORPOMMERN = 8;
    public const NIEDERSACHSEN = 9;
    public const NORDRHEIN_WESTFALEN = 10;
    public const RHEINLAND_PFALZ = 11;
    public const SAARLAND = 12;
    public const SACHSEN = 13;
    public const SACHSEN_ANHALT = 14;
    public const SCHLESWIG_HOLSTEIN = 15;
    public const THUERINGEN = 16;

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

    /**
     * @return list<array{const: string, uid: int, label: string|null}>
     */
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
