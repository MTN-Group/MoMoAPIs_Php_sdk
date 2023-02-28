<?php

namespace momopsdkTest\Unit\src\mocks;

class MockResponse
{
    public static function get($fileName)
    {
        return file_get_contents(__DIR__ . '/' . $fileName);
    }
}
