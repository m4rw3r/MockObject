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
class Util
{
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public static function renderTemplate($name, array $replaces)
	{
		if( ! file_exists(__DIR__.'/Templates/'.$name.'.tpl.dist'))
		{
			throw new \Exception(sprintf('The template file named "%s.tpl.dist" cannot be found in "%s/Templates/".', $name, __DIR__));
		}
		
		// TODO: Code
	}
	
	// ------------------------------------------------------------------------

	/**
	 * Returns the arguments that the calling method was called by, respects references.
	 * 
	 * @param  int  The number of jumps backwards in the call stack the parameters
	 *              should be taken from.
	 * @return array
	 */
	public static function getParameters($index = 1)
	{
		$stack = debug_backtrace(); 
		$args = array(); 
		
		if (isset($stack[$index]["args"]))
		{ 
			for($i = 0, $c = count($stack[$index]["args"]); $i < $c; $i++)
			{ 
				$args[$i] =& $stack[$index]["args"][$i]; 
			} 
		}
		
		return $args;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public static function implodeParamList(array $parameters)
	{
		$ret = array();
		
		foreach($parameters as $p)
		{
			$ret[] = self::valueToString($p);
		}
		
		return implode(', ', $ret);
	}
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public static function valueToString($value)
	{
		switch(gettype($value))
		{
			case 'object':
				return 'object('.get_class($value).')';
			case 'array':
				return 'array('.count($value).')';
			default:
				return "'$value'";
		}
	}
}


/* End of file Recorder.php */
/* Location: ./m4rw3r/MockObject */