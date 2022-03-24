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

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $category->id = $data->id;

    $category->category = $data->category;


    // Update category
    
    if($category->update()) {
        echo json_encode(
        array('id' => $category->id,
                  'category' => $category->category
            ));
    } else {
        echo json_encode(
            array('message' => 'categroyid Not Found')
        );
    }
        exit();
