<?php
class Qoute{
    // DB Stuff
    private $conn;
    private $table = 'qoutes';

    // Qoute Properties
    public $id;
    public $qoute;
    public $authorid;
    public $author_name;
    public $categoryid;
    public $category_name;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get Qoute
    public function read(){
         // Create Query
         $query = 'SELECT
         c.name as category_name,
         a.name as author_name,
         q.id, 
         q.quote, 
         q.authorid, 
         q.categoryid
    FROM
         ' . $this->table . ' q
    LEFT JOIN
         authors a  ON q.authorid = a.Id
    LEFT JOIN 
         categories c ON q.categoriesid = c.Id
    ORDER BY
         q.id DESC';

    // Prepare Statement
    $stmt = $this->conn-> prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
    }

    //Get Single Post
    public function read_single(){
        // Create Query
        $query = 'SELECT
        c.name as category_name,
        a.name as author_name,
        q.id, 
        q.quote, 
        q.authorid, 
        q.categoryid
   FROM
        ' . $this->table . ' q
   LEFT JOIN authors a  
        ON q.authorid = a.Id
   LEFT JOIN categories c 
        ON q.categoriesid = c.Id
   WHERE
        q.id = ?
        LIMIT 0,1';


    // Prepare Statement
    $stmt = $this->conn-> prepare($query);

    // Bind ID
     $stmt->bindParam(1, $this -> id);

     //Execute query
     $stmt->execute();

     $row = $stmt->fetch(PDO::FETCH_ASSOC);

     // Set properties
     $this->qoute = $row['qoute'];
     $this -> author = $row['authorid'];
     $this -> author_name = $row['author_name'];
     $this -> category = $row['categoryid'];
     $this -> category_name = $row['category_name'];
        
    }
    // Create Qoute
    public function create() {
        // Create Query
        $query = 'INSERT INTO '. 
           $this -> table . '
        SET
           qoute = :qoute,
           authorId = :authorId,
           categoryId = :categoryId';


        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->qoute = htmlspecialchars(strip_tags($this -> qoute));
        $this -> authorId = htmlspecialchars(strip_tags($this -> authorId));
        $this -> categoryId = htmlspecialchars(strip_tags($this -> categoryId));
        

        // Bind Data
        $stmt->bindParam(':qoute', $this->qoute);
        $stmt -> bindParam(':authorId', $this -> authorId);
        $stmt -> bindParam(':categoryId', $this -> categoryId);
        

        // Execute Query
        if($stmt->execute()) {
        return true;
        }
        
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Update Qoute
    public function update() {
        // Create Query
        $query = 'UPDATE '. 
           $this -> table . '
        SET
           qoute = :qoute,
           authorId = :authorId,
           categoryId = :categoryId
        WHERE
            id = :id';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->qoute = htmlspecialchars(strip_tags($this -> qoute));
        $this->id = htmlspecialchars(strip_tags($this -> id));
        $this -> authorId = htmlspecialchars(strip_tags($this -> authorId));
        $this -> categoryId = htmlspecialchars(strip_tags($this -> categoryId));
    

        // Bind Data
        $stmt->bindParam(':qoute', $this->qoute);
        $stmt->bindParam(':id', $this->id);
        $stmt -> bindParam(':authorId', $this -> authorId);
        $stmt -> bindParam(':categoryId', $this -> categoryId);

        // Execute Query
        if($stmt->execute()) {
        return true;
        }
        
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delelte Post
    // public function delete(){
    //      // Create query
    //      $query = 'DELETE FROM ' . $this -> table . ' WHERE id = :id';

    //      // Prepare Statement
    //      $stmt = $this->conn->prepare($query);
 
    //      // Clean data
    //      $this->id = htmlspecialchars(strip_tags($this->id));
 
    //      // Bind Data
    //      $stmt->bindParam(':id', $this -> id);
 
    //      // Execute Query
    //      if($stmt -> execute()) {
    //          return true;
    //      }
 
    //      // Print error if something goes wrong
    //      printf("Error: %s.\n", $stmt -> error);
 
    //      return false;
    // }
}