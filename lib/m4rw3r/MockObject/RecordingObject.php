<?php
/*
 * Created by Martin Wernståhl on 2010-06-08.
 * Copyright (c) 2010 Martin Wernståhl.
 * All rights reserved.
 */

namespace m4rw3r\MockObject;

/**
 * Basic object which implements the basic recording structure, mainly for testing.
 */
class RecordingObject
{
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public function ___setRecorder(RecorderInterface $rec)
	{
		$this->___recorder = $rec;
	}
	
	// ------------------------------------------------------------------------

	/**
	 * 
	 * 
	 * @return 
	 */
	public function __call($method, $params = array())
	{
		return $this->___recorder->handleMethodCall($method, $params);
	}
}


/* End of file RecordingObject.php */
/* Location: ./m4rw3r/MockObject */