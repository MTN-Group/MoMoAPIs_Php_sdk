<?php

namespace momopsdk\SandboxUserProvisioning\Process;

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;

class GetApiUserDetails extends BaseProcess
{
    public function __construct($aReqBody)
    {
        CommonUtil::validateArgument(
            $aReqBody,
            'callbackHost',
            CommonUtil::TYPE_ARRAY
        );
        $this->setUp(self::ASYNCHRONOUS_PROCESS);
        return $this;
    }
}
