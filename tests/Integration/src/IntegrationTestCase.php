<?php

namespace momopsdkTest\Integration\src;

use PHPUnit\Framework\TestCase;
use momopsdk\Common\Process\BaseProcess;
use momopsdk\Common\Enums\NotificationMethod;

abstract class IntegrationTestCase extends TestCase
{
    protected $response;
    protected $request;

    abstract protected function getProcessInstanceType();
    abstract protected function getResponseInstanceType();
    abstract protected function getRequestType();

    // protected function pollingRequest($serverCorrelationId)
    // {
    //     return Common::viewRequestState($serverCorrelationId);
    // }

    public function testProcessInstanceType()
    {
        $this->assertInstanceOf(
            $this->getProcessInstanceType(),
            $this->request
        );
    }

    public function testProcessFeatures()
    {
        if ($this->getRequestType() == BaseProcess::ASYNCHRONOUS_PROCESS) {
            $this->assertNotNull($this->request->getReferenceId());
        } else {
            $this->assertNull($this->request->getReferenceId());
        }
    }

    public function testResponse()
    {
        $this->response = $this->request->execute();
        // Test Response is not null
        $this->assertNotNull($this->response);
        //Test Response Code
        if ($this->getRequestType() == BaseProcess::ASYNCHRONOUS_PROCESS) {
            $this->assertEquals(
                202,
                $this->request->getRawResponse()->getHttpCode()
            );
        } else {
            $this->assertEquals(
                200,
                $this->request->getRawResponse()->getHttpCode()
            );
        }

        // Test response type
        if (!is_array($this->response)) {
            $this->assertInstanceOf(
                $this->getResponseInstanceType(),
                $this->response
            );
        }

        if ($this->getRequestType() == BaseProcess::ASYNCHRONOUS_PROCESS) {
            $this->asynchronusProcessAssertions(NotificationMethod::CALLBACK);
        }
        // $this->responseAssertions($this->request, $this->response);
    }

    public function testPollingSequence()
    {
        if ($this->getRequestType() == BaseProcess::ASYNCHRONOUS_PROCESS) {
            $this->request->setNotificationMethod(NotificationMethod::POLLING);
            $this->response = $this->request->execute();
            $this->asynchronusProcessAssertions(NotificationMethod::POLLING);

            // Poll Request
            // $serverCorreleationId = $this->response->getServerCorrelationId();
            // $pollRequest = Common::viewRequestState(
            //     $serverCorreleationId
            // )->execute();
            // $this->assertNotNull($pollRequest);
        } else {
            $this->markTestSkipped(
                'This test is only for asynchronous process'
            );
        }
    }

    // public function testMissingResponse()
    // {
    //     if ($this->getRequestType() == BaseProcess::ASYNCHRONOUS_PROCESS) {
    //         // Missing Response
    //         $this->response = $this->request->execute();
    //         $clientCorreleationId = $this->response->getReferenceId();
    //         $missingResponse = Common::viewResponse(
    //             $clientCorreleationId
    //         )->execute();
    //         $this->assertNotNull(
    //             $missingResponse,
    //             'Missing Response API returned null'
    //         );
    //     } else {
    //         $this->markTestSkipped(
    //             'This test is only for asynchronous process'
    //         );
    //     }
    // }

