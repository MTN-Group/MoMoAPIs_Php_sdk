<?php

namespace momopsdk\Collection\Process;

use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\CallbackResponse;

/**
 * Class RequestToPayDeliveryNotification
 * @package momopsdk\Collection\Process
 */
class RequestToPayDeliveryNotification extends BaseProcess
{

    /**
     * Notification Message
     */
    private $notificationMessage;

    /**
     * Notification Message
     */
    private $refId;

    /**
     * Collection subscription key
     */
    private $subKey;

    /**
     * Target environment
     */
    private $targetEnv;

    /**
     * Send notification message for a payment request
     *
     * @param string $notificationMessage
     * @param string $referenceId
     * @return this
     */
    public function __construct($referenceId, $notificationMessage, $sCollectionSubKey, $targetEnvironment)
    {
        CommonUtil::validateArgument(
            $notificationMessage,
            'notificationMessage',
            CommonUtil::TYPE_STRING
        );

        CommonUtil::validateArgument(
            $referenceId,
            'ReferenceID',
            CommonUtil::TYPE_STRING
        );

        CommonUtil::validateArgument(
            $sCollectionSubKey,
            'CollectionSubKey',
            CommonUtil::TYPE_STRING
        );

        $this->refId = $referenceId;
        $this->notificationMessage = $notificationMessage;
        $this->subKey = $sCollectionSubKey;
        $this->targetEnv = $targetEnvironment;
        $this->setUp(self::SYNCHRONOUS_PROCESS);
        return $this;
    }

    /**
     * Function to execute sending of additional Notification to an End User
     * @return CallbackResponse
     */
    public function execute()
    {
        $request = RequestUtil::get(API::REQUEST_TO_PAY_DELIVERY_NOTIFICATION)
            ->setUrlParams([
                '{referenceId}' => $this->refId
            ])
            ->httpHeader(Header::NOTIFICATION, $this->notificationMessage)
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnv)
            ->httpHeader(Header::SUBSCRIPTION_KEY, $this->subKey)
            ->setSubscriptionKey($this->subKey)
            ->setReferenceId($this->refId)
            ->build();
        $response = $this->makeRequest($request);
        print_r($response);
        die;
        return $this->parseResponse($response, new CallbackResponse());
    }
}
