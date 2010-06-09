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
interface ResponderInterface
{
	public function respond(array $parameters);
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public function __toString();
}


/* End of file RecorderInterface.php */
/* Location: ./m4rw3r/MockObject */