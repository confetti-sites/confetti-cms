<?php

declare(strict_types=1);

ini_set('zend.exception_string_param_max_len', '200');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../vendor/confetti-cms/foundation/fileloader.php';

error_reporting(E_ALL);
ini_set("display_errors", 1);
$kernel = new \Confetti\Foundation\Kernel();
/** @noinspection PhpUnhandledExceptionInspection */
$kernel->phpIniSettings();
$kernel->setEnvironmentSettings();
$kernel->run();
