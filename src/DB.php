<?php

namespace PHPPDO;

class DB
{
    private $_aConfig = [];
    private $_aDBSettings = [];
    private $_aPDOAttributes = [];
    private $_oPDO = null;
    private $_oSth = null;
    private $_iFetchMode = null;
    private $_bConnected = false;
    private $_sLastQuery = '';

    const TYPE_DML_SELECT = 1;
    const TYPE_DML_INSERT = 2;
    const TYPE_DML_UPDATE = 3;
    const TYPE_DML_DELETE = 4;

    const TYPE_ROW_SINGLE = 1;
    const TYPE_ROW_MULTIPLE = 2;

    /**
     * Returns the singleton instance
     *
     * @return static
     */
    public static function i()
    {
        static $instance = null;

        if (null === $instance) $instance = new static();

        return $instance;
    }

    public function __construct()
    {
        $this->_connect();
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    private function _connect()
    {
        $this->_aConfig = require_once 'DB.config.php';
        $this->_aPDOAttributes = $this->_aConfig['PDO_ATTRIBUTES'];
        $this->_aDBSettings = $this->_aConfig['DB_CONFIG'];

        $sDSN = 'mysql:host=' . $this->_aDBSettings['host'] . ';dbname=' . $this->_aDBSettings['dbname'] . ';charset=utf8';

        try {
            $this->_oPDO = new \PDO($sDSN, $this->_aDBSettings['username'], $this->_aDBSettings['password'], $this->_aPDOAttributes);
            $this->_bConnected = true;
        } catch (\PDOException $oException) {
            throw new \PDOException($oException->getMessage());
        }

        return $this->_oPDO;
    }

    public function disconnect()
    {
        return $this->_oPDO = null && $this->_oSth = null && $this->_bConnected = false;
    }

    /**
     * this method executes a query with optional bind parameters, fetch type and fetching number of rows
     *
     * @param   string  $sSQL
     * @param   array   $aBindParams    bind parameters in sql query
     * @param   int     $iFetchType     (optional fetch type) default - PDO::FETCH_ASSOC, @see http://php.net/manual/en/pdostatement.fetch.php
     * @param   int     $iFetchRowType  determines what statement handle uses. either fetch() or fetchAll().
     * @return  mixed
     * */
    private function _query($sSQL = '', $aBindParams = [], $iFetchType = null, $iFetchRowType = self::TYPE_ROW_MULTIPLE)
    {
        if (!$this->_bConnected) $this->_connect();

        try {
            $this->_oSth = $this->_oPDO->prepare($sSQL);
            $this->_sLastQuery = $sSQL;

            if ($iFetchType === null) {
                $iFetchType = ($this->_iFetchMode !== null) ? $this->_iFetchMode: \PDO::FETCH_ASSOC;
            }

            if (is_array($aBindParams) && !empty($aBindParams)) {
                $this->_oSth->execute($aBindParams);
            } else {
                $this->_oSth->execute();
            }

            if ($this->_checkDMLType($sSQL) === self::TYPE_DML_SELECT) {
                return $iFetchRowType == self::TYPE_ROW_MULTIPLE ? $this->_oSth->fetchAll($iFetchType) : $this->_oSth->fetch($iFetchType);
            } else {
                return $this->_oSth->rowCount();
            }

        } catch (\PDOException $oException) {
            throw new \PDOException($oException->getMessage());
        }
    }

    /**
     * Executes `Update`, 'Insert' and 'Delete' queries.
     *
     * @param string $sSQL
     * @param array $aBindParams
     * @return mixed
     */
    public function exec($sSQL = '', $aBindParams = []) 
    {
        return $this->_query($sSQL, $aBindParams);
    }

    /**
     * returns a single row from the results set
     * @see http://php.net/manual/en/pdostatement.fetch.php
     *
     * @param   string  $sSQL
     * @param   array   $aBindParams
     * @param   int     $iFetchType
     * @return  mixed
     * */
    public function fetch($sSQL = '', $aBindParams = [], $iFetchType = null)
    {
        return $this->_query($sSQL, $aBindParams, $iFetchType, self::TYPE_ROW_SINGLE);
    }

    /**
     * returns an array containing all of the result set rows
     * @see http://php.net/manual/en/pdostatement.fetchall.php
     *
     * @param   string  $sSQL
     * @param   array   $aBindParams
     * @param   int     $iFetchType
     * @return  mixed
     * */
    public function fetchRows($sSQL = '', $aBindParams = [], $iFetchType = null)
    {
        return $this->_query($sSQL, $aBindParams, $iFetchType, self::TYPE_ROW_MULTIPLE);
    }

    public function setFetchMode($iFetchType = null)
    {
        if ($iFetchType === null) {
            throw new \InvalidArgumentException("Expected fetch mode is invalid. See all valid fetch mode at http://php.net/manual/en/pdostatement.setfetchmode.php");
        }

        $this->_iFetchMode = $iFetchType;

        return $this;
    }

    public function getRowCount()
    {
        return $this->_oSth->rowCount();
    }

    public function getColumnCount()
    {
        return $this->_oSth->columnCount();
    }

    /**
     * Start a PDO transaction
     *
     * @return PDO beginTransaction method
     * */
    public function beginTransaction()
    {
        return $this->_oPDO->beginTransaction();
    }

    public function commit()
    {
        return $this->_oPDO->commit();
    }

    public function rollBack()
    {
        return $this->_oPDO->rollBack();
    }

    public function getLastId()
    {
        return $this->_oPDO->lastInsertId();
    }

    public function getLastQuery()
    {
        return $this->_sLastQuery;
    }

    /*
     * check what sql DML(data manipulation language) was used (INSERT, UPDATE, DELETE, SELECT).
     *
     * @param string $sSQL
     *
     * @return int
     * */
    private function _checkDMLType($sSQL)
    {
        if (strpos($sSQL, 'SELECT') !== false)
            return self::TYPE_DML_SELECT;
        elseif (strpos($sSQL, 'INSERT') !== false)
            return self::TYPE_DML_INSERT;
        elseif (strpos($sSQL, 'UPDATE') !== false)
            return self::TYPE_DML_UPDATE;
        elseif (strpos($sSQL, 'DELETE') !== false)
            return self::TYPE_DML_DELETE;

        return false;
    }
}