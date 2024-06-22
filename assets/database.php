<?php
// Include the Medoo library
require_once 'Medoo.php';

use Medoo\Medoo;

class Database
{
    private $database;

    public function __construct()
    {
        try {
            // Initialize the database connection
            $this->database = new Medoo([
                'type' => 'mysql',
                'host' => 'localhost',
                'database' => 'auth',
                'username' => 'root',
                'password' => 'ascent',
                'charset' => 'utf8'
            ]);
        } catch (Exception $e) {
            // Output error message
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->database;
    }
}
?>
