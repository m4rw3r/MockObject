=================
m4rw3r\MockObject
=================

A stand-alone object/class mocking library

Features
========

Done
----

- Return values depending on which parameters that match, importance is ordered
  by invocations to expect method, last invocation has the most important return value
- Validate number of times a method has been called in respect to parameters,
  both parameter dependent counts and parameter independent counters
- Fail if a method was called unexpectedly (throw exception)
- Make it possible to specify specific ordering of calls to specific methods,
  and also method independent ordering

TODO
----

- Return values processed from callbacks
- Parameters passed by reference to callbacks (if the mocked method specifies that)
- Mock an existing class/interface and automatically get
- Generate classes
- Make it possible to switch the exception throwing on/off for the unexpected calls