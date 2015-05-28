<?php

class DB {

    /*
     * database configurations
     *
     * @var array
     * */
    private $_aDBSettings = [];

    /*
     * the PDO object variable that will be used throughout the class
     *
     * @var object
     * */
    private $_oPDO = null;

    /*
     * Statement Handle - the object generated from a execution of a PDO instance
     *
     * @var object
     * */
    private $_oSth = null;

    /*
     * boolean variable if PDO instance is created
     *
     * @var boolean
     * */
    private $_bConnected = false;

    /*
     * last insert id
     *
     * @var int
     * */
    private $_iLastInsertID = 0;

    /*
     * last query
     *
     * @var string
     * */
    private $_sLastQuery= '';

    /*
     * default pdo attributes
     *
     * @var array
     * */
    private $_aPDOAttributes = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    /*
     * variable used for chaining basic CRUD
     *
     * @var int
     * */
    private $_sChainingQuery = "";

    /*
     * bind variables used for chaining basic CRUD
     *
     * @var int
     * */
    private $_sChainingBindParams = [];

    /*
     * types of DML(data manipulation language) in SQL
     *
     * @var int
     * */
    const TYPE_DML_SELECT = 1;
    const TYPE_DML_INSERT = 2;
    const TYPE_DML_UPDATE = 3;
    const TYPE_DML_DELETE = 4;

    /*
     * fetching row types
     *
     * @var int
     * */
    const TYPE_ROW_SINGLE   = 1;
    const TYPE_ROW_MULTIPLE = 2;