    private function asynchronusProcessAssertions($notificationMethod)
    {
        $this->assertEquals(
            202,
            $this->request->getRawResponse()->getHttpCode()
        );
        $this->assertInstanceOf(
            $this->getResponseInstanceType(),
            $this->response
        );
        $requestStateObject = $this->response;
        $this->assertEquals(
            $notificationMethod,
            $requestStateObject->getNotificationMethod()
        );
        $this->assertNotNull(
            $requestStateObject->getReferenceId(),
            'Server Correlation ID is null'
        );
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/',
            $requestStateObject->getReferenceId(),
            'Invalid Server Correlation ID Returned in response: ' .
                $requestStateObject->getReferenceId()
        );
        // $this->assertMatchesRegularExpression(
        //     '/^(pending|completed|failed)$/',
        //     $requestStateObject->getStatus()
        // );
    }

    // protected function responseAssertions($request, $response)
    // {
    //     $rawResponse = $request->getRawResponse();
    //     $jsonData = json_decode($rawResponse->getResult(), true);
    //     $this->assertNotNull($jsonData, 'Invalid JSON Response from API');
    //     $this->validateResponse($response, $jsonData);
    //     switch ($this->getResponseInstanceType()) {
    //         case \mmpsdk\Common\Models\AuthorisationCode::class:
    //             $this->validateFields(
    //                 ['authorisationCode', 'codeState'],
    //                 $response,
    //                 $jsonData
    //             );
    //             break;
    //         case \mmpsdk\Common\Models\Quotation::class:
    //             $this->validateFields(
    //                 ['quotationReference', 'requestAmount'],
    //                 $response,
    //                 $jsonData
    //             );
    //             break;
    //         case \mmpsdk\Common\Models\Transaction::class:
    //             $this->validateFields(
    //                 ['transactionReference', 'transactionStatus'],
    //                 $response,
    //                 $jsonData
    //             );
    //             break;
    //         case \mmpsdk\Disbursement\Models\BatchTransaction::class:
    //             $this->validateFields(
    //                 array_merge(
    //                     ['batchId', 'batchStatus'],
    //                     $response->getBatchStatus() === 'created'
    //                         ? ['creationDate']
    //                         : [],
    //                     $response->getBatchStatus() === 'approved'
    //                         ? ['approvalDate']
    //                         : [],
    //                     $response->getBatchStatus() === 'completed'
    //                         ? ['completionDate']
    //                         : []
    //                 ),
    //                 $response,
    //                 $jsonData
    //             );
    //             break;
    //         case \mmpsdk\Disbursement\Models\BatchCompletion::class:
    //             if (!empty($jsonData)) {
    //                 $this->validateFields(
    //                     [
    //                         'creditParty',
    //                         'debitParty',
    //                         'link',
    //                         'completionDate',
    //                         'transactionReference'
    //                     ],
    //                     $response,
    //                     $jsonData
    //                 );
    //             }
    //             break;
    //         case \mmpsdk\Disbursement\Models\BatchRejection::class:
    //             if (!empty($jsonData)) {
    //                 $this->validateFields(
    //                     [
    //                         'creditParty',
    //                         'debitParty',
    //                         'rejectionReason',
    //                         'rejectionDate'
    //                     ],
    //                     $response,
    //                     $jsonData
    //                 );
    //             }
    //             break;
    //         case \mmpsdk\Common\Models\AccountHolderName::class:
    //             $this->validateFields(['name'], $response, $jsonData);
    //             break;
    //         case \mmpsdk\BillPayment\Models\Bill::class:
    //             $this->validateFields(['billReference'], $response, $jsonData);
    //             break;
    //         case \mmpsdk\BillPayment\Models\BillPay::class:
    //             $this->validateFields(
    //                 ['amountPaid', 'currency'],
    //                 $response,
    //                 $jsonData
    //             );
    //             break;
    //         case \mmpsdk\AgentService\Models\Account::class:
    //             $this->validateFields(['identity'], $response, $jsonData);
    //             break;
    //         case \mmpsdk\AccountLinking\Models\Link::class:
    //             $this->validateFields(
    //                 ['sourceAccountIdentifiers', 'mode', 'status'],
    //                 $response,
    //                 $jsonData
    //             );
    //             break;
    //         default:
    //             break;
    //     }
    // }

    // private function getterMethod($attribute)
    // {
    //     return 'get' .
    //         str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
    // }

    // private function validateFields($fields, $response, $jsonData)
    // {
    //     if (is_array($response)) {
    //         foreach ($response['data'] as $key => $value) {
    //             $this->validateFields($fields, $value, $jsonData[$key]);
    //         }
    //     } else {
    //         foreach ($fields as $field) {
    //             $getterMethod = $this->getterMethod($field);
    //             $this->assertTrue(
    //                 method_exists(get_class($response), $getterMethod),
    //                 'Class ' .
    //                     get_class($response) .
    //                     ' does not have method ' .
    //                     $getterMethod
    //             );
    //             $this->assertArrayHasKey(
    //                 $field,
    //                 $jsonData,
    //                 'Mandatory Field ' . $field . ' not found in API response'
    //             );
    //             $this->assertNotNull(
    //                 $response->$getterMethod(),
    //                 'Field ' . $field . ' has no value.'
    //             );
    //             if (
    //                 !in_array(gettype($response->$getterMethod()), [
    //                     'object',
    //                     'array'
    //                 ])
    //             ) {
    //                 $this->assertEquals(
    //                     $jsonData[$field],
    //                     $response->$getterMethod(),
    //                     'Field ' . $field . ' has invalid value.'
    //                 );
    //             }
    //         }
    //     }
    // }

    // private function validateResponse($response, $jsonData)
    // {
    //     if (is_array($response)) {
    //         foreach ($response['data'] as $key => $value) {
    //             $this->validateFields(
    //                 array_keys($jsonData[$key]),
    //                 $value,
    //                 $jsonData[$key]
    //             );
    //         }
    //     } else {
    //         return $this->validateFields(
    //             array_keys($jsonData),
    //             $response,
    //             $jsonData
    //         );
    //     }
    // }
}
