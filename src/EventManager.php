<?php

namespace PDOProxy;

class EventManager
{
    private $eventHandlers = [];
    
    public function raiseEvent(string $name, EventInterface $event) : EventInterface
    {
        if (!isset($this->eventHandlers[$name])) {
            return $event;
        }
        
        foreach ($this->eventHandlers[$name] as $listener) {
            call_user_func($listener, $event, $name, $this);
            if ($event->isPropagationStopped()) {
                break;
            }
        }
        
        return $event;
    }
    
    public function addEventListener($eventName, callable $callback)
    {
        $this->eventHandlers[strtolower($eventName)][] = $callback;
    }
}

