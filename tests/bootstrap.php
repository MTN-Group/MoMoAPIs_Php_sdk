<?php
//require the autoload file
require_once __DIR__ . './../autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');

// To suppress the warning during the date() invocation in logs, we would default the timezone to GMT.
if (!ini_get('date.timezone')) {
    date_default_timezone_set('GMT');
}
