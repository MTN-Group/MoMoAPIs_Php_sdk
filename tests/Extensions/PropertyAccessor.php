<?php

namespace momopsdkTest\Extensions;

use ReflectionClass;
use momopsdk\Common\Utils\RequestUtil;

class PropertyAccessor
{
    /**
     * getHiddenProperty
     *
     * @param 	string $className
     * @param 	string $propertyName
     * @return	ReflectionProperty
     */
    public static function getProperty($className, $propertyName)
    {
        $reflector = new ReflectionClass($className);
        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);

        return $property;
    }

    public static function getRequestProperties($request)
    {
        $method = self::getProperty(RequestUtil::class, '_method');
        $url = self::getProperty(RequestUtil::class, '_url');
        $params = self::getProperty(RequestUtil::class, '_params');
        $options = self::getProperty(RequestUtil::class, '_options');
        $curlHandle = self::getProperty(RequestUtil::class, '_curlHandle');
        return [
            'method' => $method->getValue($request),
            'url' => curl_getinfo($curlHandle->getValue($request))['url'],
            'params' => $params->getValue($request),
            'options' => isset($options->getValue($request)[CURLOPT_HTTPHEADER])
                ? $options->getValue($request)[CURLOPT_HTTPHEADER]
                : $options->getValue($request)
        ];
    }
}
