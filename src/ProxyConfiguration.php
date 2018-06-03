<?php

namespace PDOProxy;

class ProxyConfiguration
{
    /**
     * @var EventManager
     */
    private static $eventManager;
    
    public static function init(EventManager $eventManager)
    {
        self::$eventManager = $eventManager;
    }
    
    public static function reset()
    {
        self::$eventManager = null;
    }
    
    public static function getEventManager() : EventManager
    {
        if (!isset(self::$eventManager)) {
            throw new \LogicException("Event Manager not initialized");
        }
        return self::$eventManager;
    }
}

