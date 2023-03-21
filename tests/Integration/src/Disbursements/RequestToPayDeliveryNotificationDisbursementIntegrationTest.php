<?php

use momopsdk\Common\Process\BaseProcess;
use momopsdk\Disbursement\DisbursementTransaction;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Common\Process\RequestToPayDeliveryNotification;
use momopsdk\Common\Models\CallbackResponse;
use momopsdk\Common\Models\DeliveryNotification;

class RequestToPayDeliveryNotificationDisbursementIntegrationTest extends IntegrationTestCase
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
        $referenceId = 'ba3f54b1-3105-486b-9185-5f2737a377a4';
        $notificationMessage = 'Pay for product a delivery notification';
        $language = "eng";
        $contentType = "application/json";
        $this->request = DisbursementTransaction::requestToPayDeliveryNotification(
            $referenceId,
            $notificationMessage,
            $env['disbursement_subscription_key'],
            $env['target_environment'],
            self::$oReqDataObject,
            $language,
            $contentType
        );
    }
}
