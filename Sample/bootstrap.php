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
    $sCollectionSubKey = $env['collection_subscription_key'];
    $targetEnvironment = $env['target_environment'];
    $sDisbursementSubKey = $env['disbursement_subscription_key'];
    $sRemittanceSubKey = $env['remittance_subscription_key'];
    
    MobileMoney::initialize(
        MobileMoney::SANDBOX,
        $env['reference_id'],
        $env['momo_api_key']
    );
    MobileMoney::setSecurityLevel(SecurityLevel::STANDARD);
    MobileMoney::setCallbackUrl("http://webhook.site/c84cd23c-062b-49bb-b206-909bc8625207");
} catch (MobileMoneyException $exception) {
    prettyPrint($exception->getMessage());
}

function prettyPrint($data)
{
    echo PHP_EOL . print_r($data, true) . PHP_EOL;
}
