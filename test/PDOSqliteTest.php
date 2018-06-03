<?php

namespace PDOProxyTest;

use PDOProxy\EventManager;
use PDOProxy\ProxyConfiguration;
use PDOProxy\PDO;
use PDOProxy\PDOStatement;
use PDOProxy\PDOCommand;
use PDOProxy\PDOStatementCommand;

class PDOSqliteTest extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        ProxyConfiguration::init(new EventManager());
    }
    
    public function tearDown()
    {
        ProxyConfiguration::reset();
    }
    
    public function testConnection()
    {
        $pdo = new PDO("sqlite::memory:");
        $stm = $pdo->query("SELECT 1 FROM 1");
        
        $this->assertFalse($stm);
        $this->assertEquals("HY000", $pdo->errorCode());
        
        $stm = $pdo->query("SELECT 1");
        $this->isInstanceOf(PDOStatement::class, $stm); 
    }
    
    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Custom exception
     * @expectedExceptionCode 1234
     */
    public function testQueryInterceptorThrowingException()
    {
        $pdo = new PDO("sqlite::memory:");
        $ev = ProxyConfiguration::getEventManager();
        $ev->addEventListener("query", function(PDOCommand $event) {
            throw new \RuntimeException("Custom exception", 1234);
        });
        
        $pdo->query("SELECT 1");
    }
    
    public function testQueryInterceptorChangingResult()
    {
        $pdo = new PDO("sqlite::memory:");
        $stm = $pdo->query("SELECT 1");
        $result = $stm->fetchColumn(0);
        $this->assertEquals(1, $result);
        
        $ev = ProxyConfiguration::getEventManager();
        $ev->addEventListener("fetchColumn", function(PDOCommand $event) {
            static $counter = 1;
            $event->setResult($event->getResult() + $counter);
            $counter++;
        });
        
        foreach(range(1, 3) as $increment) {
            $stm = $pdo->query("SELECT 1");
            $result = $stm->fetchColumn(0);
            $this->assertEquals(1 + $increment, $result);
        }
    }
    
    public function testQueryInterceptorChangingResultSelectively()
    {
        $ev = ProxyConfiguration::getEventManager();
        $ev->addEventListener("fetchColumn", function(PDOStatementCommand $event) {
            if ($event->getParentArgs()[0] !== "SELECT 2") {
                return;
            }
            static $counter = 1;
            $event->setResult("passed");
            $counter++;
        });
        
        $pdo = new PDO("sqlite::memory:");
        $stm = $pdo->query("SELECT 1");
        $result = $stm->fetchColumn(0);
        $this->assertEquals(1, $result);
            
        $stm = $pdo->query("SELECT 2");
        $result = $stm->fetchColumn(0);
        $this->assertEquals("passed", $result);
        
        $stm = $pdo->query("SELECT 4");
        $result = $stm->fetchColumn(0);
        $this->assertEquals(4, $result);
    }
    
    /**
     * @expectedException \PDOException
     * @expectedExceptionMessage SQLSTATE[HY000] [14] unable to open database file
     */
    public function testInvalidConnection()
    {
        $pdo = new PDO("sqlite::dummy:");
    }
}

