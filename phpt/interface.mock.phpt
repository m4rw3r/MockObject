--TEST--
Mock interface
--FILE--
<?php

function __autoload($class)
{
	require_once __DIR__.'/../lib/'.strtr($class, '\\_', '//').'.php';
}

use m4rw3r\MockObject\Factory as MockFactory;

interface Foo
{
	function test($fobar);
}


$f = new MockFactory(null, null, array('Foo'));

$f->method('test')->expectCall(MockFactory::once())->andReturnCallback(function($fobar)
{
	echo "$fobar\n";
});

$o = $f->getObject();

echo 'instance: ';
var_dump($o instanceof Foo);

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
instance: bool(true)
0: bool(false)
0
1: bool(true)
Unexpected call
2: bool(false)
Unexpected call