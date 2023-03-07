<?php
namespace momopsdkTest\Unit\src\Common\Process;
use ReflectionClass;
use ReflectionMethod;
use PHPUnit\Framework\TestCase;

class WrapperTestCase extends TestCase
{
    protected $wrapperClass;

    public function checkStaticFunctionParamCount($methodName, $type)
    {
        $class = new ReflectionClass($type);
        $method = new ReflectionMethod($this->wrapperClass, $methodName);
        $this->assertGreaterThan(
            $method->getNumberOfParameters(),
            $class->getConstructor()->getNumberOfParameters(),

        );
    }

    public function checkFunctionReturnInstance($obj, $type)
    {
        $this->assertInstanceOf($type, $obj);
    }
}
