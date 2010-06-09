<?php
/*
 * Created by Martin Wernståhl on 2010-06-08.
 * Copyright (c) 2010 Martin Wernståhl.
 * All rights reserved.
 */

namespace m4rw3r\MockObject;

/**
 * 
 */
interface RecorderInterface
{
	/**
	 * Adds a matcher object which will validate the calls passed to this
	 * recorder.
	 * 
	 * @return void
	 */
	public function addInvocationMatcher(InvocationMatcherInterface $matcher);
	
	// ------------------------------------------------------------------------
	
	/**
	 * Handles a method call received from the mock-object/mock-class and
	 * validates it against the registered invocation matchers.
	 * 
	 * This method imitates a method call if it gets a match, and returns the
	 * response which the mock-method will return.
	 * 
	 * @param  string
	 * @param  array
	 * @return mixed
	 */
	public function handleMethodCall($method, array $parameters);
}


/* End of file RecorderInterface.php */
/* Location: ./m4rw3r/MockObject */