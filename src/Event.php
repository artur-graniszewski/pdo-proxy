<?php
namespace PDOProxy;

class Event implements EventInterface
{
    private $isPropagationStopped = false;
    
    public function stopPropagation()
    {
        $this->isPropagationStopped = true;
    }
    
    public function isPropagationStopped() : bool
    {
        return $this->isPropagationStopped;
    }
}

