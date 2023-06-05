<?php
defined('TYPO3_MODE') or die();

use Cpsit\CpsAuthor\Configuration\Extension;
use Cpsit\CpsAuthor\Configuration\SettingsInterface;

(function ($extKey = SettingsInterface::KEY, $table = 'pages') {
    Extension::registerPageTSConfigFiles();
})();
