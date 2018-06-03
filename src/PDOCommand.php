<?php
namespace PDOProxy;

class PDOCommand extends Event implements PDOCommandInterface
{
    private $methodName;
    
    private $args;
    
    private $result;
    
    public function __construct(string $methodName, array $args)
    {
        $this->methodName = $methodName;
        $this->args = $args;
    }
    
    public function getArgs() : array
    {
        return $this->args;
    }
    
    public function setArgs(array $args)
    {
        $this->args = $args;
    }
    
    public function getMethodName() : string
    {
        return $this->methodName;
    }
    
    public function getResult()
    {
        return $this->result;
    }
    
    public function setResult($result)
    {
        $this->result = $result;
    }
}

