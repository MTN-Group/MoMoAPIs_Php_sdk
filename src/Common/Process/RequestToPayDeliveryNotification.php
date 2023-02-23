<?php

namespace momopsdk\Common\Process;

use momopsdk\Common\Constants\API;
use momopsdk\Common\Constants\Header;
use momopsdk\Common\Utils\CommonUtil;
use momopsdk\Common\Utils\RequestUtil;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\CallbackResponse;

/**
 * Class RequestToPayDeliveryNotification
 * @package momopsdk\Common\Process
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
     * Subscription Type
     */
    public $subType;

    /**
     * Delivery notification Message
     */
    private $deliveryNotificationMsg;

    /**
     * Content type
     */
    private $contentType;

    /**
     * Content type
     */
    private $language;

    /**
     * Send notification message for a payment request
     *
     * @param string $notificationMessage
     * @param string $referenceId
     * @return this
     */
    public function __construct($sReferenceId, $sNotificationMessage, $sCollectionSubKey, $sTargetEnvironment, $oDeliveryNotification, $sLanguage, $sContentType, $subType)
    {
        CommonUtil::validateArgument(
            $sNotificationMessage,
            'notificationMessage',
            CommonUtil::TYPE_STRING
        );

        CommonUtil::validateArgument(
            $sReferenceId,
            'ReferenceID',
            CommonUtil::TYPE_STRING
        );

        CommonUtil::validateArgument(
            $sCollectionSubKey,
            'CollectionSubKey',
            CommonUtil::TYPE_STRING
        );

        CommonUtil::validateArgument(
            $oDeliveryNotification,
            'Delivery Notification object',
            CommonUtil::TYPE_OBJECT
        );

        $this->refId = $sReferenceId;
        $this->notificationMessage = $sNotificationMessage;
        $this->deliveryNotificationMsg = $oDeliveryNotification;
        $this->subKey = $sCollectionSubKey;
        $this->targetEnv = $sTargetEnvironment;
        $this->contentType = $sContentType;
        $this->subType = $subType;
        $this->language = $sLanguage;
        return $this;
    }

    /**
     * Function to execute sending of additional Notification to an End User
     * @return CallbackResponse
     */
    public function execute()
    {
        $request = RequestUtil::post(str_replace('{subscriptionType}', $this->subType, API::REQUEST_TO_PAY_DELIVERY_NOTIFICATION), json_encode($this->deliveryNotificationMsg))
            ->setUrlParams([
                '{referenceId}' => $this->refId
            ])
            ->httpHeader(Header::NOTIFICATION, $this->notificationMessage)
            ->httpHeader(Header::X_TARGET_ENVIRONMENT, $this->targetEnv)
            ->httpHeader(Header::OCP_APIM_SUBSCRIPTION_KEY, $this->subKey)
            ->setReferenceId($this->refId)
            ->setSubscriptionKey($this->subKey);
        if ($this->language != null) {
            $request = $request->httpHeader(Header::LANGUAGE, $this->callBackUrl);
        }
        if ($this->contentType != null) {
            $request = $request->httpHeader(Header::CONTENT_TYPE, $this->contentType);
        }
        $request = $request->build();
        $response = $this->makeRequest($request);
        return $this->parseResponse($response, new CallbackResponse());
    }
}
