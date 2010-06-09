--TEST--
addMethod('test')->expectCall(MockFactory::times(2));
--FILE--
<?php

function __autoload($class)
{
	require_once __DIR__.'/../lib/'.strtr($class, '\\_', '//').'.php';
}

use m4rw3r\MockObject\Factory as MockFactory;

$f = new MockFactory();

$f->addMethod('test')->expectCall(MockFactory::times(2));

$o = $f->getObject();

for($i = 0; $i < 4; $i++)
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
1: bool(false)
2: bool(true)
Unexpected call
3: bool(false)
Unexpected call
