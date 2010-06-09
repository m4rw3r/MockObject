<?php
/*
 * Created by Martin Wernståhl on 2010-06-08.
 * Copyright (c) 2010 Martin Wernståhl.
 * All rights reserved.
 */

namespace m4rw3r\MockObject\Method;

/**
 * 
 */
class Parameter
{
	/**
	 * Flag telling if this parameter is passed by reference.
	 * 
	 * @var boolean
	 */
	protected $is_passed_by_reference = false;
	
	/**
	 * The parameter variable name.
	 * 
	 * @var string
	 */
	protected $name;
	
	/**
	 * A flag telling if we have a default value.
	 * 
	 * @var boolean
	 */
	protected $has_default_value = false;
	
	/**
	 * The default parameter value.
	 * 
	 * @var mixed
	 */
	protected $default_value;
	
	/**
	 * The classname (or "array") which is the type hint.
	 * 
	 * @var string
	 */
	protected $type_hint;
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @param  string|ReflectionParameter
	 * @return 
	 */
	public function __construct($ref)
	{
		// TODO: Enable creation of parameter lists without having a ReflectionParameter instance
		
		$this->is_passed_by_reference = $ref->isPassedByReference();
		$this->name = $ref->getName();
		$this->has_default_value = $ref->isDefaultValueAvailable();
		$this->type_hint = $ref->isArray() ? 'array' : (is_object($ref->getClass()) ? $ref->getClass()->getName() : '');
		
		if($this->has_default_value)
		{
			$this->default_value = $ref->getDefaultValue();
		}
	}
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public function __toString()
	{
		$str  = empty($this->type_class) ? '' : $this->type_class.' ';
		$str .= $this->is_passed_by_reference ? '&' : '';
		$str .= '$'.$this->name;
		
		$this->has_default_value && $str .= ' = '.var_export($this->default_value, true);
		
		return $str;
	}
}


/* End of file Parameter.php */
/* Location: ./m4rw3r/MockObject/Method */