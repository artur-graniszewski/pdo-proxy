<?php
namespace PDOProxy;

interface EventInterface
{
    public function stopPropagation();
    
    public function isPropagationStopped() : bool;
}

