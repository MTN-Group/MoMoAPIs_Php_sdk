<?php
//require the autoload file
require dirname(__DIR__, 1) . '/autoload.php';

//Parse the config file
$env = parse_ini_file(__DIR__ . '../../config.env');

use mmpsdk\Common\Constants\MobileMoney;
use mmpsdk\Common\Enums\SecurityLevel;
use mmpsdk\Common\Exceptions\MobileMoneyException;

//Initialize SDK
try {
    MobileMoney::initialize(
        MobileMoney::SANDBOX,
        $env['consumer_key'],
        $env['consumer_secret'],
        $env['api_key']
    );
    MobileMoney::setCallbackUrl($env['callback_url']);
    MobileMoney::setSecurityLevel(SecurityLevel::NONE);
} catch (MobileMoneyException $exception) {
    prettyPrint($exception->getMessage());
}

function prettyPrint($data)
{
    echo PHP_EOL . print_r($data, true) . PHP_EOL;
}
