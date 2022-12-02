<?php

namespace mmpsdk\Common\Utils;

use Exception;
use mmpsdk\Common\Cache\AuthorizationCache;
use mmpsdk\Common\Utils\RequestUtil;
use mmpsdk\Common\Enums\SecurityLevel;
use mmpsdk\Common\Constants\MobileMoney;
use mmpsdk\Common\Constants\Header;
use mmpsdk\Common\Utils\CommonUtil;
use mmpsdk\Common\Models\AuthToken;
use mmpsdk\Common\Utils\EncDecUtil;
use mmpsdk\Common\Process\AccessToken;

class AuthUtil
{
    const EXPIRY_BUFFER_TIME = 5;

    public static function buildHeader(RequestUtil $request)
    {
        switch (MobileMoney::getSecurityLevel()) {
            case SecurityLevel::NONE:
                return $request;
                break;

            case SecurityLevel::DEVELOPMENT:
                self::validateCredentials();
                $request->httpHeader(
                    Header::X_API_KEY,
                    MobileMoney::getApiKey()
                );
                $request->httpHeader(
                    Header::AUTHORIZATION,
                    EncDecUtil::getBasicAuthHeader(
                        MobileMoney::getConsumerKey(),
                        MobileMoney::getConsumerSecret()
                    )
                );
                return $request;
                break;

            case SecurityLevel::STANDARD:
                self::validateCredentials();
                $accessToken = self::getAccessToken(
                    MobileMoney::getConsumerKey(),
                    MobileMoney::getConsumerSecret(),
                    MobileMoney::getApiKey()
                );
                $request->httpHeader(
                    Header::X_API_KEY,
                    MobileMoney::getApiKey()
                );
                $request->httpHeader(
                    Header::AUTHORIZATION,
                    $accessToken->getAuthToken()
                );
                return $request;
                break;

            case SecurityLevel::ENHANCED:
                //TBD
                return $request;
                break;
            default:
                throw new \mmpsdk\Common\Exceptions\MobileMoneyException(
                    'Undefined security level:' .
                        MobileMoney::getSecurityLevel()
                );
        }
    }

    public static function checkExpiredToken($authToken)
    {
        $delta = time() - $authToken->getCreatedAt();
        // We use a buffer time when checking for token expiry to account
        // for API call delays and any delay between the time the token is
        // retrieved and subsequently used
        return $delta + self::EXPIRY_BUFFER_TIME < $authToken->getExpiresIn()
            ? false
            : true;
    }

    public static function updateAccessToken($consumerKey, $secretKey, $apiKey)
    {
        $accessTokenObj = self::generateAccessToken($consumerKey, $secretKey);
        AuthorizationCache::push($accessTokenObj, $apiKey);
        MobileMoney::setAccessToken($accessTokenObj);
        return $accessTokenObj;
    }

    public static function generateAccessToken($consumerKey, $secretKey)
    {
        $authRequest = new AccessToken($consumerKey, $secretKey);
        $authResponse = $authRequest->execute();
        $accessTokenObj = new AuthToken();
        $accessTokenObj
            ->setAuthToken($authResponse->access_token)
            ->setExpiresIn($authResponse->expires_in)
            ->setCreatedAt(time());
        return $accessTokenObj;
    }

    public static function getAccessToken($consumerKey, $secretKey, $apiKey)
    {
        // Check if we already have accessToken in memory
        $token = self::getAccessTokenFromMemory();
        if ($token && self::checkExpiredToken($token)) {
            return $token;
        }

        // Check for persisted data first
        $token = AuthorizationCache::pull($apiKey);

        // Check if Access Token is not null and has not expired.
        if ($token != null && self::checkExpiredToken($token)) {
            $token = null;
        }
        // If accessToken is Null, obtain a new token
        if ($token == null) {
            // Get a new one by making calls to API
            $token = self::updateAccessToken($consumerKey, $secretKey, $apiKey);
        }

        return $token;
    }

    public static function getAccessTokenFromMemory()
    {
        return MobileMoney::getAccessToken();
    }

    public static function validateCredentials()
    {
        switch (MobileMoney::getSecurityLevel()) {
            case SecurityLevel::NONE:
                return true;
                break;
            case SecurityLevel::DEVELOPMENT:
            case SecurityLevel::STANDARD:
                CommonUtil::validateArgument(
                    MobileMoney::getConsumerKey(),
                    'consumerKey',
                    CommonUtil::TYPE_STRING
                );
                CommonUtil::validateArgument(
                    MobileMoney::getConsumerSecret(),
                    'consumerSecret',
                    CommonUtil::TYPE_STRING
                );
                CommonUtil::validateArgument(
                    MobileMoney::getApiKey(),
                    'apiKey',
                    CommonUtil::TYPE_STRING
                );
                return true;
                break;

            case SecurityLevel::ENHANCED:
                //TBD
                return true;
                break;
            default:
                throw new \mmpsdk\Common\Exceptions\MobileMoneyException(
                    'Undefined security level:' .
                        MobileMoney::getSecurityLevel()
                );
        }
    }
}
