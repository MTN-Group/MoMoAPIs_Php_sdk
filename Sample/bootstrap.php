<?php
//require the autoload file
require_once __DIR__ . './../autoload.php';

//Parse the config file
$env = parse_ini_file(__DIR__ . './../config.env');

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Enums\SecurityLevel;
use momopsdk\Common\Exceptions\MobileMoneyException;

//Initialize SDK
try {
    // MobileMoney::initialize(
    //     MobileMoney::PRODUCTION,
    //     $env['consumer_key'],
    //     $env['consumer_secret'],
    //     $env['api_key']
    // );
    // MobileMoney::setCallbackUrl($env['callback_url']);
    // MobileMoney::setSecurityLevel(SecurityLevel::STANDARD);
    $sCollectionSubKey = $env['collection_subscription_key'];
} catch (MobileMoneyException $exception) {
    prettyPrint($exception->getMessage());
}

function prettyPrint($data)
{
    echo PHP_EOL . print_r($data, true) . PHP_EOL;
}
