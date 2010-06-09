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
class Interval implements \m4rw3r\MockObject\InvocationMatcher\CountInterface
{
	protected $count = 0;
	
	protected $min;
	
	protected $max;
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public function __construct($min, $max)
	{
		$this->min = $min;
		$this->max = $max;
	}
	
	// ------------------------------------------------------------------------
	
	public function valid()
	{
		return $this->count < $this->max;
	}
	
	// ------------------------------------------------------------------------
	
	public function increment()
	{
		$this->count++;
	}
	
	// ------------------------------------------------------------------------
	
	public function isSatisfied()
	{
		return $this->min <= $this->count && $this->count <= $this->max;
	}
	
	// ------------------------------------------------------------------------
	
	public function __toString()
	{
		return 'between '.$this->min.' and '.$this->max.' times';
	}
}


/* End of file Interval.php */
/* Location: ./m4rw3r/MockObject/InvocationMatcher/Count */