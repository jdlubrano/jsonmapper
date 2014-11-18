<?php

/**
 * Unit test helper for JsonSerializer
 */

class JsonSerializerTest_SimplePrivate
{
    private $str;
    private $int;
    private $float;
    private $bool;
    private $null;

    public function __construct(){}

    public function getStr()
    {
        return $this->str;
    }

    public function setStr($str)
    {
        $this->str = $str;
        return $this;
    }

    public function getInt()
    {
        return $this->int;
    }

    public function setInt($int)
    {
        $this->int = $int;
        return $this;
    }

    public function getFloat()
    {
        return $this->float;
    }

    public function setFloat($float)
    {
        $this->float = $float;
        return $this;
    }

    public function getBool()
    {
        return $this->bool;
    }

    public function setBool($bool)
    {
        $this->bool = $bool;
        return $this;
    }

    public function getNull()
    {
        return $this->null;
    }

    public function setNull($null)
    {
        $this->null = $null;
        return $this;
    }
}
