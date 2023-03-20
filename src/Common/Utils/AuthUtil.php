<?php

namespace momopsdk\Common\Utils;

use Exception;
use momopsdk\Common\Cache\AuthorizationCache;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Enums\SecurityLevel;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Models\AuthToken;
use momopsdk\Common\Utils\EncDecUtil;
use momopsdk\Common\Process\AccessToken;
use momopsdk\Common\Process\Oauth2AccessToken;

class AuthUtil
{
    public static $CACHE_PATH = '/../../../var/auth.cache';

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
                    Header::AUTHORIZATION,
                    EncDecUtil::getBasicAuthHeader(
                        MobileMoney::getUserId(),
                        MobileMoney::getApiKey()
                    )
                )
                ->httpHeader(
                    Header::CONTENT_TYPE,
                    'application/json'
                );
                return $request;
                break;

            case SecurityLevel::STANDARD:
                self::validateCredentials();
                $accessToken = self::getAccessToken(
                    MobileMoney::getUserId(),
                    MobileMoney::getApiKey(),
                    $request->tokenIdentifier,
                    $request->getSubscriptionKey(),
                    MobileMoney::getTokenType(),
                    MobileMoney::getAuthReqId()
                );
                $request->httpHeader(
                    Header::AUTHORIZATION,
                    "Bearer " . $accessToken->getAuthToken()
                );
                return $request;
                break;

            case SecurityLevel::ENHANCED:
                //TBD
                return $request;
                break;
            default:
                throw new \momopsdk\Common\Exceptions\MobileMoneyException(
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

    public static function updateAccessToken(
        $userId,
        $apiKey,
        $tokenIdentifier,
        $sSubKey,
        $sTokenType,
        $aExistingData,
        $authReqId = null
    )
    {
        $accessTokenObj = self::generateAccessToken(
            $userId,
            $apiKey,
            $tokenIdentifier,
            $sSubKey,
            $sTokenType,
            $authReqId
        );
        if ($sTokenType == null) {
            $sTokenType = 'Basic';
        }
        AuthorizationCache::push($accessTokenObj, $tokenIdentifier, $sTokenType, $aExistingData);
        MobileMoney::setAccessToken($accessTokenObj);
        return $accessTokenObj;
    }

    public static function generateAccessToken($userId, $apiKey, $tokenIdentifier, $sSubKey, $sTokenType, $authReqId)
    {
        if ($sTokenType == null) {
            $sTokenType = 'Basic';
        }
        if ($sTokenType == 'Bearer') {
            $authRequest = new Oauth2AccessToken($userId, $apiKey, $tokenIdentifier, $sSubKey, $authReqId);
        } else {
            $authRequest = new AccessToken($userId, $apiKey, $tokenIdentifier, $sSubKey);
        }
        $authResponse = $authRequest->execute();
        
        $accessTokenObj = new AuthToken();
        $accessTokenObj
            ->setAuthToken($authResponse->access_token)
            ->setExpiresIn($authResponse->expires_in)
            ->setCreatedAt(time())
            ->setTokenIdentifier($tokenIdentifier)
            ->setTokenType($sTokenType);
        return $accessTokenObj;
    }

    public static function getAccessToken($userId, $apiKey, $tokenIdentifier, $sSubKey, $sTokenType, $authReqId)
    {
        if ($sTokenType == null) {
            $sTokenType = 'Basic';
        }
        // Check for persisted data first
        $token = AuthorizationCache::pull($tokenIdentifier, $sTokenType);

        //check token exists and of same type as token identifier
        if (
            $token != null && property_exists($token, "tokenIdentifier") &&
            $token->tokenIdentifier == $tokenIdentifier &&
            property_exists($token, "tokenType") &&
            $token->tokenType == $sTokenType &&
            !(self::checkExpiredToken($token))
        ) {
            return $token;
        } else {
            $cachePath = self::cachePath();
            $aExistingData = [];
            if (file_exists($cachePath)) {
                $aExistingData = self::setExistingData(json_decode(file_get_contents($cachePath), true));
            }
            $token = null;
        }
        // If accessToken is Null, obtain a new token
        if ($token == null) {
            // Get a new one by making calls to API
            $token = self::updateAccessToken($userId, $apiKey, $tokenIdentifier, $sSubKey, $sTokenType, $aExistingData, $authReqId);
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
                return true;
                break;
            case SecurityLevel::STANDARD:
                    CommonUtil::validateArgument(
                        MobileMoney::getUserId(),
                        'UserId',
                        CommonUtil::TYPE_STRING
                    );
                    CommonUtil::validateArgument(
                        MobileMoney::getApiKey(),
                        'ApiKey',
                        CommonUtil::TYPE_STRING
                    );
                    return true;
                    break;

                case SecurityLevel::ENHANCED:
                //     //TBD
                    return true;
                break;
            default:
                throw new \momopsdk\Common\Exceptions\MobileMoneyException(
                    'Undefined security level:' .
                        MobileMoney::getSecurityLevel()
                );
        }
    }

    public static function setExistingData($token)
    {
        return $token;
    }

    public static function cachePath()
    {
        $cachePath = MobileMoney::getCachePath();
        return empty($cachePath) ? __DIR__ . self::$CACHE_PATH : $cachePath;
    }
}
