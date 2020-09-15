<?php

class Note
{
    // DB Stuff
    private $conn;
    private $table = "notes";

    // Note Properties
    public $id;
    public $title;
    public $content;
    public $author;
    public $created_at;
    public $updated_at;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Notes from a Author
    public function read()
    {
        // Create query
        $query = 'SELECT
            n.id,
            n.title,
            n.content,
            n.created_at,
            n.updated_at
            FROM
            ' . $this->table . ' n
            WHERE
            n.author = :author
            ORDER BY
            n.created_at DESC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':author', $this->author);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Note
    public function read_single()
    {
        // Create query
        $query = 'SELECT
            n.title,
            n.content,
            n.created_at,
            n.updated_at
            FROM
            ' . $this->table . ' n
            WHERE
                n.author = :author 
                AND n.id = :id';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->title = $row['title'];
        $this->content = $row['content'];
        $this->created_at = $row['created_at'];
        $this->updated_at = $row['updated_at'];
    }
}
