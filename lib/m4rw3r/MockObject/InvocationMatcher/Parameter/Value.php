<?php
/*
 * Created by Martin Wernståhl on 2010-06-08.
 * Copyright (c) 2010 Martin Wernståhl.
 * All rights reserved.
 */

namespace m4rw3r\MockObject\InvocationMatcher\Parameter;

/**
 * 
 */
class Value implements \m4rw3r\MockObject\InvocationMatcher\ParameterInterface
{
	protected $value;
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public function __construct($value)
	{
		$this->value = $value;
	}
	
	// ------------------------------------------------------------------------
	
	public function isRequired()
	{
		// TODO: Make it possible to set if this parameter is required or not, make it automatic if the mocked method has a reflection
		return true;
	}
	
	// ------------------------------------------------------------------------
	
	public function matches($parameter)
	{
		// TODO: Better comparison?
		return $parameter == $this->value;
	}
	
	// ------------------------------------------------------------------------
	
	public function __toString()
	{
		return \m4rw3r\MockObject\Util::valueToString($this->value);
	}
}


/* End of file Value.php */
/* Location: ./m4rw3r/MockObject/InvocationMatcher/Parameter */