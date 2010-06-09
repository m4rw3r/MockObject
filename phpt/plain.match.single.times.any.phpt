--TEST--
addMethod('test')->expectCall(MockFactory::any());
--FILE--
<?php

function __autoload($class)
{
	require_once __DIR__.'/../lib/'.strtr($class, '\\_', '//').'.php';
}

use m4rw3r\MockObject\Factory as MockFactory;

$f = new MockFactory();

$f->addMethod('test')->expectCall(MockFactory::any());

$o = $f->getObject();

for($i = 0; $i < 4; $i++)
{
	echo $i.': ';
	var_dump($f->validateCalls());
	
	$o->test();
}
--EXPECT--
0: bool(true)
1: bool(true)
2: bool(true)
3: bool(true)
