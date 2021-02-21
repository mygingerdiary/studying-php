<?php

session_start();

class Connection
{
    private $db_conn;
    public $user;

    public function dbConnect()
    {
        require_once 'params.php';

        try {

            $this->db_conn = new PDO("mysql:host=" . $dbhost . ";dbname=" . $dbname, $dbuser, $dbpassword);

            $this->db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            require_once 'User.php';

            $this->user = new User($this->db_conn);

        } catch (PDOException $e) {

            echo 'Conncection failed: ' . $e->getMessage();
        }
    }
}