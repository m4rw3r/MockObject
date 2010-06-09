--TEST--
Mock class w. 2 methods, only specify matcher for one
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


$f = new MockFactory('Foo');

$f->method('test')->expectCall(MockFactory::once())->andReturnValue('Foobar');

$o = $f->getObject();

var_dump($o->test());
try
{
	var_dump($o->original());
}
catch(Exception $e)
{
	// TODO: Proper exception class
	var_dump($e->getMessage());
}
--EXPECTF--
string(6) "Foobar"
string(%d) "Unexpected call to Foo_%s::original with parameters ()."