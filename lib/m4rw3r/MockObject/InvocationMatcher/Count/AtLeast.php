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
class AtLeast implements \m4rw3r\MockObject\InvocationMatcher\CountInterface
{
	protected $count = 0;
	
	protected $min;
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public function __construct($min)
	{
		$this->min = $min;
	}
	
	// ------------------------------------------------------------------------
	
	public function valid()
	{
		return true;
	}
	
	// ------------------------------------------------------------------------
	
	public function increment()
	{
		$this->count++;
	}
	
	// ------------------------------------------------------------------------
	
	public function isSatisfied()
	{
		return $this->count >= $this->min;
	}
	
	// ------------------------------------------------------------------------
	
	public function __toString()
	{
		return 'at least '.$this->min.' time'.($this->min > 1 ? 's' : '');
	}
}


/* End of file Any.php */
/* Location: ./m4rw3r/MockObject/InvocationMatcher/Count */