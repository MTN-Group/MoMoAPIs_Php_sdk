<?php

namespace momopsdkTest\Unit\src\Common\Process;

use PHPUnit\Framework\TestCase;
use momopsdkTest\Extensions\PropertyAccessor;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use momopsdk\Common\Exceptions\MobileMoneyException;
use momopsdk\Common\Models\RequestState;
use momopsdk\Common\Models\Response;
use momopsdk\Common\Process\BaseProcess;
use momopsdkTest\Unit\src\mocks\MockResponse;
use ReflectionClass;
use stdClass;

abstract class ProcessTestCase extends TestCase
{
    use ArraySubsetAsserts;
    /**
     *
     * @var array
     */
    protected $constructorArgs;

    /**
     *
     * @var array
     */
    protected $mockMethods = ['makeRequest'];

    /**
     *
     * @var string
     */
    protected $requestMethod;

    /**
     *
     * @var string
     */
    protected $requestUrl;

    /**
     *
     * @var array
     */
    protected $requestOptions;

    /**
     *
     * @var string
     */
    protected $mockResponseObject;

    /**
     *
     * @var array
     */
    protected $requestParams;

    /**
     *
     * @var string
     */
    protected $className;

    /**
     *
     * @var string
     */
    protected $processType = BaseProcess::SYNCHRONOUS_PROCESS;

    /**
     *
     * @var mixed
     */
    protected $reqObj;

    /**
     * @var string
     */
    protected $responseType;

    /**
     * @var bool
     */
    protected $arrayResponse = false;

    public function testCheckInstance()
    {
        $this->assertInstanceOf(
            $this->className,
            $this->reqObj,
            'Should be of type ' . $this->className
        );
    }

    public function testCheckProcessType()
    {
        $this->assertEquals(
            $this->processType,
            $this->reqObj->getProcessType(),
            'Wrong Process Type'
        );
    }

    public function testCheckRequest()
    {
        $mockObj = $this->buildMockObject(function ($request) {
            $requestObj = PropertyAccessor::getRequestProperties($request);
            $this->assertEquals(
                $this->requestMethod,
                $requestObj['method'],
                'Method must be: ' . $this->requestMethod
            );
            $this->assertEquals(
                $this->requestUrl,
                $requestObj['url'],
                'URL must be: ' . $this->requestUrl
            );
            if ($this->requestParams) {
                $this->assertEqualsCanonicalizing(
                    json_decode($this->requestParams[0], true),
                    json_decode($requestObj['params'][0], true),
                    'Params must be: ' . implode(',', $this->requestParams)
                );
            }
            if ($this->requestOptions) {
                $this->assertArraySubset(
                    $this->requestOptions,
                    $requestObj['options'],
                    'Options must be: ' . implode(',', $this->requestOptions)
                );
            }
            return $this->buildSuccessMockResponse(
                $request,
                $this->mockResponseObject
            );
        });
        $mockObj->execute();
    }

    public function testCheckSuccessResponse()
    {
        $mockObj = $this->buildMockObject(function ($request) {
            return $this->buildSuccessMockResponse(
                $request,
                $this->mockResponseObject
            );
        });
        $response = $mockObj->execute();

        if ($this->arrayResponse) {
            $this->assertContainsOnlyInstancesOf(
                $this->responseType,
                $response['data']
            );
        } else {
            $this->assertInstanceOf(
                // $this->processType == BaseProcess::ASYNCHRONOUS_PROCESS
                //     ? RequestState::class
                //     : 
               $this->responseType,
               $response
            );
        }
        if ($this->responseType !== stdClass::class) {
            $this->validateResponse(
                $response,
                json_decode($mockObj->getRawResponse()->getResult(), true)
            );
        }
    }

    public function testCheckFailureResponse()
    {
        $mockObj = $this->buildMockObject(function ($request) {
            return $this->buildFailureMockResponse($request);
        });
        try {
            $mockObj->execute();
            $this->expectException(MobileMoneyException::class);
        } catch (MobileMoneyException $e) {
            $this->assertNotEmpty($e->getErrorObj(), 'Error object is empty');
            $this->validateResponse(
                $e->getErrorObj(),
                json_decode($mockObj->getRawResponse()->getResult(), true)
            );
        }
    }

