<?php

/**
 * Unit test helper for JsonSerializer
 */
class JsonSerializerTest_NestedObject
{
    public $pubNested;
    private $privNested;

    public function __construct(){}

    public function getPrivNested()
    {
        return $this->privNested;
    }

    public function setPrivNested($privNested)
    {
        $this->privNested = $privNested;
        return $this;
    }
}
