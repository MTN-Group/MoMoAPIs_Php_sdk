<?php

namespace momopsdkTest\Extensions;

require_once __DIR__ . '/../../vendor/autoload.php';

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Enums\SecurityLevel;
use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\BeforeFirstTestHook;
use Dotenv\Dotenv;

class InitializeSDK implements BeforeFirstTestHook, AfterLastTestHook
{
    public function executeBeforeFirstTest(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__, './../../config.env');
        $dotenv->load();
        MobileMoney::initialize(
            MobileMoney::SANDBOX,
            $_ENV['reference_id'],
            $_ENV['momo_api_key']
        );
    }

    public function executeAfterLastTest(): void
    {
        // TODO: Implement executeAfterLastTest() method.
    }

    /**
     * @return string|null
     */
    protected function getPhpUnitParam(string $paramName): ?string
    {
        global $argv;
        $k = array_search("--$paramName", $argv);
        if (!$k) {
            return null;
        }
        return $argv[$k + 1];
    }
}
