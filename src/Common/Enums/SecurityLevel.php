<?php

namespace momopsdk\Common\Enums;

/**
 * Class SecurityLevel
 * @package mmpsdk\Common\Enums
 */
class SecurityLevel
{
    const DEVELOPMENT = 'DevLevel',
        STANDARD = 'StandardLevel',
        ENHANCED = 'EnhancedLevel',
        NONE = 'None';

    /**
     * @return array
     */
    public static function getSecurityLevelOptions()
    {
        return [self::NONE, self::DEVELOPMENT, self::STANDARD, self::ENHANCED];
    }
}
