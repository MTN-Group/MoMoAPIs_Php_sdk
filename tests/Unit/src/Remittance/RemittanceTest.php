<?php

use momopsdk\Remittance\Remittance;
use momopsdkTest\Unit\src\Common\Process\WrapperTestCase;

class RemittanceTest extends WrapperTestCase
{
    public function testStaticFunctions()
    {
        $this->wrapperClass = Remittance::class;

        $requestState = Remittance::getAccountBalance('ABC123', 'sandbox');
        $this->checkStaticFunctionParamCount(
            'getAccountBalance',
            momopsdk\Common\Process\GetBalance::class
        );
        $this->checkFunctionReturnInstance(
            $requestState,
            momopsdk\Common\Process\GetBalance::class
        );

        $response = Remittance::transfer('test', '232sds', 'sandbox', 'http://www.example.com');
        $this->checkStaticFunctionParamCount(
            'transfer',
            momopsdk\Common\Process\Transfer::class
        );
        $this->checkFunctionReturnInstance(
            $response,
            momopsdk\Common\Process\Transfer::class
        );

        $transferStatus = Remittance::getTransferStatus('asas1212', 'sandbox', '12dgsydgsy');
        $this->checkStaticFunctionParamCount(
            'getTransferStatus',
            momopsdk\Common\Process\GetTransferStatus::class
        );
        $this->checkFunctionReturnInstance(
            $transferStatus,
            momopsdk\Common\Process\GetTransferStatus::class
        );

        $validateAccountHolderStatus = Remittance::validateAccountHolderStatus(
           '53425',
           'type',
           '12345werty',
           'sandbox'
        );
        $this->checkStaticFunctionParamCount(
            'validateAccountHolderStatus',
            momopsdk\Common\Process\ValidateAccountHolder::class
        );
        $this->checkFunctionReturnInstance(
            $validateAccountHolderStatus,
            momopsdk\Common\Process\ValidateAccountHolder::class
        );

        $requestToPayDeliveryNotification = Remittance::requestToPayDeliveryNotification(
           'asdf123',
           'msg',
           'key',
           'env',
           (object) ['object'],
           'eng',
           'content'
        );
        $this->checkStaticFunctionParamCount(
            'requestToPayDeliveryNotification',
            momopsdk\Common\Process\RequestToPayDeliveryNotification::class
        );
        $this->checkFunctionReturnInstance(
            $requestToPayDeliveryNotification,
            momopsdk\Common\Process\RequestToPayDeliveryNotification::class
        );

        $basicUserInfo = Remittance::getBasicUserinfo(
           'asdf23',
           'asdfg12345',
           'sandbox'
        );
        $this->checkStaticFunctionParamCount(
            'getBasicUserinfo',
            momopsdk\Common\Process\GetBasicUserInfo::class
        );
        $this->checkFunctionReturnInstance(
            $basicUserInfo,
            momopsdk\Common\Process\GetBasicUserInfo::class
        );

        $getUserInfoWithConsent = Remittance::getUserInfoWithConsent(
           'asdf1234',
           'sandbox',
           'http://www.example.com'
        );
        $this->checkStaticFunctionParamCount(
            'getUserInfoWithConsent',
            momopsdk\Common\Process\GetUserInfoWithConsent::class
        );
        $this->checkFunctionReturnInstance(
            $getUserInfoWithConsent,
            momopsdk\Common\Process\GetUserInfoWithConsent::class
        );
    }
}
