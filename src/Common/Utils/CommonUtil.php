<?php

namespace momopsdk\Common\Utils;

use stdClass;

/**
 * Class CommonUtil
 * @package momopsdk\Common\Utils
 */
class CommonUtil
{
    const TYPE_STRING = 'string',
        TYPE_OBJECT = 'object',
        TYPE_ARRAY = 'array';
    
    public static function validateArgument(
        $argument,
        $argumentName,
        $requiredType = null
    ) {
        if ($requiredType && $requiredType !== gettype($argument)) {
            throw new \momopsdk\Common\Exceptions\MobileMoneyException(
                "$argumentName: $requiredType required " .
                    gettype($argument) .
                    ' given.'
            );
        } elseif ($argument === null) {
            throw new \momopsdk\Common\Exceptions\MobileMoneyException(
                "$argumentName cannot be null"
            );
        } elseif (gettype($argument) == 'string' && trim($argument) == '') {
            throw new \momopsdk\Common\Exceptions\MobileMoneyException(
                "$argumentName string cannot be empty"
            );
        } elseif (
            gettype($argument) == 'array' &&
            (in_array(null, $argument, true) || in_array('', $argument, true))
        ) {
            throw new \momopsdk\Common\Exceptions\MobileMoneyException(
                "$argumentName cannot contain null or empty string"
            );
        }
        return true;
    }
}
