<?php
/*
 * Created by Martin Wernståhl on 2010-06-08.
 * Copyright (c) 2010 Martin Wernståhl.
 * All rights reserved.
 */

namespace m4rw3r\MockObject\InvocationMatcher;

/**
 * 
 */
interface CountInterface
{
	
	// ------------------------------------------------------------------------

	/**
	 * Returns true if this invocation count matcher's method still is allowed
	 * to be invoked, ie. if it hasn't yet been called the max amount of times.
	 * 
	 * @return boolean
	 */
	public function valid();
	
	// ------------------------------------------------------------------------

	/**
	 * Tells this invocation count matcher that a call has been passed to the
	 * method.
	 * 
	 * @return void
	 */
	public function increment();
	
	// ------------------------------------------------------------------------

	/**
	 * Method which returns true if this invocation count matcher has passed its
	 * internal test, called after all methods has been called on the mocked obejct.
	 * 
	 * @return boolean
	 */
	public function isSatisfied();
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public function __toString();
}


/* End of file CountInterface.php */
/* Location: ./m4rw3r/MockObject/InvocationMatcher */