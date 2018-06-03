<?php
namespace PDOProxyTest;

use PDOProxy\PDOStatementInterface;

class PDOMockStatement extends \PDOStatement implements PDOStatementInterface
{
    private $parentArgs = [];
    private $parentMethodName = '';
    
    public function __construct(string $parentMethodName, array $parentArgs)
    {
        $this->parentArgs = $parentArgs;
        $this->parentMethodName = $parentMethodName;
    }
    
    public function getParentArgs() : array
    {
        return $this->parentArgs;
    }
    
    public function getParentMethodName() : string
    {
        return $this->parentMethodName;
    }
    
    public function fetchObject($className = null, $args = null)
    {}

    public function bindParam($parameter, &$variable, $dataType = null, $length = null, $driverOptions = null)
    {}

    public function fetchAll($fetchStyle = null, $fetchArgument = null, $args = null)
    {}

    public function setFetchMode($mode, $params = null)
    {}

    public function debugDumpParams()
    {}

    public function errorCode()
    {}

    public function errorInfo()
    {}

    public function columnCount()
    {}

    public function fetchColumn($columnNumber = null)
    {}

    public function execute($inputParameters = null)
    {}

    public function getColumnMeta($column)
    {}

    public function bindColumn($column, &$param, $type = null, $maxlen = null, $driverData = null)
    {}

    public function setAttribute($attribute, $value)
    {}

    public function getAttribute($attribute)
    {}

    public function nextRowset()
    {}

    public function fetch($fetchStyle = null, $cursorOrientation = null, $cursorOffset = null)
    {}

    public function rowCount()
    {}

    public function bindValue($parameter, $value, $dataType = null)
    {}

    public function closeCursor()
    {}
}

