--TEST--
addMethod('test')->expectCall(MockFactory::once());
--FILE--
<?php

function __autoload($class)
{
	require_once __DIR__.'/../lib/'.strtr($class, '\\_', '//').'.php';
}

use m4rw3r\MockObject\Factory as MockFactory;

$f = new MockFactory();

$f->addMethod('test')->expectCall(MockFactory::once());

$o = $f->getObject();

for($i = 0; $i < 3; $i++)
{
	echo $i.': ';
	var_dump($f->validateCalls());
	
	try
	{
		$o->test();
	}
	catch(Exception $e)
	{
		// TODO: Set proper exception type for the unexpected call
		echo "Unexpected call\n";
	}
}
--EXPECT--
0: bool(false)
1: bool(true)
Unexpected call
2: bool(false)
Unexpected call