<?php 
error_reporting(E_ALL);
class Database
{
    private $_servername;
    private $_username;
    private $_password;
    private $_dbname;

    function __construct($server, $uname, $passw, $dn)
    {
        $this->_servername = $server;
        $this->_username = $uname;
        $this->_password = $passw;
        $this->_dbname = $dn;
    }
    public function conn() 
    {
        try 
        {
            $pdo_conn = new PDO("mysql:host=$this->_servername;dbname=$this->_dbname", $this->_username, $this->_password);
            // set the PDO error mode to exception
            $pdo_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<p>Connected successfully</p>";
            return $pdo_conn;
        }
        catch(PDOException $e) 
        {
            echo "Connected Failed: " . $e->getMessage();
        }

    }

}
