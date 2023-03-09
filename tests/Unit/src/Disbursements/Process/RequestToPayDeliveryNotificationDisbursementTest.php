<?php

use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Process\BaseProcess;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdkTest\Unit\src\mocks\MockResponse;
use momopsdk\Common\Process\RequestToPayDeliveryNotification;
use momopsdk\Common\Models\DeliveryNotification;
use momopsdk\Common\Models\CallbackResponse;



class RequestToPayDeliveryNotificationDisbursementTest extends ProcessTestCase
{
    protected function setUp(): void
    {
        $deliveryNotification = new DeliveryNotification();
        $deliveryNotification->setnotificationMessage('Pay for product a delivery notification');
        $referenceId = 'ce20fe55-fc5c-4a50-8d5a-43a85e67f928';
        $notificationMessage = 'Pay for product a delivery notification';
        $language = "eng";
        $contentType = "application/json";


        $env = parse_ini_file(__DIR__ . './../../../../../config.env');
        $sSubsKey = $env['disbursement_subscription_key'];
        $sTargetEnvironmentlter = $env['target_environment'];
        $subType = 'disbursement';
        $this->constructorArgs = [
            $referenceId,
            $notificationMessage,
            $sSubsKey,
            $sTargetEnvironmentlter,
            $deliveryNotification,
            $language,
            $contentType,
            $subType
        ];
        $this->requestMethod = 'POST';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/disbursement/v1_0/requesttopay/ce20fe55-fc5c-4a50-8d5a-43a85e67f928/deliverynotification';
        $this->className = RequestToPayDeliveryNotification::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->mockResponseObject = 'RequestToPayDeliveryNotificationDisbursement.json';
        $this->responseType = CallbackResponse::class;
    }
}
