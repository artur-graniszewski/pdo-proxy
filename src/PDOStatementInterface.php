<?php

namespace PDOProxy;

interface PDOStatementInterface
{
    public function getParentArgs() : array;
    
    public function getParentMethodName() : string;
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::bindColumn()
     */
    public function bindColumn($column, &$param, $type = null, $maxlen = null, $driverData = null);
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::bindParam()
     */
    public function bindParam($parameter, &$variable, $dataType = null, $length = null, $driverOptions = null);
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::bindValue()
     */
    public function bindValue($parameter, $value, $dataType = null);
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::closeCursor()
     */
    public function closeCursor();
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::columnCount()
     */
    public function columnCount();
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::debugDumpParams()
     */
    public function debugDumpParams();
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::errorCode()
     */
    public function errorCode();
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::errorInfo()
     */
    public function errorInfo();
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::execute()
     */
    public function execute($inputParameters = null);
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::fetch()
     */
    public function fetch($fetchStyle = null, $cursorOrientation = null, $cursorOffset = null);
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::fetchAll()
     */
    public function fetchAll($fetchStyle = null, $fetchArgument = null, $args = null);
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::fetchColumn()
     */
    public function fetchColumn($columnNumber = null);
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::fetchObject()
     */
    public function fetchObject($className = null, $args = null);
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::getAttribute()
     */
    public function getAttribute($attribute);
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::getColumnMeta()
     */
    public function getColumnMeta($column);
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::nextRowset()
     */
    public function nextRowset();
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::rowCount()
     */
    public function rowCount();
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::setAttribute()
     */
    public function setAttribute($attribute, $value);
    
    /**
     * {@inheritDoc}
     * @see \PDOStatement::setFetchMode()
     */
    public function setFetchMode($mode, $params = null);
}
