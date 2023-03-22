<?php

use momopsdk\Collection\Collection;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\CallbackResponse;
use momopsdk\Common\Models\DeliveryNotification;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Common\Process\RequestToPayDeliveryNotification;

class RequestToPayDeliveryNotificationIntegrationTest extends IntegrationTestCase
{
    public static $oReqDataObject;

    protected function getProcessInstanceType()
    {
        return RequestToPayDeliveryNotification::class;
    }

    protected function getResponseInstanceType()
    {
        return CallbackResponse::class;
    }

    protected function getRequestType()
    {
        return BaseProcess::SYNCHRONOUS_PROCESS;
    }

    public static function setUpBeforeClass(): void
    {
        self::$oReqDataObject = new DeliveryNotification();

        self::$oReqDataObject
            ->setnotificationMessage('Pay for product a delivery notification');
    }

    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $referenceId = '5a4d4807-fa36-41f8-b7c7-6e7911df9a12';
        $notificationMessage = 'Pay for product a delivery notification';
        $language = "eng";
        $contentType = "application/json";
        $this->request = Collection::requestToPayDeliveryNotification(
            $referenceId,
            $notificationMessage,
            $env['collection_subscription_key'],
            $env['target_environment'],
            self::$oReqDataObject,
            $language,
            $contentType
        );
    }
}
