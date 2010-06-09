<?php
/*
 * Created by Martin Wernståhl on 2010-06-08.
 * Copyright (c) 2010 Martin Wernståhl.
 * All rights reserved.
 */

namespace m4rw3r\MockObject\Responder;

/**
 * 
 */
class Value implements \m4rw3r\MockObject\ResponderInterface
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
	
	public function respond(array $parameters)
	{
		return $this->value;
	}
	
	// ------------------------------------------------------------------------
	
	public function __toString()
	{
		return \m4rw3r\MockObject\Util::valueToString($this->value);
	}
}


/* End of file Value.php */
/* Location: ./m4rw3r/MockObject/Responder */