<?php

namespace momopsdk\Common\Process;

use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\EncDecUtil;

class BcAuthorize extends BaseProcess
{
    private $userId;

    private $apiKey;

    protected $targetEnv;

    protected $subscriptionKey;

    protected $callBackUrl;

    protected $postData;

    private $subType;
    /**
     * Construct function
     * @param
     * @return object
     */
    public function __construct(
       $sReqData,
       $userId,
       $apiKey,
       $sSubKey,
       $sTargetEnvironment,
       $subType,
       $sCallBackUrl = null
    )
    {
        CommonUtil::validateArgument($userId, 'userId');
        CommonUtil::validateArgument($apiKey, 'apiKey');
        $this->userId = $userId;
        $this->apiKey = $apiKey;
        $this->targetEnv = $sTargetEnvironment;
        $this->subscriptionKey = $sSubKey;
        $this->callBackUrl = $sCallBackUrl;
        $this->postData = $sReqData;
        $this->subType = $subType;
        return $this;
    }

    public function execute()
    {
        switch ($this->subType) {
            case 'disbursement':
                $apiUrl = API::DISBURSEMENT_BC_AUTHORIZE;
                break;
            case 'collection':
                $apiUrl = API::COLLECTION_BC_AUTHORIZE;
                break;
            default:
                # code...
                break;
        }
        $request = RequestUtil::post(
            $apiUrl,
            $this->postData
        )
            ->httpHeader(
                Header::CONTENT_TYPE,
                'application/x-www-form-urlencoded'
            )
            ->httpHeader(
                Header::OCP_APIM_SUBSCRIPTION_KEY,
                $this->subscriptionKey
            )
            ->httpHeader(
                Header::X_TARGET_ENVIRONMENT,
                $this->targetEnv
            )
            ->setSubscriptionKey($this->subscriptionKey);
            if ($this->callBackUrl != null) {
                $request = $request->httpHeader(
                    Header::X_CALLBACK_URL,
                    $this->callBackUrl
                );
            }

        $request = $request->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response);
    }
}
