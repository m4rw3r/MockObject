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
class Factory implements RecorderInterface
{
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public static function once()
	{
		return new InvocationMatcher\Count\Number(1);
	}
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public static function any()
	{
		return new InvocationMatcher\Count\Any();
	}
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public static function times($num)
	{
		return new InvocationMatcher\Count\Number($num);
	}
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public static function atLeast($num)
	{
		return new InvocationMatcher\Count\AtLeast($num);
	}
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public static function betweenTimes($min, $max)
	{
		return new InvocationMatcher\Count\Interval($min, $max);
	}
	
	/**
	 * The class name of the base class which the generated class should extend,
	 * null if a plain and generic object should be created.
	 * 
	 * @var string
	 */
	protected $class = null;
	
	/**
	 * A list of interfaces that the class should implement.
	 * 
	 * @var array(string)
	 */
	protected $interfaces = array();
	
	/**
	 * The class name of the generated class, null if a class has not been generated.
	 * 
	 * @var string
	 */
	protected $mock_class = null;
	
	/**
	 * A list of methods which are to be included in the generated class.
	 * 
	 * @var array(\m4rw3r\MockObject\Method)
	 */
	protected $methods = array();
	
	/**
	 * The object which has been created and is linked to this Factory instance,
	 * null if an object has not been created.
	 * 
	 * @var object
	 */
	protected $object = null;
	
	/**
	 * A list of error messages pertaining to unexpected calls, will be used to
	 * check if unexpected calls has been made and to print debug info.
	 * 
	 * @var array(string)
	 */
	protected $unexpected_calls = array();
	
	// ------------------------------------------------------------------------

