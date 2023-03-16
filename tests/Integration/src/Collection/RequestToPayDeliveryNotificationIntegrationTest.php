<?php

use momopsdk\Collection\Collection;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Models\CallbackResponse;
use momopsdk\Common\Models\DeliveryNotification;
use momopsdkTest\Integration\src\IntegrationTestCase;
use momopsdk\Common\Process\RequestToPayDeliveryNotification;

class RequestToPayDeliveryNotificationIntegrationTest extends IntegrationTestCase
{
    private static $deliveryNotification;

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

        self::$deliveryNotification = new DeliveryNotification();
        self::$deliveryNotification->setnotificationMessage('Pay for product a mrudul delivery notification');
    }

    protected function setUp(): void
    {
        $env = parse_ini_file(__DIR__ . './../../../../config.env');
        $referenceId = '59a03f5e-59d3-4e74-9040-359d3c027cb4';
        $notificationMessage = 'Pay for product a mrudul delivery notification';
        $this->request = Collection::requestToPayDeliveryNotification(
            $referenceId,
            $notificationMessage,
            $env['collection_subscription_key'],
            $env['target_environment'],
            self::$deliveryNotification,
        );
    }
}
