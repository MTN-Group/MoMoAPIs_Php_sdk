<?php

namespace momopsdk\Common\Constants;

use momopsdk\Common\Enums\SecurityLevel;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Utils\CommonUtil;

/**
 * This class is used to store all the mobile money api related Constants
 * that are common to all types of transactions
 *
 * Class MobileMoney
 * @package mmpsdk\Common\Constants
 */
class MobileMoney
{
    const SANDBOX = 'SANDBOX';
    const PRODUCTION = 'PRODUCTION';
    /**
     * @var bool
     */
    public static $isInitialized = false;

    /**
     * Used to set URLs(SANDBOX or PRODUCTION)
     * @var string
     */
    private static $environment = 'SANDBOX';

    /**
     * Timeout Constants
     * @var int
     */
    private static $connectTimeout = 30000; // 30 * 1000

    /**
     * @var string
     */
    private static $consumerKey = null;

    /**
     * @var string
     */
    private static $consumerSecret = null;

    /**
     * @var string
     */
    private static $apiKey = null;

    /**
     * @var string
     */
    private static $securityLevel = SecurityLevel::DEVELOPMENT;

    /**
     * callback url on which MMP will respond for api calls
     * @var string
     */
    private static $callbackUrl;

    /**
     * Cache file path
     * @var string
     */
    private static $cachePath;

    /**
     * Access Token Object
     * @var mixed
     */
    private static $accessToken = null;

    /** URLs */
    /**
     * @var string
     */
    private static $baseUrl = 'https://sandbox.mobilemoneyapi.io/simulator/v1.2/passthrough/mm';

    /**
     * Initialize SDK
     *
     * @param string $environment SANDBOX or PRODUCTION
     * @param string $consumerKey  pre-shared client's consumer key
     * @param string $consumerSecret pre-shared client's secret key
     * @param string $apiKey pre-shared client's api key
     * @throws Exception
     */
    public static function initialize(
        $environment,
        $consumerKey,
        $consumerSecret,
        $apiKey = ''
    ) {
        if (!self::$isInitialized) {
            self::$isInitialized = true;
            self::setEnvironment($environment);
            self::setConsumerKey($consumerKey);
            self::setConsumerSecret($consumerSecret);
            self::setApiKey($apiKey);
            self::$cachePath = __DIR__ . '/../../../var/auth.cache';
        }
        if (
            self::$environment == self::PRODUCTION &&
            in_array(self::getSecurityLevel(), [
                SecurityLevel::DEVELOPMENT,
                SecurityLevel::STANDARD
            ])
        ) {
            CommonUtil::validateArgument(
                self::getConsumerKey(),
                'consumerKey',
                CommonUtil::TYPE_STRING
            );
            CommonUtil::validateArgument(
                self::getConsumerSecret(),
                'consumerSecret',
                CommonUtil::TYPE_STRING
            );
            CommonUtil::validateArgument(
                self::getApiKey(),
                'apiKey',
                CommonUtil::TYPE_STRING
            );
        }
    }

    /**
     * @return string
     */
    public static function getEnvironment()
    {
        return self::$environment;
    }

    /**
     * @return string
     */
    public static function getConsumerKey()
    {
        return self::$consumerKey;
    }

    /**
     * @return string
     */
    public static function getConsumerSecret()
    {
        return self::$consumerSecret;
    }

    /**
     * @return string
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }

    /**
     * @return string
     */
    public static function getSecurityLevel()
    {
        return self::$securityLevel;
    }

    /**
     * @return string
     */
    public static function getCallbackUrl()
    {
        return self::$callbackUrl;
    }

    /**
     * @return string
     */
    public static function getBaseUrl()
    {
        return self::$baseUrl;
    }

    /**
     * @return int
     */
    public static function getConnectionTimeout()
    {
        return self::$connectTimeout;
    }

    /**
     * @param string $callbackUrl
     */
    public static function getCachePath()
    {
        return self::$cachePath;
    }

    /**
     * @param string $callbackUrl
     */
    public static function getAccessToken()
    {
        return self::$accessToken;
    }

    /**
     * @param int $connectionTimeout
     */
    public static function setConnectionTimeout($connectionTimeout)
    {
        self::$connectTimeout = $connectionTimeout;
    }

    /**
     * @param string $consumerKey
     */
    public static function setConsumerKey($consumerKey)
    {
        self::$consumerKey = $consumerKey;
    }

    /**
     * @param string $consumerSecret
     */
    public static function setConsumerSecret($consumerSecret)
    {
        self::$consumerSecret = $consumerSecret;
    }

    /**
     * Set pre-shared client's API key
     *
     * @param string $apiKey
     */
    public static function setApiKey($apiKey)
    {
        self::$apiKey = $apiKey;
    }

    /**
     * @param string $securityLevel
     */
    public static function setSecurityLevel($securityLevel)
    {
        self::$securityLevel = $securityLevel;
    }

    /**
     * Set the URL which should receive the Callback for asynchronous requests.
     *
     * @param string $callbackUrl
     */
    public static function setCallbackUrl($callbackUrl)
    {
        self::$callbackUrl = $callbackUrl;
    }

    /**
     * @param string $callbackUrl
     */
    public static function setCachePath($cachePath)
    {
        self::$cachePath = $cachePath;
    }

    /**
     * @param string $callbackUrl
     */
    public static function setAccessToken($accessToken)
    {
        self::$accessToken = $accessToken;
    }

    /**
     * @param string $environment
     * @throws Exception
     */
    public static function setEnvironment($environment)
    {
        self::$environment = $environment;
        if ($environment === self::SANDBOX) {
            self::$baseUrl = API::SANDBOX_BASE_URL;
        } elseif ($environment === self::PRODUCTION) {
            self::$baseUrl = API::PRODUCTION_BASE_URL;
        }
    }
}