    /*
     * constructor method
     *
     * @param array $aPDOAttributes PDO attributres
     * */
    public function __construct($aPDOAttributes = [])
    {
        $this->_aPDOAttributes = $this->_setPDOAttributes($aPDOAttributes);
        $this->_connect();
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    /*
     * this method connects to the database
     *
     * @return PDO instance
     * */
    private function _connect()
    {
        $this->_aDBSettings = parse_ini_file("db_settings.ini.php");

        try {
            $this->_oPDO = new PDO(
                'mysql:host=' . $this->_aDBSettings['host'] .  ';dbname=' . $this->_aDBSettings['dbname'] . ';charset=utf8',
                $this->_aDBSettings['username'],
                $this->_aDBSettings['password'],
                $this->_aPDOAttributes
            );
            $this->_bConnected = true;
            return $this->_oPDO;
        }
        catch(PDOException $oException) {
            throw new PDOException('PDO Exception: ' . $oException->getMessage());
        }

    }

    /*
     * disconnect PDO instance
     *
     * @return bool
     * */
    public function disconnect()
    {
        return $this->_oPDO = null && $this->_oSth = null && $this->_bConnected = false;
    }

    /*
     * this method executes a query with optional bind parameters, fetch type and fetching number of rows
     *
     * @param   string  $sSQL
     * @param   array   $aBindParams    bind parameters in sql query
     * @param   int     $iFetchType     (optional fetch type) default - PDO::FETCH_ASSOC, @see http://php.net/manual/en/pdostatement.fetch.php
     * @param   int     $iFetchRowType  determines what statement handle uses. either fetch() or fechAll().
     * @return  mixed
     * */
    public function query($sSQL = '', $aBindParams = [], $iFetchType = PDO::FETCH_ASSOC, $iFetchRowType = self::TYPE_ROW_MULTIPLE)
    {
        // make sure there is PDO instance
        if(!$this->_bConnected)
            $this->_connect();

        try {
            $this->_oSth        = $this->_oPDO->prepare($sSQL);
            $iDMLType           = $this->_checkDMLType($sSQL);
            $this->_sLastQuery  = $sSQL;

            // execute statement handle with bindparams (if any)
            !empty($aBindParams) ? $this->_oSth->execute($aBindParams): $this->_oSth->execute();

            switch ($iDMLType) {
                case self::TYPE_DML_SELECT:
                    return $iFetchRowType == self::TYPE_ROW_MULTIPLE ? $this->_oSth->fetchAll($iFetchType) : $this->_oSth->fetch($iFetchType);
                    break;

                case self::TYPE_DML_INSERT:
                    $this->_iLastInsertID = $this->_oPDO->lastInsertId();
                    return $this->_oSth->rowCount();
                    break;

                case self::TYPE_DML_UPDATE:
                    return $this->_oSth->rowCount();
                    break;

                case self::TYPE_DML_DELETE:
                    return $this->_oSth->rowCount();
                    break;

                // TODO:: handle also Transaction Control Commands in SQL, in the mean time return only affected rows if not a DML
                default:
                    return $this->_oSth->rowCount();
                    break;
            }

        }
        catch(PDOException $oException) {
            throw new PDOException('PDO Exception: ' . $oException->getMessage());
        }
    }

    /*
     * returns a single row from the results set
     * @see http://php.net/manual/en/pdostatement.fetch.php
     *
     * @param   string  $sSQL
     * @param   array   $aBindParams
     * @param   int     $iFetchType
     * @return  mixed
     * */
    public function fetchRow($sSQL = '', $aBindParams = [], $iFetchType = PDO::FETCH_ASSOC)
    {
        return $this->query($sSQL, $aBindParams, $iFetchType, self::TYPE_ROW_SINGLE);
    }

    /*
     * returns an array containing all of the result set rows
     * @see http://php.net/manual/en/pdostatement.fetchall.php
     *
     * @param   string  $sSQL
     * @param   array   $aBindParams
     * @param   int     $iFetchType
     * @return  mixed
     * */
    public function fetchRows($sSQL = '', $aBindParams = [], $iFetchType = PDO::FETCH_ASSOC)
    {
        return $this->query($sSQL, $aBindParams, $iFetchType, self::TYPE_ROW_MULTIPLE);
    }

    /*
     * builds INSERT query
     *
     * @param   string  $sTable - table name
     * @return  object  this class
     * */
    public function insert($sTable)
    {
        $this->_sChainingQuery = "INSERT INTO $sTable";
        return $this;
    }

    /*
     * builds INSERT IGNORE query
     *
     * @param   string  $sTable - table name
     * @return  object  this class
     * */
    public function insertIgnore($sTable)
    {
        $this->_sChainingQuery = "INSERT IGNORE INTO $sTable";
        return $this;
    }

    /*
     * continue to build INSERT/INSERT IGNORE query
     *
     * @param   array  $aInsertValues
     * @return  mixed
     * */
    public function values($aInsertValues = [])
    {
        $aInsertValuesKeys = array_keys($aInsertValues);

        // add fields on query
        $this->_sChainingQuery .= " (" . implode(", ", $aInsertValuesKeys) . ")";

        // modify insertvalues keys
        foreach ($aInsertValuesKeys as &$sInsertValuesKey) {
            $sInsertValuesKey = ":$sInsertValuesKey";
        }

        // add values on query
        $this->_sChainingQuery .= " VALUES (" . implode(", ", $aInsertValuesKeys) .")";

        // build bindparams
        $this->_sChainingBindParams = [];
        foreach($aInsertValues as $key => $value) {
            $this->_sChainingBindParams[":" . $key] = $value;
        }

        return $this->query($this->_sChainingQuery, $this->_sChainingBindParams);
    }

    /*
     * builds DELETE query
     *
     * @param   string  $sTable - table name
     * @return  object  this class
     * */
    public function delete($sTable)
    {
        $this->_sChainingQuery = "DELETE FROM $sTable";
        return $this;
    }

    /*
     * builds UPDATE query
     *
     * @param   string  $sTable - table name
     * @return  object  this class
     * */
    public function update($sTable)
    {
        $this->_sChainingQuery = "UPDATE $sTable";
        return $this;
    }

    /*
     * builds set values on UPDATE query
     *
     * @param   string  $aUpdateValues
     * @return  object  this class
     * */
    public function set($aUpdateValues)
    {
        // build set
        $this->_sChainingQuery .= " SET";
        $iCountUpdateValues     = count($aUpdateValues);
        $iCounter               = 0;

        // make sure to empty chaining bind params
        $this->_sChainingBindParams = [];

        foreach ($aUpdateValues as $key => $value) {
            $this->_sChainingQuery .= " $key = :$key" . (++$iCounter !== $iCountUpdateValues ? ",": "");
            $this->_sChainingBindParams[":$key"] = $value;
        }

        return $this;
    }

    /*
     * builds WHERE query
     *
     * @param   string  $sWhere       WHERE query
     * @param   array   $aBindParams  bind params
     * @return  mixed
     * */
    public function where($sWhere, $aBindParams)
    {
        $this->_sChainingQuery       .= " WHERE $sWhere";
        $this->_sChainingBindParams  += $aBindParams;
        $iDML                         = $this->_checkDMLType($this->_sChainingQuery);

        switch($iDML) {
            case self::TYPE_DML_DELETE:
                return $this->query($this->_sChainingQuery, $this->_sChainingBindParams);
                break;

            case self::TYPE_DML_UPDATE:
                return $this->query($this->_sChainingQuery, $this->_sChainingBindParams);
                break;

            default:
                break;
        }
    }

    /*
     * return the last inserted id
     *
     * @return int
     * */
    public function getLastInsertID()
    {
        return $this->_iLastInsertID;
    }

    /*
     * return the last query
     *
     * @return string  the last query
     * */
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
        if(strpos($sSQL, 'SELECT') !== false) {
            return self::TYPE_DML_SELECT;
        }
        elseif (strpos($sSQL, 'INSERT') !== false){
            return self::TYPE_DML_INSERT;
        }
        elseif (strpos($sSQL, 'UPDATE') !== false) {
            return self::TYPE_DML_UPDATE;
        }
        elseif (strpos($sSQL, 'DELETE') !== false) {
            return self::TYPE_DML_DELETE;
        }
        return false;
    }

    /*
     * this method overrides/adds default PDO attributes - $_aPDOAttributes
     *
     * @param array $aPDOAttributes
     * @return array
     * */
    private function _setPDOAttributes($aPDOAttributes = [])
    {
        if(!is_array($aPDOAttributes)) {
            throw new Exception('PDO Attributes must be an array.');
        }

        foreach($aPDOAttributes as $key => $value) {
            if(array_key_exists($key, $this->_aPDOAttributes)) {
                $this->_aPDOAttributes[$key] = $value;
            }
        }

        return $this->_aPDOAttributes;
    }
}