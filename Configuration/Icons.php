<?php

declare(strict_types=1);

use Cpsit\CpsAuthor\Configuration\SettingsInterface as SI;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    SI::ICON_AUTHOR => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cps_author/Resources/Public/Icons/icon_author.svg',
    ],
    SI::ICON_NETWORK_PARTNER => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cps_author/Resources/Public/Icons/icon_network_partner.svg',
    ],
    SI::ICON_GEBAEUDEFORUM_AUTHOR => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cps_author/Resources/Public/Icons/icon_cps_author.svg',
    ],
    SI::ICON_CONTACT => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:cps_author/Resources/Public/Icons/icon_contact.svg',
    ],
];
