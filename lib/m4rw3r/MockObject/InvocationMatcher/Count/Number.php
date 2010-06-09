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
class Number implements \m4rw3r\MockObject\InvocationMatcher\CountInterface
{
	protected $count = 0;
	
	protected $num;
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public function __construct($num)
	{
		$this->num = $num;
	}
	
	// ------------------------------------------------------------------------
	
	public function valid()
	{
		return $this->count < $this->num;
	}
	
	// ------------------------------------------------------------------------
	
	public function increment()
	{
		$this->count++;
	}
	
	// ------------------------------------------------------------------------
	
	public function isSatisfied()
	{
		return $this->count == $this->num;
	}
	
	// ------------------------------------------------------------------------
	
	public function __toString()
	{
		return $this->num.' time'.($this->num > 1 ? 's' : '');
	}
}


/* End of file Any.php */
/* Location: ./m4rw3r/MockObject/InvocationMatcher/Count */