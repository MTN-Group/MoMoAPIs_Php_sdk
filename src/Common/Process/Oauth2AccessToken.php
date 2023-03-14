<?php

namespace momopsdk\Common\Process;

use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Constants\API;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\EncDecUtil;

class Oauth2AccessToken extends BaseProcess
{
    private $userId;

    private $apiKey;

    public $isAuthTokenRequest = true;

    private $tokenIdentifier;

    private $subscriptionKey;

    private $authReqId;

    /**
     * Use this API call to generate an Access Token. You can then use the token to authenticate on subsequent API requests until the token expires.
     * To generate the access token, a User Id and a api key is required
     *
     */
    public function __construct($userId, $apiKey, $tokenIdentifier, $sSubKey, $authReqId)
    {
        CommonUtil::validateArgument($userId, 'userId');
        CommonUtil::validateArgument($apiKey, 'apiKey');
        $this->userId = $userId;
        $this->apiKey = $apiKey;
        $this->tokenIdentifier = $tokenIdentifier;
        $this->subscriptionKey = $sSubKey;
        $this->authReqId = $authReqId;
        return $this;
    }

    public function execute()
    {
        switch ($this->tokenIdentifier) {
            case 'COLLECTION':
                $apiUrl = API::COLLECTION_OAUTH2ACCESS_TOKEN;
                break;
            case 'DISBURSEMENT':
                $apiUrl = API::DISBURSEMENT_OAUTH2ACCESS_TOKEN;
                break;
            case 'REMITTANCE':
                $apiUrl = API::REMITTANCE_OAUTH2ACCESS_TOKEN;
                break;
            default:
                # code...
                break;
        }
        $env = parse_ini_file(__DIR__ . './../../../config.env');
        $data = $env['oauth2_token_data'];
        $request = RequestUtil::post(
            $apiUrl, str_replace('{auth_req_id}', $this->authReqId, $data)
        )
            ->httpHeader(
                Header::AUTHORIZATION,
                EncDecUtil::getBasicAuthHeader(
                    $this->userId,
                    $this->apiKey
                )
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
                'sandbox'
            )
            ->setSubscriptionKey($this->subscriptionKey)
            ->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response);
    }
}
