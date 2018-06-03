[![Build Status](https://travis-ci.org/artur-graniszewski/pdo-proxy.svg?branch=master)](https://travis-ci.org/artur-graniszewski/pdo-proxy) [![Coverage Status](https://coveralls.io/repos/github/artur-graniszewski/pdo-proxy/badge.svg?branch=master)](https://coveralls.io/github/artur-graniszewski/pdo-proxy?branch=master) [![Code Climate](https://codeclimate.com/github/artur-graniszewski/pdo-proxy/badges/gpa.svg)](https://codeclimate.com/github/artur-graniszewski/pdo-proxy) [![Percentage of issues still open](http://isitmaintained.com/badge/open/artur-graniszewski/zeus-for-php.svg)](http://isitmaintained.com/project/artur-graniszewski/zeus-for-php "Percentage of issues still open")

# Introduction
*PDO Proxy* is a simple, event-driven PDO wrapper that allows to intercept and alter execution of all PDO methods.

Such feature can be used to:
* selectively (or entirely) mock the PDO functionality for integration tests
* intercept PDO method execution for logging or debugging purposes

# Usage

After installing this library, you must provide the Proxy configuration, like so:

```php
<?php

use PDOProxy\EventManager;
use PDOProxy\ProxyConfiguration;
use PDOProxy\PDOCommand;
use PDOProxy\PDO;

$ev = new EventManager();

// you can alter the output of any method, like "__construct", "query", "prepare"...
// in order to do so, you must pass method name as an event name
$ev->addEventListener("query", function(PDOCommand $command, string $eventName) {
    // you can alter the result of any PDO method
    $event->setResult(new PDOMockStatement("query", "SELECT 1");
    $command->stopPropagation();
});

// you can intercept any method, like "__construct", "query", "prepare"...
// to do so, you must add "#pre" suffix to the event name
$ev->addEventListener("query#pre", function(PDOCommand $command, string $eventName) {
    // if you stop event propagation, the real PDO method won't be executed and the result will be taken from this callback
    if ($command->getArgs()[0] == "SELECT 1") {
        $command->stopPropagation();
    }
});

ProxyConfiguration::init($ev);
```

Now, you can initialize PDOProxy as usual:

```php
<?php

use PDOProxy\PDO;

$pdo = new PDO("dsn", "user", "password", ["option1" => 1, "option2" => 2]);
$result = $pdo->query("SELECT 2");

// [...]
```

## Event types

As demonstrated in code above, each event handler gains access to two parameters, specific ```Event``` object and event name (as string).

Here is an overview of two event types raised by PDO Proxy:

### PDO Command Event:

It is raised on every execution of ```PDOProxy\PDO``` class method

```php
<?php

namespace PDOProxy;

interface PDOCommandInterface
{
    public function getArgs() : array;
    
    public function setArgs(array $args);
    
    public function getMethodName() : string;
    
    public function getResult();
    
    public function setResult($result);
}
```

The ```getArgs()``` and ```setArgs()``` methods allow to fetch and alter input parameters passed to ```PDOProxy\PDO``` method, while ```getMethodName()``` allows to check which ```PDO``` method was executed.


### PDO Statement Command Event

It is raised on every execution of ```PDOProxy\PDOStatement``` class method

```php
<?php

namespace PDOProxy;

interface PDOStatementCommandInterface extends PDOCommandInterface
{   
    public function getParentArgs() : array;
    
    public function setParentArgs(array $args);
    
    public function getParentMethodName() : string;
}
```

The ```getParentArgs()``` and ```setParentArgs()``` methods allow to fetch and alter input parameters passed to ```PDOProxy\PDO``` method that created the given ```PDOProxy\PDOStatement``` object, while ```getParentMethodName()``` allows to check which ```PDO``` method was executed in the first place.

### Generic Event interface

All of which extend the following, generic event interface:

```php
<?php

namespace PDOProxy;

interface EventInterface
{
    public function stopPropagation();
    
    public function isPropagationStopped() : bool;
}
```

The ```stopPropagation()``` method stops further event propagation (resulting in other event listeners not being executed for a given event type). In case of event names suffixed with "#pre" sentence (like "query#pre"), the original PDO/PDOStatement method won't be executed on database, in such case result must be mocked by executing the ```setResult()``` method.

## Proxy configuration

Proxy must be configured by providing an instance of ```PDOProxy\EventManager``` to static ```init()``` method of a ```PDOProxy\ProxyConfiguration``` class (see example above). 

*Please keep in mind that instantiating ```PDOProxy\PDO``` class prior to Proxy configuration results in ```LogicException```*