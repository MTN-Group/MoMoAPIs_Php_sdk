<?php

use momopsdk\Disbursement\DisbursementTransaction;
use momopsdkTest\Unit\src\Common\Process\WrapperTestCase;

class DisbursementTest extends WrapperTestCase
{
    public function testStaticFunctions()
    {
        $this->wrapperClass = DisbursementTransaction::class;

        $requestState = DisbursementTransaction::getAccountBalance('ABC123', 'sandbox');
        $this->checkStaticFunctionParamCount(
            'getAccountBalance',
            momopsdk\Common\Process\GetBalance::class
        );
        $this->checkFunctionReturnInstance(
            $requestState,
            momopsdk\Common\Process\GetBalance::class
        );

        $depositStatus = DisbursementTransaction::getDepositStatus(
            'asqw12',
            'sandbox',
            '123'
        );
        $this->checkStaticFunctionParamCount(
            'getDepositStatus',
            momopsdk\Disbursement\Process\GetDepositStatus::class
        );
        $this->checkFunctionReturnInstance(
            $depositStatus,
            momopsdk\Disbursement\Process\GetDepositStatus::class
        );

        $getRefundStatus = DisbursementTransaction::getRefundStatus(
            'asqw12',
            'sandbox',
            '123'
        );
        $this->checkStaticFunctionParamCount(
            'getDepositStatus',
            momopsdk\Disbursement\Process\GetRefundStatus::class
        );
        $this->checkFunctionReturnInstance(
            $getRefundStatus,
            momopsdk\Disbursement\Process\GetRefundStatus::class
        );

        $getTransferStatus = DisbursementTransaction::getTransferStatus(
            'asqw12',
            'sandbox',
            '123'
        );
        $this->checkStaticFunctionParamCount(
            'getTransferStatus',
            momopsdk\Common\Process\GetTransferStatus::class
        );
        $this->checkFunctionReturnInstance(
            $getTransferStatus,
            momopsdk\Common\Process\GetTransferStatus::class
        );

        $depositv1 = DisbursementTransaction::depositV1(
            (object)['object'],
            '1234qwer',
            'sandbox',
            'http://www.example.com'
        );
        $this->checkStaticFunctionParamCount(
            'depositV1',
            momopsdk\Disbursement\Process\CreateDepositV1::class
        );
        $this->checkFunctionReturnInstance(
            $depositv1,
            momopsdk\Disbursement\Process\CreateDepositV1::class
        );

        $depositv2 = DisbursementTransaction::depositV2(
            (object)['object'],
            '1234qwer',
            'sandbox',
            'http://www.example.com'
        );
        $this->checkStaticFunctionParamCount(
            'depositV2',
            momopsdk\Disbursement\Process\CreateDepositV2::class
        );
        $this->checkFunctionReturnInstance(
            $depositv2,
            momopsdk\Disbursement\Process\CreateDepositV2::class
        );

        $refundv1 = DisbursementTransaction::refundV1(
            (object)['object'],
            '1234qwer',
            'sandbox',
            'http://www.example.com'
        );
        $this->checkStaticFunctionParamCount(
            'refundV1',
            momopsdk\Disbursement\Process\CreateRefundV1::class
        );
        $this->checkFunctionReturnInstance(
            $refundv1,
            momopsdk\Disbursement\Process\CreateRefundV1::class
        );

        $refundv2 = DisbursementTransaction::refundV2(
            (object)['object'],
            '1234qwer',
            'sandbox',
            'http://www.example.com'
        );
        $this->checkStaticFunctionParamCount(
            'refundV2',
            momopsdk\Disbursement\Process\CreateRefundV2::class
        );
        $this->checkFunctionReturnInstance(
            $refundv2,
            momopsdk\Disbursement\Process\CreateRefundV2::class
        );

        $transfer = DisbursementTransaction::transfer(
           'test',
           '232sds',
           'sandbox',
           'http://www.example.com'
        );
        $this->checkStaticFunctionParamCount(
            'transfer',
            momopsdk\Common\Process\Transfer::class
        );
        $this->checkFunctionReturnInstance(
            $transfer,
            momopsdk\Common\Process\Transfer::class
        );

        $validateAccountHolderStatus = DisbursementTransaction::validateAccountHolderStatus(
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

        $requestToPayDeliveryNotification = DisbursementTransaction::requestToPayDeliveryNotification(
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

        $basicUserInfo = DisbursementTransaction::getBasicUserinfo(
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

        $getUserInfoWithConsent = DisbursementTransaction::getUserInfoWithConsent(
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
