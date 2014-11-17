<?php

/**
 * Unit test helper for JsonUnmapper
 */

class JsonUnmapperTest_ArrayProperties
{
    public $pubArray;
    private $privArray;

    public function __construct(){}

    public function getPrivArray()
    {
        return $this->privArray;
    }

    public function setPrivArray(array $privArray)
    {
        $this->privArray = $privArray;
        return $this;
    }
}
