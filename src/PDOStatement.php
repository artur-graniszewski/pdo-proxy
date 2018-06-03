<?php

namespace PDOProxy;

class PDOStatement extends \PDOStatement implements PDOStatementInterface
{
    use ProxyHelpers;
    
    /**
     * @var \PDOStatement
     */
    private $pdo;
    
    /**
     * @var mixed[]
     */
    private $parentArgs;
    
    /**
     * @var string
     */
    private $parentMethodName;
    
    private function getPDOObject() : \PDOStatement
    {
        return $this->pdo;
    }
    
    public function getParentArgs() : array
    {
        return $this->parentArgs;
    }
    
    public function getParentMethodName() : string
    {
        return $this->parentMethodName;
    }
    
    public function __construct(\PDOStatement $statement, string $parentMethodName, array $parentArgs = [])
    {
        $this->setEventManager(ProxyConfiguration::getEventManager());
        $this->parentArgs = $parentArgs;
        $this->parentMethodName = $parentMethodName;
        $this->pdo = $statement;
    }
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::bindColumn()
     */
    public function bindColumn($column, &$param, $type = null, $maxlen = null, $driverData = null)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::bindParam()
     */
    public function bindParam($parameter, &$variable, $dataType = null, $length = null, $driverOptions = null)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::bindValue()
     */
    public function bindValue($parameter, $value, $dataType = null)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::closeCursor()
     */
    public function closeCursor()
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::columnCount()
     */
    public function columnCount()
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::debugDumpParams()
     */
    public function debugDumpParams()
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::errorCode()
     */
    public function errorCode()
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::errorInfo()
     */
    public function errorInfo()
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::execute()
     */
    public function execute($inputParameters = null)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::fetch()
     */
    public function fetch($fetchStyle = null, $cursorOrientation = null, $cursorOffset = null)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::fetchAll()
     */
    public function fetchAll($fetchStyle = null, $fetchArgument = null, $args = null)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::fetchColumn()
     */
    public function fetchColumn($columnNumber = null)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::fetchObject()
     */
    public function fetchObject($className = null, $args = null)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::getAttribute()
     */
    public function getAttribute($attribute)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::getColumnMeta()
     */
    public function getColumnMeta($column)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::nextRowset()
     */
    public function nextRowset()
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::rowCount()
     */
    public function rowCount()
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::setAttribute()
     */
    public function setAttribute($attribute, $value)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see \PDOStatement::setFetchMode()
     */
    public function setFetchMode($mode, $params = null)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }
}
