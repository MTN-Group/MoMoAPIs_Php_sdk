<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Constants\MobileMoney;
use momopsdk\Common\Models\CallbackResponse;
use momopsdk\Common\Models\DeliveryNotification;
use momopsdkTest\Unit\src\Common\Process\ProcessTestCase;
use momopsdk\Common\Process\RequestToPayDeliveryNotification;

class RequestToPayDeliveryNotificationTest extends ProcessTestCase
{

    private $subType = 'collection';
    private  $referenceId = '9ffb31ab-a7bc-494d-8ab0-76589c773719';
    protected function setUp(): void
    {

        $deliveryNotification = new DeliveryNotification();
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $deliveryNotification->setnotificationMessage('Pay for product by a mrudul delivery notification');
        $notificationMessage = 'Pay for product by a mrudul delivery notification';
        $contentType = "application/json";
        $this->constructorArgs = [
            $this->referenceId, $notificationMessage, $env['collection_subscription_key'], $env['target_environment'],
            $deliveryNotification, 'eng', $contentType, $this->subType
        ];
        $this->requestMethod = 'POST';
        $this->requestUrl =
            MobileMoney::getBaseUrl() .
            '/collection/v1_0/requesttopay/9ffb31ab-a7bc-494d-8ab0-76589c773719/deliverynotification';
        $this->className = RequestToPayDeliveryNotification::class;
        $this->reqObj = $this->instantiateClass(
            $this->className,
            $this->constructorArgs
        );
        $this->processType = BaseProcess::SYNCHRONOUS_PROCESS;
        $this->mockResponseObject = 'CallbackResponse.json';
        $this->responseType = CallbackResponse::class;
    }
}
