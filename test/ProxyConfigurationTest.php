<?php

namespace PDOProxyTest;

use PDOProxy\EventManager;
use PDOProxy\ProxyConfiguration;

/**
 * 
 * @runTestsInSeparateProcesses
 *
 */
class ProxyConfigurationTest extends \PHPUnit\Framework\TestCase
{
    public function testInit()
    {
        $ev = new EventManager();
        ProxyConfiguration::init($ev);
        $this->assertEquals($ev, ProxyConfiguration::getEventmanager());
    }
    
    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Event Manager not initialized
     */
    public function testUnsetEventManager()
    {
        ProxyConfiguration::getEventmanager();
    }
    
    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Event Manager not initialized
     */
    public function testReset()
    {
        $ev = new EventManager();
        ProxyConfiguration::init($ev);
        $this->assertEquals($ev, ProxyConfiguration::getEventmanager());
        ProxyConfiguration::reset();
        ProxyConfiguration::getEventmanager();
    }
}

