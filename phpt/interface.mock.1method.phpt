--TEST--
Mock single method of interface with two methods
--FILE--
<?php

function __autoload($class)
{
	require_once __DIR__.'/../lib/'.strtr($class, '\\_', '//').'.php';
}

use m4rw3r\MockObject\Factory as MockFactory;

interface Foo
{
	public function test();
	
	public function original();
}


$f = new MockFactory(null, array('test'), 'Foo');

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
--EXPECTF--
string(36) "The method ::original is not mocked."

Fatal error: Class _%s contains 1 abstract method and must therefore be declared abstract or implement the remaining methods (Foo::original) in %s : eval()'d code on line %d