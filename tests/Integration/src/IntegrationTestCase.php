<?php

namespace momopsdkTest\Integration\src;

use momopsdk\Common\Enums\NotificationMethod;
use momopsdk\Common\Process\BaseProcess;
use PHPUnit\Framework\TestCase;

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
        $this->responseAssertions($this->request, $this->response);
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
    //         $clientCorreleationId = $this->response->getClientCorrelationId();
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
        // $this->assertEquals(
        //     $notificationMethod,
        //     $requestStateObject->getNotificationMethod()
        // );
        $this->assertNotNull(
            $requestStateObject->referenceId,
            'Reference ID is null'
        );
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/',
            $requestStateObject->referenceId,
            'Invalid Server Correlation ID Returned in response: ' .
                $requestStateObject->referenceId
        );
        // $this->assertMatchesRegularExpression(
        //     '/^(pending|completed|failed)$/',
        //     $requestStateObject->getStatus()
        // );
    }

    protected function responseAssertions($request, $response)
    {
        $rawResponse = $request->getRawResponse();
        $jsonData = [];
        if ($request->getRawResponse()->getHttpCode() != '202') {
            $jsonData = json_decode($rawResponse->getResult(), true);
            $this->assertNotNull($jsonData, 'Invalid JSON Response from API');
        }
        $this->validateFields(
            ['result', 'httpCode'],
            $response,
            $jsonData
        );
    }

    private function getterMethod($attribute)
    {
        return 'get' .
            str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
    }

    private function validateFields($fields, $response, $jsonData)
    {
        if (is_array($response)) {
            foreach ($response['data'] as $key => $value) {
                $this->validateFields($fields, $value, $jsonData[$key]);
            }
        } else {
            $this->assertNotEmpty(
                $response
            );
            $this->assertIsObject(
                $response
            );
            foreach ($fields as $field) {
                $getterMethod = $this->getterMethod($field);
                if ($getterMethod != 'getHttpCode') {
                    $this->assertTrue(
                        method_exists(get_class($response), $getterMethod),
                        'Class ' .
                            get_class($response) .
                            ' does not have method ' .
                            $getterMethod
                    );
                }
                if ($getterMethod != 'getHttpCode') {
                    $this->assertNotNull(
                        $response,
                        'Field ' . $field . ' has no value.'
                    );
                }
            }
        }
    }

    private function validateResponse($response, $jsonData)
    {
        if (is_array($response)) {
            foreach ($response['data'] as $key => $value) {
                $this->validateFields(
                    array_keys($jsonData[$key]),
                    $value,
                    $jsonData[$key]
                );
            }
        } else {
            return $this->validateFields(
                array_keys($jsonData),
                $response,
                $jsonData
            );
        }
    }
}
