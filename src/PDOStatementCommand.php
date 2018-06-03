<?php 

namespace PDOProxy;

class PDOStatementCommand extends PDOCommand implements PDOStatementCommandInterface
{
    private $parentMethodName = '';
    
    private $parentArgs = [];
    
    public function __construct(string $methodName, array $args, string $parentMethodName, array $parentArgs)
    {
        parent::__construct($methodName, $args);
        
        $this->parentArgs = $parentArgs;
        $this->parentMethodName = $parentMethodName;
    }
    
    public function getParentMethodName() : string
    {
        return $this->parentMethodName;
    }
    
    public function setParentArgs(array $args)
    {
        $this->parentArgs = $args;
    }
    
    public function getParentArgs() : array
    {
        return $this->parentArgs;
    }
}