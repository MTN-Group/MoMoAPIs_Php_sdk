<?php

namespace momopsdk\Common\Utils;

use momopsdk\Common\Constants\MobileMoney;

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

    public static function getBasicAuthHeader($userId, $apiKey)
    {
        return 'Basic ' .
            EncDecUtil::base64Encode($userId . ':' . $apiKey);
    }
}
