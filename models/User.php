<?php

class User
{
    // DB Stuff
    private $conn;
    private $table = 'users';

    // User Properties
    public $id;
    public $login;
    public $password;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Users
    public function login()
    {
        // Create query
        $query = 'SELECT 
            u.id, 
            u.login 
            FROM 
            ' . $this->table . ' u 
            WHERE
            u.login = :login,
            u.password = :password';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':login', $this->login);
        $stmt->bindParam(':password', $this->password);

        // Execute query
        $stmt->execute();
    }
}