	/**
	 * Creates a new mock object factory.
	 * 
	 * @param  string
	 * @param  array   A list of method names for which ones to override from
	 *                 the supplied class/interface(s)
	 * @param  array   A list of interface names which the generated class
	 *                 should implement
	 * @return \m4rw3r\MockObject\Factory
	 */
	public function __construct($class_name = null,
	                            array $methods = null,
	                            $interfaces = array())
	{
		$this->class = $class_name;
		$this->interfaces = (Array) $interfaces;
		
		foreach($this->interfaces as $i)
		{
			if(interface_exists($i))
			{
				$ref = new \ReflectionClass($i);
				
				foreach($ref->getMethods() as $method)
				{
					if(is_null($methods) OR in_array($method->getName(), $methods))
					{
						$this->methods[$method->getName()] = new Method($this, $method);
					}
				}
			}
		}
		
		if(class_exists($class_name))
		{
			$ref = new \ReflectionClass($class_name);
			
			if($ref->isFinal())
			{
				throw new \RuntimeException(sprintf('The class "%s" is marked as final, it cannot be mocked.', $class_name));
			}
			
			foreach($ref->getMethods() as $method)
			{
				if(is_null($methods) OR in_array($method->getName(), $methods))
				{
					if($method->isFinal())
					{
						throw new \RuntimeException(sprintf('The method "%s" is marked as final, it cannot be mocked.', $class_name.'::'.$method->getName()));
					}
					
					$this->methods[$method->getName()] = new Method($this, $method);
				}
			}
		}
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Adds a new mock method to the class to be generated.
	 * 
	 * @param  string|ReflectionMethod
	 * @return \m4rw3r\MockObject\Method
	 */
	public function addMethod($name)
	{
		if( ! isset($this->methods[$name]))
		{
			$this->methods[$name] = new Method($this, $name);
		}
		
		return $this->methods[$name];
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Returns the mocked-method handler for the supplied method name.
	 * 
	 * @param  string
	 * @return \m4rw3r\MockObject\Method
	 */
	public function method($name)
	{
		if(isset($this->methods[$name]))
		{
			return $this->methods[$name];
		}
		else
		{
			throw new \RuntimeException(sprintf('The method %s::%s is not mocked.', $this->class, $name));
		}
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Returns the class name of the mock-class, generates the code if it isn't
	 * already generated.
	 * 
	 * @return string
	 */
	public function getMockClass()
	{
		if(is_null($this->mock_class))
		{
			$method_code = array();
			foreach($this->methods as $m)
			{
				$method_code[] = $m->generateCode();
			}
			
			$method_code = implode("\n\n", $method_code);
			
			// Template data except classname, as it is not yet known
			$tdata = array(
				'namespace'  => '', // TODO: Dummy, Add proper code
				'extends'    => empty($this->class) ? '' : ' extends '.$this->class,
				'implements' => empty($this->interfaces) ? '' : ' implements '.implode(', ', $this->interfaces),
				'methods'    => $method_code
				);
			
			// Create mock class name
			$this->mock_class = $c = $this->class.'_'.sha1(serialize($tdata));
			
			// Do we already have this class?
			if( ! class_exists($this->mock_class, false))
			{
				// No, render the class and eval it
				$tdata['classname'] = $c;
				
				// Generate code
				$code = Util::renderTemplate('Class', $tdata);
				
				eval($code);
			}
			
			// Set the recorder for static methods
			$c::___setStaticRecorder($this);
		}
		
		return $this->mock_class;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Returns the new mock object.
	 * 
	 * @return object
	 */
	public function getObject()
	{
		if(is_null($this->object))
		{
			$c = $this->getMockClass();
			
			$this->object = new $c;
			$this->object->___setRecorder($this);
		}
		
		return $this->object;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Adds a matcher object which will validate the calls passed to this
	 * recorder.
	 * 
	 * @return void
	 */
	public function addInvocationMatcher(InvocationMatcherInterface $matcher)
	{
		$this->invocation_matchers[] = $matcher;
	}
	
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
	public function handleMethodCall($method, array $parameters)
	{
		$response = null;
		$got_match = false;
		
		// Find matching invocations
		foreach($this->invocation_matchers as $m)
		{
			/*
			 * Needs to match a method and no filters for parameters,
			 * or match the method and the paramerers.
			 */
			if($m->matchesMethod($method) && ( ! $m->hasParameterMatcher() OR $m->matchesParameters($parameters)) && $m->matchesInvocationCount() && $m->matchesOrder())
			{
				$got_match = true;
				
				$r = $m->invoke($parameters);
				
				$m->hasResponder() && $response = $r;
			}
		}
		
		if( ! $got_match)
		{
			// Set failure
			$this->unexpected_calls[] = $msg = sprintf('Unexpected call to %s::%s with parameters (%s).', $this->mock_class, $method, Util::implodeParamList($parameters));
			
			throw new \RuntimeException($msg);
		}
		
		return $response;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Checks if the calls that has been passed from the mock-object/mock-class
	 * so far has matched the invocation matchers, or if their expectations hasn't been satisfied.
	 * 
	 * @return boolean
	 */
	public function validateCalls()
	{
		if( ! empty($this->unexpected_calls))
		{
			// We've got unexpected calls
			return false;
		}
		
		foreach($this->invocation_matchers as $m)
		{
			if( ! $m->validateCalls())
			{
				return false;
			}
		}
		
		return true;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Returns a text-representation of the expectations, and if they have been
	 * satisfied or not.
	 * 
	 * Example return:
	 * <code>
	 * [PASS]  Match foobar between 3 and 5 times and return 'aaa'
	 * [FAIL]  Match foobar any number of times with ('lol') and return 'LOL'
	 * </code>
	 * 
	 * @param  string  The characters to break rows
	 * @return string
	 */
	public function debugValidateCalls($br = "\n")
	{
		$str = array();
		
		foreach($this->invocation_matchers as $m)
		{
			$str[] = ($m->validateCalls() ? '[PASS]  ' : '[FAIL]  ').$m->__toString();
		}
		
		foreach($this->unexpected_calls as $c)
		{
			$str[] = '[FAIL]  '.$c;
		}
		
		return implode($br, $str);
	}
}


/* End of file MockObjectFactory.php */
/* Location: ../m4rw3r/Mocker */