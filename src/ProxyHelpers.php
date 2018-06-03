<?php

namespace PDOProxy;

trait ProxyHelpers 
{
    /**
     * @var EventManager
     */
    private $eventManager;
    
    public function setEventManager(EventManager $eventmanager)
    {
        $this->eventManager = $eventmanager;    
    }
    
    /**
     * @param string $methodName
     * @param mixed[] $args
     * @return mixed
     */
    private function executeCallback(string $methodName, array $args, callable $callback)
    {
        if (strpos($methodName, "::")) {
            list($className, $methodName) = explode("::", $methodName);
        }
        
        $eventName = strtolower($methodName);
        $event = $this->eventManager->raiseEvent($eventName . "#pre", 
            $this instanceof PDOStatementInterface ? 
                new PDOStatementCommand($methodName, $args, $this->getParentMethodName(), $this->getParentArgs()) 
                : 
                new PDOCommand($methodName, $args)
            );
        
        if (!$event->isPropagationStopped()) {
            $event->setResult($callback($methodName, $event->getArgs()));
        }
            
        $event = $this->eventManager->raiseEvent($eventName, $event);
        $result = $event->getResult();
        
        return $result;
    }
    
    /**
     * @param string $methodName
     * @param mixed[] $args
     * @return mixed
     */
    private function executeMethod(string $methodName, array $args)
    {
        return $this->executeCallback($methodName, $args, function($methodName, $args) {
            return call_user_func_array([$this->getPDOObject(), $methodName], $args);
        });
    }
    
    /**
     * @param string $methodName
     * @param mixed[] $args
     * @return mixed
     */
    private function executeStaticMethod(string $methodName, array $args)
    {
        return $this->executeCallback($methodName, $args, function($methodName, $args) {
            return call_user_func_array([get_class($this->getPDOObject()), $methodName], $args);
        });
    }
    
    /**
     *
     * @param string $methodName
     * @param mixed[] $args
     * @return \PDOProxy\PDOStatement|\PDOStatement
     */
    private function executeMethodAndWrapIntoStatement(string $methodName, array $args)
    {
        $result = $this->executeMethod($methodName, $args);
        
        if (!$result instanceof \PDOStatement) {
            return $result;
        }
        
        return new PDOStatement($result, $methodName, $args);
    }
}

