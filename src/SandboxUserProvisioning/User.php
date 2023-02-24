<?php

namespace momopsdk\SandboxUserProvisioning;

use momopsdk\SandboxUserProvisioning\Process\CreateApiUser;
use momopsdk\SandboxUserProvisioning\Process\GetApiUserDetails;
use momopsdk\SandboxUserProvisioning\Process\GetApiKey;

class User
{
    public static function createUser($aReqBody, $sSubKey)
    {
        return new CreateApiUser($aReqBody, $sSubKey);
    }

    /**
     * Function to get API user information
     * @param string $sSubKey
     * @return
     */
    public static function getUserDetails($sSubKey, $sRefId)
    {
        return new GetApiUserDetails($sSubKey, $sRefId);
    }

    /**
     * Function to get API Key
     * @param string $sSubKey
     * @return
     */
    public static function createApiKey($sSubKey, $sRefId)
    {
        return new GetApiKey($sSubKey, $sRefId);
    }
}
