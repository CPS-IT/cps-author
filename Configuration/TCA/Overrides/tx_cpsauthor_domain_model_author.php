<?php
(function () {

    $extensionKey = \Cpsit\CpsAuthor\Configuration\Extension::KEY;
    $tableName = \Cpsit\CpsAuthor\Domain\Model\Author::TABLE_NAME;

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
        $extensionKey,
        $tableName,
        'categories',
        [
            'exclude' => true,
            'fieldList' => 'categories',
            'position' => 'categories',
            // Override generic configuration, e.g. sort by title rather than by sorting
            'fieldConfiguration' => [
                'foreign_table_where' => ' AND sys_category.pid IN (###PAGE_TSCONFIG_IDLIST###)  
                    AND ({#sys_category}.{#sys_language_uid} IN (-1, 0) OR {#sys_category}.{#l10n_parent} = 0) 
                    ORDER BY sys_category.sorting',
                'treeConfig' => [
                    'appearance' => [
                        'nonSelectableLevels' => '0',
                        'expandAll' => false
                    ]
                ],
                'minitems' => 0,
                'maxitems' => 4,
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
            ]
        ]
    );
})();
