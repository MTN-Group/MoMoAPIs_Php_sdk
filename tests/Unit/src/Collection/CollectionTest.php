<?php

use momopsdk\Collection\Collection;
use momopsdkTest\Unit\src\Common\Process\WrapperTestCase;

class CollectionTest extends WrapperTestCase
{
    public function testStaticFunctions()
    {
        $this->wrapperClass = Collection::class;

        $requestState = Collection::requestToPay(
            (object)['obj'],
            'abc123',
            'sandbox',
            'http://www.example.com',
            'api/json'
        );
        $this->checkStaticFunctionParamCount(
            'requestToPay',
            momopsdk\Collection\Process\InitiateRequestToPay::class
        );
        $this->checkFunctionReturnInstance(
            $requestState,
            momopsdk\Collection\Process\InitiateRequestToPay::class
        );

        $basicUserInfo = Collection::getBasicUserinfo(
            'asd123',
            'qwe123',
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

        $requestToPayTransactionStatus = Collection::requestToPayTransactionStatus(
            'asd123',
            'qwe123',
            'sandbox'
        );
        $this->checkStaticFunctionParamCount(
            'requestToPayTransactionStatus',
            momopsdk\Collection\Process\RetrieveRequestToPay::class
        );
        $this->checkFunctionReturnInstance(
            $requestToPayTransactionStatus,
            momopsdk\Collection\Process\RetrieveRequestToPay::class
        );

        $validateAccountHolderStatus = Collection::validateAccountHolderStatus(
            'asd123',
            'qwe123',
            'asas123',
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

        $getBalance = Collection::getAccountBalance(
            'asd123',
            'sandbox'
        );
        $this->checkStaticFunctionParamCount(
            'getAccountBalance',
            momopsdk\Common\Process\GetBalance::class
        );
        $this->checkFunctionReturnInstance(
            $getBalance,
            momopsdk\Common\Process\GetBalance::class
        );

        $requestToWithdrawV1 = Collection::requestToWithdrawV1(
            (object)['obj'],
            'asd123',
            'sandbox',
            'http://www.example.com',
            'api/json'
        );
        $this->checkStaticFunctionParamCount(
            'requestToWithdrawV1',
            momopsdk\Collection\Process\RequestToWithdrawV1::class
        );
        $this->checkFunctionReturnInstance(
            $requestToWithdrawV1,
            momopsdk\Collection\Process\RequestToWithdrawV1::class
        );

        $requestToWithdrawV2 = Collection::requestToWithdrawV2(
            (object)['obj'],
            'asd123',
            'sandbox',
            'http://www.example.com',
            'api/json'
        );
        $this->checkStaticFunctionParamCount(
            'requestToWithdrawV2',
            momopsdk\Collection\Process\RequestToWithdrawV2::class
        );
        $this->checkFunctionReturnInstance(
            $requestToWithdrawV2,
            momopsdk\Collection\Process\RequestToWithdrawV2::class
        );

        $requestToWithdrawTransactionStatus = Collection::requestToWithdrawTransactionStatus(
            'asa12',
            'asd123',
            'sandbox'
        );
        $this->checkStaticFunctionParamCount(
            'requestToWithdrawTransactionStatus',
            momopsdk\Collection\Process\RequestToWithdrawStatus::class
        );
        $this->checkFunctionReturnInstance(
            $requestToWithdrawTransactionStatus,
            momopsdk\Collection\Process\RequestToWithdrawStatus::class
        );

        $requestToPayDeliveryNotification = Collection::requestToPayDeliveryNotification(
            'asa12',
            'asd123',
            'sedrfgh3456',
            'sandbox',
            (object)['obj'],
            'en',
            'api/json'
        );
        $this->checkStaticFunctionParamCount(
            'requestToPayDeliveryNotification',
            momopsdk\Common\Process\RequestToPayDeliveryNotification::class
        );
        $this->checkFunctionReturnInstance(
            $requestToPayDeliveryNotification,
            momopsdk\Common\Process\RequestToPayDeliveryNotification::class
        );
        

        $getUserInfoWithConsent = Collection::getUserInfoWithConsent(
            'sedrfgh3456',
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
