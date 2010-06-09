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
class Method
{
	protected $name;
	
	protected $visibility = 'public';
	
	protected $is_static = false;
	
	protected $parent;
	
	/**
	 * Creates a new mock-method factory.
	 * 
	 * @param  string|ReflectionMethod
	 */
	function __construct(Factory $parent, $ref)
	{
		$this->parent = $parent;
		
		if($ref instanceof ReflectionMethod)
		{
			// TODO: Check final, and skip them with a warning
			$this->name       = $ref->getName();
			$this->visibility = $ref->isPublic() ? 'public' : ($ref->isProtected() ? 'protected' : 'private');
			$this->is_static  = $ref->isStatic();
			
			// TODO: Handle parameter list
		}
		elseif(is_string($ref))
		{
			$this->name = $ref;
		}
		else
		{
			throw new \UnexpectedArgumentException(sprintf('Expected string or ReflectionMethod, received "%s"', gettype($ref) == 'object' ? get_class($ref) : gettype($ref)));
		}
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Sets the name of this mocked method.
	 * 
	 * @return \m4rw3r\MockObject\Method
	 */
	public function setName($name)
	{
		$this->name = $name;
		
		return $this;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Returns the name of the mocked method.
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Sets the visibility of this mocked method.
	 * 
	 * @return \m4rw3r\MockObject\Method
	 */
	public function setVisibility($str)
	{
		// TODO: Validate
		$this->visibility = $str;
		
		return $this;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Returns the visibility of this method.
	 * 
	 * @return string
	 */
	public function getVisibility()
	{
		return $this->visibility;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return \m4rw3r\MockObject\InvocationMatcher
	 */
	public function expectCall(InvocationMatcher\CountInterface $count = null)
	{
		if(is_null($count))
		{
			$count = new InvocationMatcher\Count\AtLeast(1);
		}
		
		$this->parent->addInvocationMatcher($m = new InvocationMatcher($this, $count));
		
		return $m;
	}
}


/* End of file Method.php */
/* Location: ./m4rw3r/MockObject */