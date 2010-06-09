--TEST--
Mock class
--FILE--
<?php

function __autoload($class)
{
	require_once __DIR__.'/../lib/'.strtr($class, '\\_', '//').'.php';
}

use m4rw3r\MockObject\Factory as MockFactory;

class Foo
{
	function test($fobar)
	{
		throw new Exception('FAIL: This should not be run.');
	}
}


$f = new MockFactory('Foo');

$f->method('test')->expectCall(MockFactory::once())->andReturnCallback(function($fobar)
{
	echo "$fobar\n";
});

$o = $f->getObject();

for($i = 0; $i < 3; $i++)
{
	echo $i.': ';
	var_dump($f->validateCalls());
	
	try
	{
		$o->test($i);
	}
	catch(Exception $e)
	{
		// TODO: Set proper exception type for the unexpected call
		echo "Unexpected call\n";
	}
}
--EXPECT--
0: bool(false)
0
1: bool(true)
Unexpected call
2: bool(false)
Unexpected call