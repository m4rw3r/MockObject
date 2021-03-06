<?php
/*
 * Created by Martin Wernståhl on 2010-06-08.
 * Copyright (c) 2010 Martin Wernståhl.
 * All rights reserved.
 */

namespace m4rw3r\MockObject;

/**
 * Class matching method calls and validates against expectations.
 */
class InvocationMatcher implements InvocationMatcherInterface
{
	/**
	 * A list of parameter matchers, null if it doesn't matter which parameters at all.
	 * 
	 * @var array(InvocationMatcher\ParameterInterface)
	 */
	protected $parameter_matchers = null;
	
	/**
	 * A list of matchers which should be satisfied before this matcher can be run.
	 * 
	 * @var array(InvocationMatcherInterface)
	 */
	protected $before = array();
	
	/**
	 * A list of matchers which shouldn't be satisfied until after this matcher has run.
	 * 
	 * @var array(InvocationMatcher)
	 */
	protected $after = array();
	
	// ------------------------------------------------------------------------

	/**
	 * Creates a new invocation matcher for the method $m and using the counter
	 * $count.
	 * 
	 * @param  \m4rw3r\MockObject\Method
	 * @param  \m4rw3r\MockObject\InvocationMatcher\CountInterface
	 * @return \m4rw3r\MockObject\InvocationMatcherInterface
	 */
	public function __construct(Method $m, InvocationMatcher\CountInterface $count)
	{
		$this->method = $m;
		$this->count_matcher = $count;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Tells which parameters to match in the call, all are made according to position,
	 * default is that they are matched by value.
	 * 
	 * @param  mixed|\m4rw3r\MockObject\InvocationMatcher\ParameterInterface
	 * @param  ...
	 * @return \m4rw3r\MockObject\InvocationMatcherInterface
	 */
	public function with()
	{
		$this->parameter_matchers = array();
		
		foreach(func_get_args() as $arg)
		{
			if($arg instanceof InvocationMatcher\ParameterInterface)
			{
				$this->parameter_matchers[] = $arg;
			}
			else
			{
				$this->parameter_matchers[] = new InvocationMatcher\Parameter\Value($arg);
			}
		}
		
		return $this;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Alias for with().
	 * 
	 * @param  mixed
	 * @param  ...
	 * @return \m4rw3r\MockObject\InvocationMatcherInterface
	 */
	public function withParameters()
	{
		return call_user_func_array(array($this, 'with'), func_get_args());
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Tells the invocation matcher that it should match a call without parameters.
	 * 
	 * @return \m4rw3r\MockObject\InvocationMatcherInterface
	 */
	public function withNoParameters()
	{
		$this->parameter_matchers = array();
		
		return $this;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Tells what this invocation matcher should use to generate the return value
	 * in case an invocation matches.
	 * 
	 * @param  \m4rw3r\MockObject\ResponderInterface
	 * @return \m4rw3r\MockObject\InvocationMatcherInterface
	 */
	public function andReturn(ResponderInterface $response)
	{
		$this->responder = $response;
		
		return $this;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Tells this invocation matcher that it should return the supplied value
	 * if the invocation matches.
	 * 
	 * @param  mixed
	 * @return \m4rw3r\MockObject\InvocationMatcherInterface
	 */
	public function andReturnValue($value)
	{
		return $this->andReturn(new Responder\Value($value));
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Tells this invocation matcher that it should return the response from a
	 * callback if the invocation matches.
	 * 
	 * @param  callback|Closure
	 * @return \m4rw3r\MockObject\InvocationMatcherInterface
	 */
	public function andReturnCallback($callback)
	{
		return $this->andReturn(new Responder\Callback($callback));
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Tells this invocation matcher that it only should be invoked before the
	 * $matcher invocation matcher has been invoked satisfactory.
	 * 
	 * @param  \m4rw3r\MockObject\InvocationMatcherInterface
	 * @return \m4rw3r\MockObject\InvocationMatcherInterface
	 */
	public function before(InvocationMatcherInterface $matcher)
	{
		foreach(func_get_args() as $m)
		{
			if( ! $m instanceof InvocationMatcher)
			{
				throw new \InvalidArgumentException(sprintf('%s: Expecting an \m4rw3r\MockObject\InvocationMatcherInterface, got "%s"', __METHOD__, gettype($m) == 'object' ? get_class($m) : gettype($m)));
			}
			
			/*
			 * The if you read the fluent code, then it says:
			 * method foobar expects call once with 'lol' before $foo_call and returns 'LOL'
			 * and hence the $foo_call should be run after this invocation matcher
			 */
			$this->after[] = $m;
		}
		
		return $this;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Tells this invocation matcher that it only should be invoked after the
	 * $matcher invocation matcher has been invoked satisfactory.
	 * 
	 * @param  \m4rw3r\MockObject\InvocationMatcherInterface
	 * @return \m4rw3r\MockObject\InvocationMatcherInterface
	 */
	public function after(InvocationMatcherInterface $matcher)
	{
		foreach(func_get_args() as $m)
		{
			if( ! $m instanceof InvocationMatcher)
			{
				throw new \InvalidArgumentException(sprintf('%s: Expecting an \m4rw3r\MockObject\InvocationMatcherInterface, got "%s"', __METHOD__, gettype($m) == 'object' ? get_class($m) : gettype($m)));
			}
			
			/*
			 * The if you read the fluent code, then it says:
			 * method foobar expects call once with 'lol' after $foo_call and returns 'LOL'
			 * and hence the $foo_call should be run before this invocation matcher
			 */
			$this->before[] = $m;
		}
		
		return $this;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Returns true if this invocation matcher matches the supplied method.
	 * 
	 * @param  string
	 * @return boolean
	 */
	public function matchesMethod($method_name)
	{
		return $method_name === $this->method->getName();
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Returns true if the invocation count matcher still has calls to receive.
	 * 
	 * @return boolean
	 */
	public function matchesInvocationCount()
	{
		return $this->count_matcher->valid();
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Returns true if this invocation matcher's order (matchers that should be
	 * matched before or after) matches.
	 * 
	 * @return boolean
	 */
	public function matchesOrder()
	{
		foreach($this->after as $b)
		{
			if($b->validateCalls())
			{
				// has run, fail
				return false;
			}
		}
		
		foreach($this->before as $b)
		{
			if( ! $b->validateCalls())
			{
				
				// hasn't run, fail
				return false;
			}
		}
		
		return true;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Returns true if the parameter list satisfies the parameter matchers of
	 * this object.
	 * 
	 * @param  array
	 * @return boolean
	 */
	public function matchesParameters(array $parameter_list)
	{
		if(is_null($this->parameter_matchers))
		{
			// No restrictions on the parameters
			return true;
		}
		
		foreach($this->parameter_matchers as $m)
		{
			if(empty($parameter_list) && $m->isRequired() OR ! $m->matches(array_shift($parameter_list)))
			{
				return false;
			}
		}
		
		// Make sure that the list is not empty, if that is the case, then we have too many parameters
		return empty($parameter_list);
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Returns true if this invocation matcher will match the parameters.
	 * 
	 * @return boolean
	 */
	public function hasParameterMatcher()
	{
		return ! is_null($this->parameter_matchers);
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Tells this invocation matcher that an invocation has been made matching it
	 * and if a responder is present, it should return it.
	 * 
	 * @param  array
	 * @return mixed
	 */
	public function invoke(array $parameters)
	{
		$this->count_matcher->increment();
		
		if(isset($this->responder))
		{
			return $this->responder->respond($parameters);
		}
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Returns true if this invocation matcher has a responder.
	 * 
	 * @return boolean
	 */
	public function hasResponder()
	{
		return ! empty($this->responder);
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Should return true if this invocation matcher is satisfied with all the
	 * invoke()'d calls it has received so far.
	 * 
	 * @return boolean
	 */
	public function validateCalls()
	{
		return $this->count_matcher->isSatisfied();
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Returns the string representation of this invocation matcher, human readable
	 * to easier see what has failed.
	 * 
	 * @return string
	 */
	public function __toString()
	{
		$before = empty($this->after) ? '' : ' before ('.implode(', ', $this->after).')';
		$params = is_null($this->parameter_matchers) ? '' : ' with ('.implode(', ', $this->parameter_matchers).')';
		$return = empty($this->responder) ? '' : ' and return '.$this->responder;
		
		return 'Match '.$this->method->getName().' '.$this->count_matcher->__toString().$before.$params.$return;
	}
}


/* End of file InvocationMatcher.php */
/* Location: ./m4rw3r/MockObject */