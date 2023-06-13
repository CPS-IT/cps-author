<?php
declare(strict_types=1);

namespace Cpsit\CpsAuthor\Configuration;

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

/**
 * Interface SettingsInterface
 */
interface SettingsInterface
{
    public const NAME = 'CpsAuthor';
    public const KEY = 'cps_author';
    public const VENDOR_NAME = 'Cpsit';

    public const FE_CACHE_TAG_AUTHOR = 'Author';

    public const ICON_AUTHOR = 'icon_author';
    public const ICON_NETWORK_PARTNER = 'icon_network_partner';
    public const ICON_GEBAEUDEFORUM_AUTHOR = 'icon_cps_author';
    public const ICON_CONTACT = 'icon_cps_contact';

    public const VIEW_VAR_AUTHORS = 'authors';
    public const VIEW_VAR_AUTHOR = 'author';
    public const VIEW_VAR_LOCATIONS = 'locations';
    public const VIEW_VAR_CATEGORIES = 'categories';
    public const VIEW_VAR_INSTITUTION_TYPES  = 'institutionTypes';
    public const VIEW_VAR_CURRENT_PAGE = 'currentPage';
}
