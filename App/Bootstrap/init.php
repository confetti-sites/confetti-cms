<?php /** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

ini_set('zend.exception_string_param_max_len', '200');

if (file_exists(__DIR__ . '/../../vendor/confetti-cms/foundation/fileloader.php')) {
    require_once __DIR__ . '/../../vendor/confetti-cms/foundation/fileloader.php';
} elseif (file_exists(__DIR__ . '/../../pkg/confetti-cms/foundation/fileloader.php')) {
    require_once __DIR__ . '/../../pkg/confetti-cms/foundation/fileloader.php';
} else {
    throw new \Exception('Confetti CMS Foundation package is missing. Please run composer install.');
}

require_once __DIR__ . '/../../vendor/autoload.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);
$kernel = new \ConfettiCms\Foundation\Kernel();
/** @noinspection PhpUnhandledExceptionInspection */
$kernel->phpIniSettings();
$kernel->setEnvironmentSettings();
$kernel->run();
