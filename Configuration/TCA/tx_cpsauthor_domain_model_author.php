<?php
defined('TYPO3') or die();

$tableName = \Cpsit\CpsAuthor\Domain\Model\Author::TABLE_NAME;
$extensionKey = \Cpsit\CpsAuthor\Configuration\Extension::KEY;
$ll = 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_db.xlf:';
$generalLanguageFilePrefix = 'LLL:EXT:core/Resources/Private/Language/';


return [
    'ctrl' => [
        'title' => $ll . $tableName . '.title',
        'label' => 'last_name',
        'label_alt' => 'first_name, last_name, company',
        'label_alt_force' => true,
        'default_sortby' => 'last_name',
        'sortby' => 'sorting',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'transOrigPointerField' => 'l10n_parent',
        'translationSource' => 'l10n_source',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'languageField' => 'sys_language_uid',
        'type' => 'type',
        'typeicon_column' => 'type',
        'typeicon_classes' => [
            'default' => \Cpsit\CpsAuthor\Configuration\SettingsInterface::ICON_AUTHOR,
            '1' => \Cpsit\CpsAuthor\Configuration\SettingsInterface::ICON_AUTHOR,
            '2' => \Cpsit\CpsAuthor\Configuration\SettingsInterface::ICON_NETWORK_PARTNER,
            '3' => \Cpsit\CpsAuthor\Configuration\SettingsInterface::ICON_CONTACT,
        ],
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'uid, first_name, middle_name, last_name, email, phone, fax, mobile, www, company, position, description',
    ],
    'columns' => [
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'datetime',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038),
                ],
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => '',
                        'value' => 0,
                    ],
                ],
                'foreign_table' => $tableName,
                'foreign_table_where' => 'AND ' . $tableName . '.uid=###CURRENT_PID### AND ' . $tableName . '.sys_language_uid = 0',
                'default' => 0,
            ],
        ],
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'language',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
                'default' => '',
            ],
        ],
        'l10n_source' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],

        'type' => [
            'exclude' => false,
            'label' => $ll . 'author.type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    [
                        'label' => $ll . 'author.type.I.1',
                        'value' => 1,
                        'icon' => \Cpsit\CpsAuthor\Configuration\SettingsInterface::ICON_AUTHOR
                    ],
                    [
                        'label' => $ll . 'author.type.I.2',
                        'value' => 2,
                        'icon' =>\Cpsit\CpsAuthor\Configuration\SettingsInterface::ICON_NETWORK_PARTNER
                    ],
                    [
                        'label' => $ll . 'author.type.I.3',
                        'value' => 3,
                        'icon' => \Cpsit\CpsAuthor\Configuration\SettingsInterface::ICON_CONTACT
                    ],
                ],
                'fieldWizard' => [
                    'selectIcons' => [
                        'disabled' => false,
                    ],
                ],
                'default' => 1,
                'size' => 1,
                'maxitems' => 1,
            ]
        ],
        'slug' => [
            'exclude' => true,
            'label' => $generalLanguageFilePrefix . 'locallang_tca.xlf:pages.slug',
            'displayCond' => 'VERSION:IS:false',
            'config' => [
                'type' => 'slug',
                'size' => 50,
                'generatorOptions' => [
                    // All necessary fields for the slug generation have to be present in the fields array
                    'fields' => ['uid', 'first_name', 'last_name', 'company'],
                    'defaultFields' => ['uid', 'first_name', 'last_name'],
                    'authorFields' => ['uid', 'first_name', 'last_name'],
                    'networkPartnerFields' => ['company'],
                    'fieldSeparator' => '/',
                    'replacements' => [
                        '/' => '-'
                    ],
                    'postModifiers' => [
                        \Cpsit\CpsAuthor\Slug\AuthorSlugModifier::class . '->modifySlugByAuthorType'
                    ]
                ],
                'fallbackCharacter' => '-',
                'eval' => 'unique',
                'default' => ''
            ]
        ],
        'gender' => [
            'label' => $ll . 'author.gender',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => '',
                'items' => [
                    [
                        'label' => $ll . 'author.gender.m',
                        'value' => 'm'
                    ],
                    [
                        'label' => $ll . 'author.gender.f',
                        'value' => 'f'
                    ],
                    [
                        'label' => $ll . 'author.gender.v',
                        'value' => 'v'
                    ],
                    [
                        'label' => $ll . 'author.gender.undefined',
                        'value' => ''
                    ]
                ]
            ]
        ],
        'first_name' => [
            'exclude' => false,
            'label' => $ll . 'author.first_name',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 255
            ]
        ],
        'middle_name' => [
            'exclude' => false,
            'label' => $ll . 'author.middle_name',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 255
            ]
        ],
        'last_name' => [
            'exclude' => false,
            'label' => $ll . 'author.last_name',
            'l10n_mode' => 'exclude',
            'l10n_display' => 'defaultAsReadonly',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 255
            ]
        ],
        'phone' => [
            'label' => $generalLanguageFilePrefix . 'locallang_general.xlf:LGL.phone',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'size' => 20,
                'max' => 30,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'fax' => [
            'exclude' => true,
            'label' => $generalLanguageFilePrefix . 'locallang_general.xlf:LGL.fax',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => \FriendsOfTYPO3\TtAddress\Evaluation\TelephoneEvaluation::class,
                'max' => 30,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'mobile' => [
            'exclude' => true,
            'label' => $ll . 'author.mobile',
            'config' => [
                'type' => 'input',
                'eval' => \FriendsOfTYPO3\TtAddress\Evaluation\TelephoneEvaluation::class,
                'size' => 20,
                'max' => 30,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'www' => [
            'exclude' => true,
            'label' => $generalLanguageFilePrefix . 'locallang_general.xlf:LGL.www',
            'config' => [
                'type' => 'link',
            ],
        ],
        'email' => [
            'label' => $generalLanguageFilePrefix . 'locallang_general.xlf:LGL.email',
            'config' => [
                'type' => 'email',
            ]
        ],
        'skype' => [
            'exclude' => true,
            'label' => $ll . 'author.skype',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 255,
                'placeholder' => 'Skype URL',
                'softref' => 'typolink_tag,url',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'twitter' => [
            'exclude' => true,
            'label' => $ll . 'author.twitter',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 255,
                'placeholder' => '@twitter',
                'softref' => 'typolink_tag,url',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'facebook' => [
            'exclude' => true,
            'label' => $ll . 'author.facebook',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 255,
                'placeholder' => 'facebook URL',
                'softref' => 'typolink_tag,url',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'linkedin' => [
            'exclude' => true,
            'label' => $ll . 'author.linkedin',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 255,
                'placeholder' => 'linkedin URL',
                'softref' => 'typolink_tag,url',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'instagram' => [
            'exclude' => true,
            'label' => $ll . 'author.instagram',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 255,
                'placeholder' => 'instagram URL',
                'softref' => 'typolink_tag,url',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'company' => [
            'exclude' => true,
            'label' => $ll . 'author.company',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
                'size' => 20,
                'max' => 255,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'position' => [
            'exclude' => true,
            'label' => $ll . 'author.position',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 255,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'images' => [
            'exclude' => true,
            'label' => $generalLanguageFilePrefix . 'locallang_general.xlf:LGL.image',
            'config' => [
                ### !!! Watch out for fieldName different from columnName
                'type' => 'file',
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'maxitems' => 6,
                'minitems' => 0,
                'appearance' => [
                    'collapseAll' => true,
                    'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference'
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'overrideChildTca' => [
                    'types' => [
                        '0' => [
                            'showitem' => '
                                    --palette--;' . $generalLanguageFilePrefix . 'locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                            'showitem' => '
                                    --palette--;' . $generalLanguageFilePrefix . 'locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                                    --palette--;' . $generalLanguageFilePrefix . 'locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                            'showitem' => '
                                    --palette--;' . $generalLanguageFilePrefix . 'locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                            'showitem' => '
                                    --palette--;' . $generalLanguageFilePrefix . 'locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                            'showitem' => '
                                    --palette--;' . $generalLanguageFilePrefix . 'locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                                    --palette--;;filePalette'
                        ],
                    ],
                    'columns' => [
                        'crop' => [
                            'config' => [
                                'cropVariants' => [
                                    'mobile' => [
                                        'title' => 'Mobile',
                                        'selectedRatio' => '16:9',
                                        'allowedAspectRatios' => [
                                            '16:9' => [
                                                'title' => '16:9',
                                                'value' => 16 / 9
                                            ],
                                        ]
                                    ],
                                    'tablet' => [
                                        'title' => 'Tablet',
                                        'selectedRatio' => '16:9',
                                        'allowedAspectRatios' => [
                                            '16:9' => [
                                                'title' => '16:9',
                                                'value' => 16 / 9
                                            ],
                                        ]
                                    ],
                                ]
                            ]
                        ]
                    ]
                ],
            ]
        ],
        'description' => [
            'exclude' => true,
            'label' => $generalLanguageFilePrefix . 'locallang_general.xlf:LGL.description',
            'config' => [
                'type' => 'text',
                'rows' => 5,
                'cols' => 48,
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'softref' => 'typolink_tag,url',
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'no_profile' => [
            'exclude' => true,
            'label' => $ll . 'author.no_profile',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        'label' => '',
                    ],
                ],
                'default' => 0,
            ],
        ],
        'categories' => [
            'exclude' => true,
            'l10n_mode' => 'exclude',
            'label' => $ll . 'author.categories',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectTree',
                'minitems' => 0,
                'maxitems' => 99,
                'foreign_table' => 'sys_category',
                'foreign_table_where' => ' AND sys_category.pid IN (###PAGE_TSCONFIG_IDLIST###)
                    AND ({#sys_category}.{#sys_language_uid} IN (-1, 0) OR {#sys_category}.{#l10n_parent} = 0)
                    ORDER BY sys_category.sorting',
                'MM' => 'sys_category_record_mm',
                'MM_opposite_field' => 'items',
                'MM_match_fields' => [
                    'fieldname' => 'categories',
                    'tablenames' => \Cpsit\CpsAuthor\Domain\Model\Author::TABLE_NAME,
                ],
                'treeConfig' => [
                    'parentField' => 'parent',
                    'appearance' => [
                        'nonSelectableLevels' => '0',
                        'expandAll' => false
                    ]
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
        'location' => [
            'exclude' => true,
            'label' => $ll . 'author.location',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'itemsProcFunc' => 'Cpsit\CpsAuthor\Service\ItemsProcFunc->getLocationsForTca',
                'default' => '0',
            ]
        ],
        'institution_type' => [
            'exclude' => true,
            'label' => $ll . 'author.institution_type',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'itemsProcFunc' => 'Cpsit\CpsAuthor\Service\ItemsProcFunc->getInstitutionTypesForTca',
                'default' => '0',
            ]
        ],
        'content_elements' => [
            'exclude' => true,
            'label' => $ll . 'author.content_elements',
            'config' => [
                'type' => 'inline',
                'allowed' => 'tt_content',
                'foreign_table' => 'tt_content',
                'foreign_sortby' => 'sorting',
                'foreign_field' => 'tx_cps_author',
                'minitems' => 0,
                'maxitems' => 99,
                'appearance' => [
                    'collapseAll' => true,
                    'expandSingle' => true,
                    'levelLinksPosition' => 'bottom',
                    'useSortable' => true,
                    'showPossibleLocalizationRecords' => true,
                    'showAllLocalizationLink' => true,
                    'showSynchronizationLink' => true,
                    'enabledControls' => [
                        'info' => false,
                    ]
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ],
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--;' . $ll . 'tab.general, type, --palette--;;name, --palette--;;organization, image, description, no_profile,
                --div--;' . $ll . 'tab.contact, --palette--;;contact,
                --div--;' . $ll . 'tab.social, --palette--;;social,
                --div--;' . $ll . 'tab.language, --palette--;;language,
                --div--;' . $ll . 'tab.access' . ', hidden, --palette--;;access
            ',
        ],
        '2' => [
            'showitem' => '
                --div--;' . $ll . 'tab.general, type, --palette--;;name, --palette--;;organization, image, description, content_elements,
                --div--;' . $ll . 'tab.contact, --palette--;;contact,
                --div--;' . $ll . 'tab.social, --palette--;;social,
                --div--;LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.category, categories,
                --div--;' . $ll . 'tab.language, --palette--;;language,
                --div--;' . $ll . 'tab.access' . ', hidden, --palette--;;access
            ',
        ],
        '3' => [
            'showitem' => '
                --div--;' . $ll . 'tab.general, type, --palette--;;name, --palette--;;organization, image, description,
                --div--;' . $ll . 'tab.contact, --palette--;;contact,
                --div--;' . $ll . 'tab.social, --palette--;;social,
                --div--;' . $ll . 'tab.language, --palette--;;language,
                --div--;' . $ll . 'tab.access' . ', hidden, --palette--;;access
            ',
        ],
    ],
    'palettes' => [
        'organization' => [
            'label' => $ll . 'author_palette.organization',
            'showitem' => 'company, institution_type,
            --linebreak--, location,
            --linebreak--, images'
        ],

        'name' => [
            'label' => $ll . 'author_palette.name',
            'showitem' => 'gender, position, --linebreak--, first_name, middle_name, last_name,
            --linebreak--, slug'
        ],
        'contact' => [
            'label' => $ll . 'author_palette.contact',
            'showitem' => 'email, --linebreak--,
                            phone, mobile, fax, --linebreak--,
                            www'
        ],
        'social' => [
            'label' => $ll . 'author_palette.social',
            'showitem' => 'instagram, twitter,
                        --linebreak--, facebook, linkedin,
                        --linebreak--, skype'
        ],
        'language' => [
            'showitem' => 'sys_language_uid, l10n_parent',
        ],
        'access' => [
            'showitem' => 'starttime, endtime',
        ],
    ],
];
