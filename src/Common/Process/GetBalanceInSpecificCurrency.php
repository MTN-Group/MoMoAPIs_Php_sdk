<?php

namespace momopsdk\Common\Process;

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Models\GetAccBalance;

class GetBalanceInSpecificCurrency extends BaseProcess
{
    /**
     * Subscription Key
     */
    private $subscriptionKey;

    /**
     * Target Environment
     */
    private $targetEnvironment;


    /**
     * Subscription Type
     */
    public $subType;
    /**
     * Currency
     */
    private $currency;

    public function __construct($sSubsKey, $sTargetEnvironment, $sCurrency, $subType)
    {
        CommonUtil::validateArgument(
            $sSubsKey,
            'Subscription Key',
            CommonUtil::TYPE_STRING
        );
        $this->subscriptionKey = $sSubsKey;
        $this->targetEnvironment = $sTargetEnvironment;
        $this->subType = $subType;
        $this->currency = $sCurrency;
        return $this;
    }

    /**
     * Function to execute the API for API key generation
     *
     * @param
     * @return
     */
    public function execute()
    {
        $request = RequestUtil::get(
            str_replace('{subscriptionType}', $this->subType, API::GET_ACCOUNT_BALANCE_IN_SPECIFIC_CURRENCY)
        )
            ->setUrlParams(['{currency}' => $this->currency])
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnvironment)
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subscriptionKey)
            ->setSubscriptionKey($this->subscriptionKey)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new GetAccBalance());
    }
}
