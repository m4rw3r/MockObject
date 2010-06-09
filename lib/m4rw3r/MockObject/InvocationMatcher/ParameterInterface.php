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
interface ParameterInterface
{
	
	// ------------------------------------------------------------------------

	/**
	 * Returns true if this parameter is required.
	 * 
	 * @return boolean
	 */
	public function isRequired();
	
	// ------------------------------------------------------------------------

	/**
	 * Returns true if the supplied parameter matches the conditions stored in
	 * this parameter invocation matcher.
	 * 
	 * @return boolean
	 */
	public function matches($parameter);
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public function __toString();
}


/* End of file ParameterInterface.php */
/* Location: ./m4rw3r/MockObject/InvocationMatcher */