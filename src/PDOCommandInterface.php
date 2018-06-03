<?php

namespace PDOProxy;

interface PDOCommandInterface extends EventInterface
{
    public function getArgs() : array;

    public function setArgs(array $args);

    public function getMethodName() : string;

    public function getResult();

    public function setResult($result);
}