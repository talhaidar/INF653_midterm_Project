<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
 

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    //Instantiate DB & Connect
    $database = new Database();
    $db = $database -> connect();

    // Instantiate author object
    $author = new Author($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $author->id = $data->id;

    $author->author = $data->author;


    // Update author
    
    if($author->update()) {
        echo json_encode(
        array('id' => $author->id,
                  'author' => $author->author
            ));
    } else {
        echo json_encode(
            array('message' => 'authorid Not Found')
        );
    }
        exit();