    private function buildSuccessMockResponse(
        $request,
        $mockResponse = 'RequestState.json'
    ) {
        $response = new Response();
        // if ($this->processType == BaseProcess::ASYNCHRONOUS_PROCESS) {
        //     $jsonData = $this->arrayResponse
        //         ? $this->buildListResponse(
        //             MockResponse::get('RequestState.json')
        //         )
        //         : MockResponse::get('RequestState.json');
        //     return $response
        //         ->setResult($jsonData)
        //         ->setHttpCode(202)
        //         ->setReferenceId('123456789')
        //         ->setRequestObj($request);
        // } else {
            $jsonData = $this->arrayResponse
                ? $this->buildListResponse(MockResponse::get($mockResponse))
                : MockResponse::get($mockResponse);
            return $response
                ->setResult($jsonData)
                ->setHttpCode(200)
                ->setRequestObj($request);
        // }
    }

    private function buildFailureMockResponse($request)
    {
        $response = new Response();
        return $response
            ->setResult(MockResponse::get('Error.json'))
            ->setHttpCode(400)
            ->setRequestObj($request);
    }

    /**
     * @param callable $callback
     * @return BaseProcess
     */
    private function buildMockObject($callback)
    {
        $mockObj = $this->getMockBuilder($this->className)->onlyMethods(
            $this->mockMethods
        );
        if ($this->constructorArgs) {
            $mockObj->setConstructorArgs($this->constructorArgs);
        }
        $mockObj = $mockObj->getMock();
        $mockObj
            ->expects($this->once())
            ->method('makeRequest')
            ->will($this->returnCallback($callback));
        return $mockObj;
    }

    protected function instantiateClass($className, $args = null)
    {
        $reflect = new ReflectionClass($className);
        if ($args !== null) {
            return $reflect->newInstanceArgs($args);
        } else {
            return $reflect->newInstance();
        }
    }

    private function buildListResponse($response)
    {
        $response = json_decode($response, true);
        return json_encode([$response, $response]);
    }

    private function getterMethod($attribute)
    {
        return 'get' .
            str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
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

    private function validateFields($fields, $response, $jsonData)
    {
        if (is_array($response)) {
            foreach ($response as $key => $value) {
                $this->validateFields($fields, $value, $jsonData[$key]);
            }
        } else {
            $this->assertNotEmpty(
                $response
            );
            $this->assertIsObject(
                $response
            );
            foreach ($response as $respKey => $oRespVal) {
                
                $getterMethod = $this->getterMethod($respKey);
                if ($getterMethod != 'getHttpCode') {
                    $this->assertTrue(
                        method_exists(get_class($response), $getterMethod),
                        'Class ' .
                            get_class($response) .
                            ' does not have method ' .
                            $getterMethod
                    );
                }
                foreach ($fields as $field) {
                    // $this->assertArrayHasKey(
                    //     $field,
                    //     $jsonData,
                    //     'Mandatory Field ' . $field . ' not found in API response'
                    // );
                    if ($getterMethod != 'getHttpCode') {
                        $this->assertNotNull(
                            $response->$getterMethod(),
                            'Field ' . $field . ' has no value.'
                        );
                    }
                }
            }
            // foreach ($fields as $field) {
            //     $getterMethod = $this->getterMethod($field);
            //     $this->assertTrue(
            //         method_exists(get_class($response), $getterMethod),
            //         'Class ' .
            //             get_class($response) .
            //             ' does not have method ' .
            //             $getterMethod
            //     );
            //     $this->assertArrayHasKey(
            //         $field,
            //         $jsonData,
            //         'Mandatory Field ' . $field . ' not found in API response'
            //     );
            //     $this->assertNotNull(
            //         $response->$getterMethod(),
            //         'Field ' . $field . ' has no value.'
            //     );
            //     if (
            //         !in_array(gettype($response->$getterMethod()), [
            //             'object',
            //             'array'
            //         ])
            //     ) {
            //         $this->assertEquals(
            //             $jsonData[$field],
            //             $response->$getterMethod(),
            //             'Field ' . $field . ' has invalid value.'
            //         );
            //     }
            // }
        }
    }
}
