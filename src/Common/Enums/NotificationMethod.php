<?php

namespace mmpsdk\Common\Enums;

/**
 * Class NotificationMethod
 * @package mmpsdk\Common\Enums
 */
class NotificationMethod
{
    const POLLING = 'polling',
        CALLBACK = 'callback';

    /**
     * @return array
     */
    public static function getNotificationMethodOptions()
    {
        return [self::POLLING, self::CALLBACK];
    }
}
