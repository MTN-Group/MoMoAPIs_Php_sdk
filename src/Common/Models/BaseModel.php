<?php

namespace momopsdk\Common\Models;

use Exception;
use JsonSerializable;
use momopsdk\Common\Exceptions\MobileMoneyException;

/**
 * Class BaseModel
 * @package momopsdk\Common\Models
 */
class BaseModel implements JsonSerializable
{
    // protected $hydratorStrategies;

    // protected $availableCount;

    public function __construct($value = null)
    {
        try {
            if (is_string($value)) {
                $this->hydrate($this->parseJsonString($value));
            }
        } catch (Exception $e) {
            throw new MobileMoneyException($e->getMessage());
        }
    }

    public function getTotalCount()
    {
        return $this->availableCount;
    }

    private function hydrateAttribute($attribute, $value)
    {
        if (isset($this->hydratorStrategies[$attribute])) {
            $strategy = $this->hydratorStrategies[$attribute];
            $value = $strategy->hydrate($value);
        }
        $method =
            'set' .
            str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
        if (is_callable([$this, $method])) {
            $this->$method($value);
        }
    }

    /**
     * Fill the object with data
     *
     * @param object $data
     * @param $context
     * @param object $metaData
     * @return self
     */
    public function hydrate($data, $context = null)
    {
        if (is_string($data)) {
            $data = $this->parseJsonString($data);
        }
        if (is_array($data) && !empty($data)) {
            $objectArray = [];
            foreach ($data as $item) {
                array_push($objectArray, $this->hydrate($item, new $this()));
            }
            return $objectArray;
        } elseif ($data) {
            $context = $context ? $context : $this;
            $context->hydratorStrategies();
            foreach ($data as $attribute => $value) {
                $context->hydrateAttribute($attribute, $value);
            }
            // $context->hydratorStrategies = null;
            return $context;
        }
        return $this;
    }

    public function jsonSerialize()
    {
        return [];
    }

    public function addHydratorStrategy($name, $obj)
    {
        $this->hydratorStrategies[$name] = $obj;
        return $this;
    }

    public function hydratorStrategies()
    {
    }

    protected function filterEmpty($array)
    {
        return array_filter($array, function ($val) {
            return !is_null($val);
        });
    }

    private function parseJsonString($data)
    {
        if (is_string($data)) {
            $decodeJson = json_decode($data);
            if ($decodeJson === false || is_null($decodeJson)) {
                throw new MobileMoneyException('Could not encode JSON');
            }
            return $decodeJson;
        }
        return $data;
    }
}
