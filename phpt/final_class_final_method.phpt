--TEST--
Exceptions thrown when class/method is marked as final
--FILE--
<?php

function __autoload($class)
{
	require_once __DIR__.'/../lib/'.strtr($class, '\\_', '//').'.php';
}

use m4rw3r\MockObject\Factory as MockFactory;

final class TestClass
{
	public function test()
	{
		
	}
}

class TestClass2
{
	final public function test()
	{
		
	}
}

try
{
	$f = new MockFactory('TestClass');
}
catch(Exception $e)
{
	// TODO: Proper exception
	var_dump($e->getMessage());
}

try
{
	$f = new MockFactory('TestClass2');
}
catch(Exception $e)
{
	// TODO: Proper exception
	var_dump($e->getMessage());
}

--EXPECT--
string(62) "The class "TestClass" is marked as final, it cannot be mocked."
string(70) "The method "TestClass2::test" is marked as final, it cannot be mocked."