<?php

namespace momopsdk\Common\Utils;

use Exception;
// use momopsdk\Common\Cache\AuthorizationCache;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Enums\SecurityLevel;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Models\AuthToken;
use momopsdk\Common\Utils\EncDecUtil;
use momopsdk\Common\Process\AccessToken;

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
                throw new \momopsdk\Common\Exceptions\MobileMoneyException(
                    'Undefined security level:' .
                        MobileMoney::getSecurityLevel()
                );
        }
    }

    public static function validateCredentials()
    {
        switch (MobileMoney::getSecurityLevel()) {
            case SecurityLevel::NONE:
                return true;
                break;
            case SecurityLevel::DEVELOPMENT:
            // case SecurityLevel::STANDARD:
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
