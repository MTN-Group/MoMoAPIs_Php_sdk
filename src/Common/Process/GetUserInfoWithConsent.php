<?php

namespace momopsdk\Common\Process;

use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Models\UserDetail;
use momopsdk\Common\Cache\AuthorizationCache;
use momopsdk\Common\Utils\AuthUtil;

/**
 * Class GetUserInfoWithConsent
 *
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
     * @param  string $accountHolderMSISDN, $sCollectionSubKey, $targetEnvironment
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
        MobileMoney::setSubscriptionKey($sSubKey);
        $this->targetEnv = $sTargetEnvironment;
        MobileMoney::setTargetEnvironment($sTargetEnvironment);
        $this->subType = $subType;
        MobileMoney::setSubscriptionType($subType);
        $this->callBackUrl = $sCallBackUrl;
        MobileMoney::setCallbackUrl($sCallBackUrl);
        return $this;
    }


    /**
     * Function to execute sending of additional Notification to an End User
     *
     * @return CallbackResponse
     */
    public function execute()
    {
        $token = AuthorizationCache::pull(strtoupper($this->subType), 'Bearer');
        if ($token == null || AuthUtil::checkExpiredToken($token)) {
            $this->executeBcAuthorize();
        }
        MobileMoney::setTokenType('Bearer');

        $request = RequestUtil::get(str_replace('{subscriptionType}', $this->subType, API::GET_USER_INFO_WITH_CONSENT))
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnv)
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subKey)
            ->setSubscriptionKey($this->subKey)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new UserDetail());
    }

    public static function executeBcAuthorize()
    {
        $reqData = MobileMoney::getBcAuthorizeFormData();
            //Function to bc-authorize
            $oBcAuth = new BcAuthorize(
                $reqData,
                MobileMoney::getUserId(),
                MobileMoney::getApiKey(),
                MobileMoney::getSubscriptionKey(),
                MobileMoney::getTargetEnvironment(),
                MobileMoney::getSubscriptionType(),
                MobileMoney::getCallbackUrl()
            );
            $bcAuthResult = $oBcAuth->execute();
            MobileMoney::setAuthReqId($bcAuthResult->auth_req_id);
    }
}
