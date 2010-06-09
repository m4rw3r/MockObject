--TEST--
Test before() $l = $f->addMethod('test')->expectCall()->with('lol'); $f->method('test')->expectCall(MockFactory::once())->before($l);
--FILE--
<?php

function __autoload($class)
{
	require_once __DIR__.'/../lib/'.strtr($class, '\\_', '//').'.php';
}

use m4rw3r\MockObject\Factory as MockFactory;

$f = new MockFactory();

$l = $f->addMethod('test')->expectCall()->with('lol');
$f->addMethod('test')->expectCall(MockFactory::once())->before($l);

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

echo "===\n";

$f = new MockFactory();

$l = $f->addMethod('test')->expectCall()->with('lol');
$f->method('test')->expectCall(MockFactory::once())->before($l);

$o = $f->getObject();

$arr = array(function($o)
{
	$o->test();
}, function($o)
{
	$o->test('lol');
}, function($o)
{
	$o->test('lol');
});

foreach($arr as $i => $c)
{
	echo $i.': ';
	var_dump($f->validateCalls());
	
	try
	{
		$c($o);
	}
	catch(Exception $e)
	{
		// TODO: Set proper exception type for the unexpected call
		echo "Unexpected call\n";
	}
}

echo "===\n";

$f = new MockFactory();

$l = $f->addMethod('test')->expectCall()->with('lol');
$f->method('test')->expectCall(MockFactory::once())->before($l);

$o = $f->getObject();

$arr = array(function($o)
{
	$o->test('lol');
}, function($o)
{
	$o->test();
}, function($o)
{
	$o->test('lol');
});

foreach($arr as $i => $c)
{
	echo $i.': ';
	var_dump($f->validateCalls());
	
	try
	{
		$c($o);
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
Unexpected call
2: bool(false)
Unexpected call
===
0: bool(false)
1: bool(false)
2: bool(true)
===
0: bool(false)
1: bool(false)
Unexpected call
2: bool(false)