<?php

namespace momopsdk\Common\Process;

use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Models\UserDetail;

/**
 * Class GetUserInfoWithConsent
 * @package momopsdk\Common\Process
 */
class GetUserInfoWithConsent extends BaseProcess
{
    private $subKey;

    private $targetEnv;

    private $subType;

    public $callBackUrl;

    /**
     * Used to het the personal information of the account holder
     *
     * @param string $accountHolderMSISDN, $sCollectionSubKey, $targetEnvironment
     * @return this
     */
    public function __construct($sSubKey, $sTargetEnvironment, $subType, $sCallBackUrl = null)
    {
        CommonUtil::validateArgument(
            $sSubKey,
            'SubscriptionKey',
            CommonUtil::TYPE_STRING
        );
        $this->subKey = $sSubKey;
        $this->targetEnv = $sTargetEnvironment;
        $this->subType = $subType;
        $this->callBackUrl = $sCallBackUrl;
        return $this;
    }


    /**
     * Function to execute sending of additional Notification to an End User
     * @return CallbackResponse
     */
    public function execute()
    {
        $reqData = "login_hint=ID:msisdn/msisdn&scope=profile&access_type=online";
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        //Function to bc-authorize
        $oBcAuth = new BcAuthorize(
           $reqData,
           $env['reference_id'],
           $env['momo_api_key'],
           $this->subKey,
           $this->targetEnv,
           $this->subType,
           $this->callBackUrl
        );
        $bcAuthResult = $oBcAuth->execute();
        MobileMoney::setAuthReqId($bcAuthResult->auth_req_id);
        MobileMoney::setTokenType('Bearer');

        $request = RequestUtil::get(str_replace('{subscriptionType}', $this->subType, API::GET_USER_INFO_WITH_CONSENT))
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnv)
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subKey)
            ->setSubscriptionKey($this->subKey)
            ->build();
        $response = $this->makeRequest($request);
        MobileMoney::destroyTokenType();
        return $this->parseResponse($response, new UserDetail());
    }
}
