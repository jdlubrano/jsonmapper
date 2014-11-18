<?php

/**
 * Unit test helper for JsonSerializer
 */

class JsonSerializerTest_ObjectProperties
{
    public $pubObj;
    private $privObj;

    public function __construct(){}

    public function getPrivObj()
    {
        return $this->privObj;
    }

    public function setPrivObj($privObj)
    {
        $this->privObj = $privObj;
        return $this;
    }
}
