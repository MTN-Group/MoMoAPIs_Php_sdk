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
     * Asynchronous payment flow is used with a final callback.
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
     * Asynchronous payment flow is used with a final callback.
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
}
