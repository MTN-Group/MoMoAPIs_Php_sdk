<?php

namespace mmpsdk\Common\Utils;

use mmpsdk\Common\Constants\MobileMoney;

/**
 * Class EncDecUtil
 * @package mmpsdk\Common\Utils
 */
class EncDecUtil
{
    public static function generateHash()
    {
    }

    public static function base64Encode($data)
    {
        return base64_encode($data);
    }

    public static function getBasicAuthHeader($consumerKey, $secretKey)
    {
        return 'Basic ' .
            EncDecUtil::base64Encode($consumerKey . ':' . $secretKey);
    }
}
