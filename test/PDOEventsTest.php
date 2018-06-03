<?php

namespace PDOProxyTest;

use PDOProxy\EventManager;
use PDOProxy\ProxyConfiguration;
use PDOProxy\PDOCommand;
use PDOProxy\PDO;

class PDOEventsTest extends \PHPUnit\Framework\TestCase
{
    public function getMethodParams()
    {
        return [
             ["beginTransaction", [], false],
             ["commit", [], false],
             ["errorCode", [], false],
             ["errorInfo", [], false],
             ["exec", ["exec"], false],
             ["getAttribute", [1], false],
             //["getAvailableDrivers", [], true],
             ["inTransaction", [], false],
             ["lastInsertId", ["name"], false],
             ["prepare", ["statement", "driverOptions"], false, new PDOMockStatement("prepare", ["statement", "driverOptions"])],
             ["query", ["statement"], false, new PDOMockStatement("query", ["statement"])],
             ["quote", ["string", "parameterType"], false],
             ["rollBack", [], false],
             ["setAttribute", ["attribute", "value"], false]
        ];
    }
    
    /**
     * @dataProvider getMethodParams
     */
    public function testAllMethods($methodName, $params = [], $isStatic, $result = null)
    {
        $this->runMethod($methodName, $params, $isStatic, $result);
    }
    
    /**
     * @dataProvider getMethodParams
     */
    public function testAllMethodsCaseInsensitive($methodName, $params = [], $isStatic, $result = null)
    {
        $methodName = ucfirst($methodName);
        
        $this->runMethod($methodName, $params, $isStatic, $result);
    }
    
    public function runMethod($methodName, $params = [], $isStatic, $result = null)
    {
        $preExecuted = false;
        $postExecuted = false;
        $ev = new EventManager();
        $ev->addEventListener("__construct#pre", function(PDOCommand $command, $eventName) {
            $methodName = "__construct";
            $this->assertEquals(["dummy", "user", "password", ["option1" => 1, "option2" => 2]], $command->getArgs());
            $this->assertEquals($methodName, $command->getMethodName());
            $this->assertEquals("$methodName#pre", $eventName);
            $command->stopPropagation();
        });
        
        $ev->addEventListener("__construct", function(PDOCommand $command, $eventName) {
            $methodName = "__construct";
            $this->assertEquals(["dummy", "user", "password", ["option1" => 1, "option2" => 2]], $command->getArgs());
            $this->assertEquals($methodName, $command->getMethodName());
            $this->assertEquals("$methodName", $eventName);
            $command->stopPropagation();
        });
        
        $ev->addEventListener("$methodName#pre", function(PDOCommand $command, $eventName) use (&$preExecuted, $params, $methodName, $result) {
            $preExecuted = true;
            $this->assertEquals($params, $command->getArgs());
            $this->assertEquals(strtolower($methodName), strtolower($command->getMethodName()));
            $this->assertEquals(strtolower("$methodName#pre"), $eventName);
            $command->stopPropagation();
            $command->setResult($result);
        });
        
        $ev->addEventListener($methodName, function(PDOCommand $command, $eventName) use (&$postExecuted, $params, $methodName, $result) {
            $postExecuted = true;
            $this->assertEquals($params, $command->getArgs());
            $this->assertEquals(strtolower($methodName), strtolower($command->getMethodName()));
            $this->assertEquals(strtolower($methodName), $eventName);
            $command->stopPropagation();
            $command->setResult($result);
        });
        
        ProxyConfiguration::init($ev);
        
        $pdo = new PDO("dummy", "user", "password", ["option1" => 1, "option2" => 2]);
        $result = call_user_func_array([$isStatic ? PDO::class : $pdo, $methodName], $params);
        $this->assertTrue($preExecuted);
        $this->assertTrue($postExecuted);
    }
}

