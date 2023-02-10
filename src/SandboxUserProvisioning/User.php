<?php

namespace momopsdk\SandboxUserProvisioning;

use momopsdk\SandboxUserProvisioning\Process\CreateApiUser;

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
    public function getUserDetails($sSubKey)
    {
        return new GetApiUserDetails($sSubKey);
    }
}
