<?php

use PHPPDO\DB;

class FixtureTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    private $_oConnection = null;

    public function getConnection()
    {
        if ($this->_oConnection === null) {
            try {
                $oPDO = new \PDO('mysql:host=localhost;dbname=test', 'root', '');
                var_dump($oPDO); exit;
                // $this->_oConnection = $this->createDefaultDBConnection($oPDO, 'test');
            } catch (\PDOException $oException) {
                throw new \PDOException($oException->getMessage());
            }
        }

        return $this->_oConnection;
    }

    public function getDataSet()
    {
        return $this->createXMLDataSet("mockup/users.xml");
    }

    public function testSomething()
    {
        var_dump(DB::i()); exit;
    }
}