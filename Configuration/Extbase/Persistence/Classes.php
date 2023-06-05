<?php
declare(strict_types=1);

/*
 * This file is part of the cps_author project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

return [
    \Cpsit\CpsAuthor\Domain\Model\Category::class => [
        'tableName' => \Cpsit\CpsAuthor\Domain\Model\Category::TABLE,
    ],
    \Cpsit\CpsAuthor\Domain\Model\TtContent::class => [
        'tableName' => \Cpsit\CpsAuthor\Domain\Model\TtContent::TABLE,
        'properties' => [
            'colPos' => [
                'fieldName' => 'colPos'
            ],
            'CType' => [
                'fieldName' => 'CType'
            ],
        ],
    ],
];
