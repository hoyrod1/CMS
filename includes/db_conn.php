<?php
/**
 * * @file
 * php version 8.2
 * Database Page for CMS
 * 
 * @category CMS
 * @package  Database_Configuration
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://cms/includes/db_conn.php
 */
error_reporting(E_ALL);
/**
 * Database class
 * 
 * @category Database
 * @package  Database_Class
 * @author   Rodney St.Cloud <hoyrod1@aol.com>
 * @license  STC Media inc
 * @link     https://www.tasks.com/src/Database.php
 */
class Database
{
    //*=========BEGINNING OF PRIVATE PROPERTIES FOR DATABASE CONNECTION===========*//
    // WHEN USING TYPE DECLARATIONS PDO FOR THE private $_conn 
    // PREFIX THE PDO TYPE WITH A ? TO MAKE IT NULLABLE
    private ?PDO $_conn = null;
    private string $_servername;
    private string $_username;
    private string $_password;
    private string $_dbname;
    //*===========ENDING OF PRIVATE PROPERTIES FOR DATABASE CONNECTION============*//

    

    //*=====BEGINNING OF CONSTRUCTOR FOR DATABASE PROPERTY ASSIGNMENT========*//
    /**
     * This constructor assigns the database connecton values
     *
     * @param string $server 
     * @param string $uname 
     * @param string $passw 
     * @param string $dn 
     * 
     * @access public  
     * 
     * @return mixed
     */
    function __construct($server, $uname, $passw, $dn)
    {
        $this->_servername = $server;
        $this->_username   = $uname;
        $this->_password   = $passw;
        $this->_dbname     = $dn;
    }
    //*========ENDING OF CONSTRUCTOR FOR DATABASE PROPERTY ASSIGNMENT===========*//



    //*=================BEGINNING OF DATABASE CONNECTION====================*//
    /**
     * This function connects to the database using PDO  
     * 
     * @access public  
     * 
     * @return mixed
     */
    public function conn()
    {
        try 
        {
            $dsn = "mysql:host=$this->_servername;dbname=$this->_dbname";

            $this->_conn = new PDO($dsn, $this->_username, $this->_password);
            // set the PDO error mode to exception
            $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->_conn;
        }
        catch(PDOException $e) 
        {
            echo "Connected Failed: " . $e->getMessage();
        }

    }

}
