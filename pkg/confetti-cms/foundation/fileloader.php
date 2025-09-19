<?php

declare(strict_types=1);

require_once 'Helpers/utils.php';

// This file does not always exists
if (file_exists('/var/resources/confetti-cms__db/model.php')) {
    require_once '/var/resources/confetti-cms__db/model.php';
}
