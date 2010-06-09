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
class Callback implements \m4rw3r\MockObject\ResponderInterface
{
	protected $callback;
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public function __construct($callback)
	{
		$this->callback = $callback;
	}
	
	// ------------------------------------------------------------------------
	
	public function respond(array $parameters)
	{
		return call_user_func_array($this->callback, $parameters);
	}
	
	// ------------------------------------------------------------------------
	
	public function __toString()
	{
		// TODO: Proper serialization
		return 'Callback';
	}
}


/* End of file Callback.php */
/* Location: ./m4rw3r/MockObject/Responder */