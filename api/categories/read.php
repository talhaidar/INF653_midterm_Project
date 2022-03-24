<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    //Instantiate DB & Connect
    $database = new Database();
    $db = $database -> connect();

    // Instantiate category object
    $category = new Category($db);

    // category Query
    $result = $category->read();
    // Get Row Count
    $num = $result->rowCount();

    // Check if any Category
    if($num > 0) {
        // category array
        $authors_arr = array();
        $authors_arr['data'] = array();

        while($row = $result -> fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $author_item = array(
                'id' => $id,
                'category' => $category
            );

            // Push to 'data'
            array_push($authors_arr['data'], $author_item);

        }

        // Turn to JSON & output
        echo json_encode($authors_arr);

    } else {
        // No category
        echo json_encode(
            array('message' => 'No Categories Found')
        ); 

    }
