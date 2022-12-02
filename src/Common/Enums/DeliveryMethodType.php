<?php

namespace mmpsdk\Common\Enums;

/**
 * Class DeliveryMethodType
 * @package mmpsdk\Common\Enums
 */
class DeliveryMethodType
{
    const DIRECT_TO_ACCOUNT = 'directtoaccount',
        AGENT = 'agent',
        PERSONAL_DELIVERY = 'personaldelivery';

    /**
     * @return array
     */
    public static function getDeliveryTypeOptions()
    {
        return [self::DIRECT_TO_ACCOUNT, self::AGENT, self::PERSONAL_DELIVERY];
    }
}
