<?php
class DbConnection
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "assignment_dlwss502";

    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->db);

        if ($this->conn->connect_error) {
            die("Connection to database failed: " . $this->conn->connect_error);
        }
    }

}

