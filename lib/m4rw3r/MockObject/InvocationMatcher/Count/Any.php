<?php
/*
 * Created by Martin Wernståhl on 2010-06-08.
 * Copyright (c) 2010 Martin Wernståhl.
 * All rights reserved.
 */

namespace m4rw3r\MockObject\InvocationMatcher\Count;

/**
 * 
 */
class Any implements \m4rw3r\MockObject\InvocationMatcher\CountInterface
{
	public function valid()
	{
		return true;
	}
	
	// ------------------------------------------------------------------------
	
	public function increment()
	{
		// Intentionally left empty
	}
	
	// ------------------------------------------------------------------------
	
	public function isSatisfied()
	{
		return true;
	}
	
	// ------------------------------------------------------------------------
	
	public function __toString()
	{
		return 'any number of times';
	}
}


/* End of file Any.php */
/* Location: ./m4rw3r/MockObject/InvocationMatcher/Count */