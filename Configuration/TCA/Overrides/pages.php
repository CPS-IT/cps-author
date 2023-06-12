<?php
defined('TYPO3') or die();

use Cpsit\CpsAuthor\Configuration\Extension;
use Cpsit\CpsAuthor\Configuration\SettingsInterface;

(function ($extKey = SettingsInterface::KEY, $table = 'pages') {
    Extension::registerPageTSConfigFiles();
})();
