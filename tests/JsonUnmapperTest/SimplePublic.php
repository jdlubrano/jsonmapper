<?php

/**
 * Unit test helper class for testing public
 * property mapping
 */

class JsonUnmapperTest_SimplePublic
{
	/**
	 * @var string
	 */
	public $str;

	/**
	 * @var int
	 */
	public $int;

	/**
	 * @var float
	 */
	public $float;

	/**
	 * @var boolean
	 */
	public $bool;

	/**
	 * @var NULL
	 */
	public $null;

    public function __construct(){}

	public function getStr()
	{
		return 'This is the wrong $str value';
	}

}
