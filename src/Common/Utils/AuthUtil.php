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
        AuthorizationCache::push($accessTokenObj, $tokenIdentifier, $sTokenType);
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
        if ($sTokenType != 'Bearer') {
            // Check if we already have accessToken in memory
            $token = self::getAccessTokenFromMemory();
            if ($token && self::checkExpiredToken($token)) {
                $token = null;
            }
        }
        if ($sTokenType == null) {
            $sTokenType = 'Basic';
        }
        // Check for persisted data first
        $token = AuthorizationCache::pull($tokenIdentifier, $sTokenType);
        // Check if Access Token is not null and has not expired.
        if ($token != null && self::checkExpiredToken($token)) {
            $token = null;
        }
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
            $token = null;
        }
        // If accessToken is Null, obtain a new token
        if ($token == null) {
            // Get a new one by making calls to API
            $token = self::updateAccessToken($userId, $apiKey, $tokenIdentifier, $sSubKey, $sTokenType, $authReqId);
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
                //     CommonUtil::validateArgument(
                //         MobileMoney::getConsumerKey(),
                //         'consumerKey',
                //         CommonUtil::TYPE_STRING
                //     );
                //     CommonUtil::validateArgument(
                //         MobileMoney::getConsumerSecret(),
                //         'consumerSecret',
                //         CommonUtil::TYPE_STRING
                //     );
                //     CommonUtil::validateArgument(
                //         MobileMoney::getApiKey(),
                //         'apiKey',
                //         CommonUtil::TYPE_STRING
                //     );
                //     return true;
                //     break;

                // case SecurityLevel::ENHANCED:
                //     //TBD
                //     return true;
                break;
            default:
                throw new \momopsdk\Common\Exceptions\MobileMoneyException(
                    'Undefined security level:' .
                        MobileMoney::getSecurityLevel()
                );
        }
    }
}
