<?php

namespace PDOProxyTest;

use PDOProxy\EventManager;
use PDOProxy\ProxyConfiguration;
use PDOProxy\PDOCommand;
use PDOProxy\PDO;
use PDOProxy\PDOStatement;
use PDOProxy\PDOStatementInterface;

/**
 * 
 * @arunTestsInSeparateProcesses
 *
 */
class PDOStatementEventsTest extends \PHPUnit\Framework\TestCase
{
    public function getMethodParams()
    {
        return [
            ["bindColumn", 
                function(PDOStatementInterface $stm) {
                    $x = "aaA";
                    $stm->bindColumn("column", $x, "type", 11, ["driverData" => 1]);
                }, false
            ],
            ["bindParam",
                function(PDOStatementInterface $stm) {
                    $x = "aaB";
                    $stm->bindParam("column", $x, "type", 11, ["driverData" => 1]);
                }, false
            ],
            
            ["bindValue", ["parameter", "value", "type"], false],
            ["closeCursor", [], false],
            ["columnCount", ["exec"], false],
            ["debugDumpParams", [1], false],
            ["errorCode", [], false],
            ["errorInfo", ["name"], false],
            ["execute", [["params"]], false],
            ["fetch", [1, 2, 3], false, new PDOMockStatement("fetch", [1, 2, 3])],
            ["fetchObject", ["class", 1], false, new PDOMockStatement("fetchObject", ["class", 1])],
            ["fetchAll", [1, "arg", [3]], false],
            ["fetchColumn", [4], false],
            ["getAttribute", ["attribute"], false],
            ["getColumnMeta", ["column"], false],
            ["nextRowset", [], false],
            ["rowCount", [], false],
            ["setAttribute", ["attribute", "value"], false],
            ["setFetchMode", [1, ["params"]], false],
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
        
        $ev->addEventListener("$methodName#pre", function(PDOCommand $command, $eventName) use (&$preExecuted, $params, $methodName, $result) {
            $preExecuted = true;
            if (is_array($params)) {
                $this->assertEquals($params, $command->getArgs());
            }
            $this->assertEquals(strtolower($methodName), strtolower($command->getMethodName()));
            $this->assertEquals(strtolower("$methodName#pre"), $eventName);
            $command->stopPropagation();
            $command->setResult($result);
        });
        
        $ev->addEventListener($methodName, function(PDOCommand $command, $eventName) use (&$postExecuted, $params, $methodName, $result) {
            $postExecuted = true;
            if (is_array($params)) {
                $this->assertEquals($params, $command->getArgs());
            }
            $this->assertEquals(strtolower($methodName), strtolower($command->getMethodName()));
            $this->assertEquals(strtolower($methodName), $eventName);
            $command->stopPropagation();
            $command->setResult($result);
        });
        
        ProxyConfiguration::init($ev);
        
        $pdo = new PDOStatement(new PDOMockStatement($methodName, []), $methodName, []);
        if (is_callable($params)) {
            $result = $params($pdo, $methodName);
        } else {
            $result = call_user_func_array([$isStatic ? PDO::class : $pdo, $methodName], $params);
        }
        $this->assertTrue($preExecuted);
        $this->assertTrue($postExecuted);
    }
}

