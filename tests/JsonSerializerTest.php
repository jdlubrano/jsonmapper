<?php

/**
 * Unit tests for JsonSerializer
 */

require_once 'JsonSerializerTest/SimplePublic.php';
require_once 'JsonSerializerTest/SimplePrivate.php';
require_once 'JsonSerializerTest/ArrayProperties.php';
require_once 'JsonSerializerTest/ObjectProperties.php';
require_once 'JsonSerializerTest/NestedObject.php';

class JsonSerializerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Test for object with simple public members
	 */
	public function testSimplePublic()
	{
		$jum = new JsonSerializer();
		$simplePublic = new JsonSerializerTest_SimplePublic();
		$simplePublic->str = "String";
		$simplePublic->int = 1;
		$simplePublic->float = 1.2;
		$simplePublic->bool = true;
		$simplePublic->null = NULL;

		$this->assertEquals
		(
			'{"str":"String","int":1,"float":1.2,"bool":true,"null":null}', 
			$jum->jsonSerialize($simplePublic)
		);
	}

    /**
     * Test for object with simple private members
     */
    public function testSimplePrivate()
    {
        $jum = new JsonSerializer();
        $simplePrivate = new JsonSerializerTest_SimplePrivate();
        $simplePrivate->setStr('String')
            ->setInt(1)
            ->setFloat(1.2)
            ->setBool(true)
            ->setNull(NULL);

        $this->assertEquals
        (
            '{"str":"String","int":1,"float":1.2,"bool":true,"null":null}',
            $jum->jsonSerialize($simplePrivate)
        );
    }

    /**
     * Test for object with 1D array properties
     */
    public function test1DArrayProperties()
    {
        $jum = new JsonSerializer();
        $arrayProp = new JsonSerializerTest_ArrayProperties();
        $arrayProp->setPrivArray(array(1,2,3))->pubArray = array(4,5,6);

        $this->assertEquals
        (
            '{"pubArray":[4,5,6],"privArray":[1,2,3]}',
            $jum->jsonSerialize($arrayProp)
        );
    }

    /**
     * Test for object with 1D mixed array properties
     */
    public function test1DMixedArrayProperties()
    {
        $jum = new JsonSerializer();
        $arrayProp = new JsonSerializerTest_ArrayProperties();
        $arrayProp->setPrivArray(array("one",2,3.2,false,NULL))->pubArray = array(0,"two",1.2,true);
        
        $this->assertEquals
        (
            '{"pubArray":[0,"two",1.2,true],"privArray":["one",2,3.2,false,null]}',
            $jum->jsonSerialize($arrayProp)
        );
    }

    /**
     * Test for object with 2D array properties
     */
    public function test2DArrayProperties()
    {
        $jum = new JsonSerializer();
        $arrayProp = new JsonSerializerTest_ArrayProperties();
        $arrayProp->setPrivArray(array(array(1,2,3),array(4,5,6)))->pubArray = array(0, array(4,5,6));

        $this->assertEquals
        (
            '{"pubArray":[0,[4,5,6]],"privArray":[[1,2,3],[4,5,6]]}',
            $jum->jsonSerialize($arrayProp)
        );
    }

    /**
     * Test for object with other objects as properties
     */
    public function testSimpleObjectProperties()
    {
        $jum = new JsonSerializer();
        $objProp = new JsonSerializerTest_ObjectProperties();
        
        $privObject = new JsonSerializerTest_SimplePrivate();
        $privObject->setStr('String')
            ->setInt(1)
            ->setFloat(1.2)
            ->setBool(true)
            ->setNull(NULL);

        $objProp->setPrivObj($privObject);

        $pubObject = new JsonSerializerTest_SimplePublic();
        $pubObject->str = 'String';
        $pubObject->int = 2;
        $pubObject->float = 3.4;
        $pubObject->bool = false;
        $pubObject->null = NULL;

        $objProp->pubObj = $pubObject;

        $this->assertEquals
        (
            '{"pubObj":{"str":"String","int":2,"float":3.4,"bool":false,"null":null},'.
            '"privObj":{"str":"String","int":1,"float":1.2,"bool":true,"null":null}}',
            $jum->jsonSerialize($objProp)
        );
    }

    /**
     * Test for object with nested objects as properties
     */
    public function testNestedObjectProperties()
    {
        $jum = new JsonSerializer();
        $nested = new JsonSerializerTest_NestedObject();

        $nested->pubNested = new JsonSerializerTest_NestedObject();
        $nested->setPrivNested(new JsonSerializerTest_NestedObject());

        $innerPubObj = new JsonSerializerTest_SimplePublic();
        $innerPubObj->str = 'Public String';
        $innerPubObj->int = 1;
        $innerPubObj->float = 1.2;
        $innerPubObj->bool = true;
        $innerPubObj->null = NULL;

        $nested->pubNested->pubNested = $innerPubObj;

        $innerPrivObj = new JsonSerializerTest_SimplePrivate();
        $innerPrivObj->setStr('Private String')
            ->setInt(2)
            ->setFloat(2.3)
            ->setBool(false)
            ->setNull(NULL);

        $nested->pubNested->setPrivNested($innerPrivObj);

        $nested->getPrivNested()->pubNested = $innerPubObj;
        $nested->getPrivNested()->setPrivNested($innerPrivObj);

        $this->assertEquals
        (
            '{"pubNested":{"pubNested":{"str":"Public String","int":1,"float":1.2,"bool":true,"null":null},'.
            '"privNested":{"str":"Private String","int":2,"float":2.3,"bool":false,"null":null}},'.
            '"privNested":{"pubNested":{"str":"Public String","int":1,"float":1.2,"bool":true,"null":null},'.
            '"privNested":{"str":"Private String","int":2,"float":2.3,"bool":false,"null":null}}}',
            $jum->jsonSerialize($nested)
        );
    }
}
