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
interface InvocationMatcherInterface
{
	
	// ------------------------------------------------------------------------

	/**
	 * Returns true if this invocation matcher matches the supplied method.
	 * 
	 * @param  string
	 * @return boolean
	 */
	public function matchesMethod($method_name);
	
	// ------------------------------------------------------------------------

	/**
	 * Returns true if the invocation count matcher still has calls to receive.
	 * 
	 * @return boolean
	 */
	public function matchesInvocationCount();
	
	// ------------------------------------------------------------------------

	/**
	 * Returns true if this invocation matcher will match the parameters.
	 * 
	 * @return boolean
	 */
	public function hasParameterMatcher();
	
	// ------------------------------------------------------------------------

	/**
	 * Tells this invocation matcher that an invocation has been made matching it
	 * and if a responder is present, it should return it.
	 * 
	 * @param  array
	 * @return mixed
	 */
	public function invoke(array $parameters);
	
	// ------------------------------------------------------------------------

	/**
	 * Returns true if this invocation matcher has a responder.
	 * 
	 * @return boolean
	 */
	public function hasResponder();
}


/* End of file InvocationMatcherInterface.php */
/* Location: ./m4rw3r/MockObject */