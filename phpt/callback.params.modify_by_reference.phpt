--TEST--
addMethod('test')->expectCall(MockFactory::once());
--FILE--
<?php

function __autoload($class)
{
	require_once __DIR__.'/../lib/'.strtr($class, '\\_', '//').'.php';
}

use m4rw3r\MockObject\Factory as MockFactory;

class TestClass
{
	public function test(&$ref)
	{
		throw new Exception('FAIL: Shoud not run!');
	}
}

$f = new MockFactory('TestClass');

$f->method('test')->expectCall(MockFactory::once())->andReturnCallback(function(&$ref)
{
	$ref[] = 'lol';
	
	return 'bar';
});

$o = $f->getObject();

$arr = array();

echo '0: ';
var_dump($f->validateCalls());

echo 'call: ';
var_dump($o->test($arr));

echo '$arr = ';
var_dump($arr);

echo '1: ';
var_dump($f->validateCalls());


--EXPECT--
0: bool(false)
call: string(3) "bar"
$arr = array(1) {
  [0]=>
  string(3) "lol"
}
1: bool(true)