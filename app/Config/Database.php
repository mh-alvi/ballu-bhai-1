<?php

namespace App\Config;

use PDO;
use PDOException;

class DatabaseConnection
{
    private $host = "localhost";
    private $db_name = "oops_auth_db";
    private $username = "root";
    private $password = "password";
    public $conn;


    public function __construct()
    {

        try {
            $conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
