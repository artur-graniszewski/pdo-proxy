[![Build Status](https://travis-ci.org/artur-graniszewski/pdo-proxy.svg?branch=master)](https://travis-ci.org/artur-graniszewski/pdo-proxy) [![Coverage Status](https://coveralls.io/repos/github/artur-graniszewski/pdo-proxy/badge.svg?branch=master)](https://coveralls.io/github/artur-graniszewski/pdo-proxy?branch=master) [![Code Climate](https://codeclimate.com/github/artur-graniszewski/pdo-proxy/badges/gpa.svg)](https://codeclimate.com/github/artur-graniszewski/pdo-proxy) [![Percentage of issues still open](http://isitmaintained.com/badge/open/artur-graniszewski/zeus-for-php.svg)](http://isitmaintained.com/project/artur-graniszewski/zeus-for-php "Percentage of issues still open")

# Introduction
*PDO Proxy* is a simple, event-driven PDO wrapper that allows to intercept and alter execution of all PDO methods.

Such feature can be used to:
* selectively (or entirely) mock the PDO functionality for integration tests
* intercept PDO method execution for logging or debugging purposes

# Usage

After installing this library, you must configure the proxy, like so:

```php
<?php

use PDOProxy\EventManager;
use PDOProxy\ProxyConfiguration;
use PDOProxy\PDOCommand;
use PDOProxy\PDO;

$ev = new EventManager();

// you can alter the output of any method, like "__construct", "query", "prepare"...
$ev->addEventListener("query", function(PDOCommand $command, string $eventName) {
    // you can alter the result of any PDO method
    $event->setResult(new PDOMockStatement("query", "SELECT 1");
    $command->stopPropagation();
});

// you can intercept any method, like "__construct", "query", "prepare"...
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