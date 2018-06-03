<?php 

namespace PDOProxy;

class PDO extends \PDO
{
    use ProxyHelpers;
    
    /**
     * @var \PDO
     */
    private $pdo;
    
    private function getPDOObject() : \PDO
    {
        return $this->pdo;
    }
    
    /**
     * {@inheritDoc}
     * @see PDO::__construct()
     */
    public function __construct($dsn, $username = null, $passwd = null, $options = null)
    {
        $this->setEventManager(ProxyConfiguration::getEventManager());
        
        $this->pdo = $this->executeCallback(__FUNCTION__, func_get_args(), function($methodName, $args) {
            return new \PDO($args[0], isset($args[1]) ? $args[1] : null, isset($args[2]) ? $args[2] : null, isset($args[3]) ? $args[3] : null);
        });
    }

    /**
     * {@inheritDoc}
     * @see PDO::beginTransaction()
     */
    public function beginTransaction()
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see PDO::commit()
     */
    public function commit()
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see PDO::errorCode()
     */
    public function errorCode()
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see PDO::errorInfo()
     */
    public function errorInfo()
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see PDO::exec()
     */
    public function exec($statement)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see PDO::getAttribute()
     */
    public function getAttribute($attribute)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

//    /**
//     * {@inheritDoc}
//     * @see PDO::getAvailableDrivers()
//     */
//    public static function getAvailableDrivers()
//    {
//        return parent::getAvailableDrivers();
//        //return $this->executeStaticMethod(__METHOD__, func_get_args());
//    }

    /**
     * {@inheritDoc}
     * @see PDO::inTransaction()
     */
    public function inTransaction()
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see PDO::lastInsertId()
     */
    public function lastInsertId($name = null)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see PDO::prepare()
     */
    public function prepare($statement, $driverOptions = null)
    {
        return $this->executeMethodAndWrapIntoStatement(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see PDO::query()
     */
    public function query($statement)
    {
        return $this->executeMethodAndWrapIntoStatement(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see PDO::quote()
     */
    public function quote($string, $parameterType = null)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see PDO::rollBack()
     */
    public function rollBack()
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }

    /**
     * {@inheritDoc}
     * @see PDO::setAttribute()
     */
    public function setAttribute($attribute, $value)
    {
        return $this->executeMethod(__METHOD__, func_get_args());
    }
}