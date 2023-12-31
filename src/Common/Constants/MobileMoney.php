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
    private static $userId = null;

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
    private static $securityLevel = SecurityLevel::STANDARD;

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

    /**
     * Base Url
     * @var string
     */
    private static $baseUrl;


    public static $authReqId;

    public static $tokenType;

    private static $bcAuthorizeFormData;

    private static $sSubKey;

    private static $sTokenIdentifier;

    private static $Oauth2TokenFormData;

    private static $sTargetEnv;

    private static $sSubType;
    /**
     * Initialize SDK
     *
     * @param string $environment SANDBOX or PRODUCTION
     * @param string $user Id  user reference Id
     * @param string $apiKey pre-shared client's api key
     * @throws Exception
     */
    public static function initialize(
        $environment,
        $userId,
        $apiKey = ''
    ) {
        if (!self::$isInitialized) {
            self::$isInitialized = true;
            self::setEnvironment($environment);
            self::setUserId($userId);
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
                self::getUserId(),
                'User Id',
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
    public static function getUserId()
    {
        return self::$userId;
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
        if (self::$environment === self::SANDBOX) {
            return API::SANDBOX_BASE_URL;
        } elseif (self::$environment === self::PRODUCTION) {
            return API::PRODUCTION_BASE_URL;
        }
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
     * @param string $userId
     */
    public static function setUserId($userId)
    {
        self::$userId = $userId;
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

    public static function setAuthReqId($authReqId)
    {
        self::$authReqId = $authReqId;
    }

    public static function setTokenType($tokenType)
    {
        self::$tokenType = $tokenType;
    }

    public static function getTokenType()
    {
        return self::$tokenType;
    }

    public static function getAuthReqId()
    {
        return self::$authReqId;
    }

    public static function destroyTokenType()
    {
        self::$tokenType = null;
    }

    public static function setBcAuthorizeFormData($bcAuthorizeFormData)
    {
        self::$bcAuthorizeFormData = $bcAuthorizeFormData;
    }

    public static function setOauth2TokenFormData($Oauth2TokenFormData)
    {
        self::$Oauth2TokenFormData = $Oauth2TokenFormData;
    }

    public static function getBcAuthorizeFormData()
    {
        return self::$bcAuthorizeFormData;
    }

    public static function getOauth2TokenFormData()
    {
        return self::$Oauth2TokenFormData;
    }

    public static function setSubscriptionKey($sSubKey)
    {
        self::$sSubKey = $sSubKey;
    }

    public static function getSubscriptionKey()
    {
        return self::$sSubKey;
    }
    public static function setTokenIdentifier($sTokenIdentifier)
    {
        self::$sTokenIdentifier = $sTokenIdentifier;
    }

    public static function getTokenIdentifier()
    {
        return self::$sTokenIdentifier;
    }

    public static function setTargetEnvironment($sTargetEnv)
    {
        self::$sTargetEnv = $sTargetEnv;
    }

    public static function getTargetEnvironment()
    {
        return self::$sTargetEnv;
    }

    public static function setSubscriptionType($sSubType)
    {
        self::$sSubType = $sSubType;
    }

    public static function getSubscriptionType()
    {
        return self::$sSubType;
    }
}
