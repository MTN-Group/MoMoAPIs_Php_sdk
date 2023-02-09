<?php

namespace momopsdk\SandboxUserProvisioning;

use momopsdk\SandboxUserProvisioning\Process\CreateApiUser;

class User
{
    public static function createUser($aReqBody)
    {
        return new CreateApiUser($aReqBody);
    }
}
