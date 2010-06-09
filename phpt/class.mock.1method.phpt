--TEST--
Mock class + method('test')->expectCall(MockFactory::once());
--FILE--
<?php

function __autoload($class)
{
	require_once __DIR__.'/../lib/'.strtr($class, '\\_', '//').'.php';
}

use m4rw3r\MockObject\Factory as MockFactory;

class Foo
{
	function test()
	{
		throw new Exception('FAIL: This should not be run.');
	}
	
	public function original()
	{
		echo __METHOD__."\n";
	}
}


$f = new MockFactory('Foo', array('test'));

$f->method('test')->expectCall(MockFactory::once())->andReturnValue('Foobar');

try
{
	$f->method('original')->expectCall();
}
catch(Exception $e)
{
	// TODO: Proper exception class
	var_dump($e->getMessage());
}

$o = $f->getObject();

for($i = 0; $i < 3; $i++)
{
	echo $i.': ';
	var_dump($f->validateCalls());
	
	try
	{	
		$o->original();
		$o->test();
	}
	catch(Exception $e)
	{
		// TODO: Set proper exception type for the unexpected call
		echo "Unexpected call\n";
	}
}
--EXPECT--
string(39) "The method Foo::original is not mocked."
0: bool(false)
Foo::original
1: bool(true)
Foo::original
Unexpected call
2: bool(false)
Foo::original
Unexpected call