<?php

namespace mmpsdk\SandboxService;

use mmpsdk\Common\Traits\CommonTrait;

/**
 * Class SandboxService
 * @package mmpsdk\SandboxService
 */
class SandboxService
{
    use CommonTrait;

    /**
     * Initiates a User Request.
     *
     * @param User $user
     * @param string $callBackUrl
     * @return InitiateAccount
     */
    public static function createAccount(
        \mmpsdk\SandboxService\Models\User $user,
        $callBackUrl = null
    ) {
        return new \mmpsdk\SandboxService\Process\InitiateAccount(
            $user,
            $callBackUrl
        );
    }

    /**
     * Initiates an API key request.
     *
     * @param string $callBackUrl
     * @return InitiateApiKey
     */
    public static function createApiKey(
        $callBackUrl = null
    ) {
        return new \mmpsdk\SandboxService\Process\InitiateApiKey(
            $callBackUrl
        );
    }

    /**
     * Initiates an Access Token request.
     *
     * @return InitiateAccessToken
     */
    public static function createAccessToken(
    ) {
        return new \mmpsdk\SandboxService\Process\InitiateAccessToken(
        );
    }
}
