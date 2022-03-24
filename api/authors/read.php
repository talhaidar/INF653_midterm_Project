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

    // author Query
    $result = $author->read();
    // Get Row Count
    $num = $result->rowCount();

    // Check if any Authors
    if($num > 0) {
        // author array
        $authors_arr = array();
        $authors_arr['data'] = array();

        while($row = $result -> fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $author_item = array(
                'id' => $id,
                'author' => $author
            );

            // Push to 'data'
            array_push($authors_arr['data'], $author_item);

        }

        // Turn to JSON & output
        echo json_encode($authors_arr);

    } else {
        // No authors
        echo json_encode(
            array('message' => 'No Authors Found')
        ); 

    }
