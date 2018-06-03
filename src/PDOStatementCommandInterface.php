<?php

namespace PDOProxy;

interface PDOStatementCommandInterface extends PDOCommandInterface
{
    public function getParentArgs() : array;

    public function setParentArgs(array $args);

    public function getParentMethodName() : string;
}