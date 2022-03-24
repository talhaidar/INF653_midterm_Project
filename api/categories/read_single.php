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

    // GET ID
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Category 
    $category->read_single();

    // Create array
    $author_arr = array(
        'id' => $category->id,
        'category' => $category->category
    );

    // Make JSON
    if($category->id !== null) {
        print_r(json_encode($author_arr));
    }
    else {
        echo json_encode(
            array('message' => 'categoryId Not Found')
        );
    }
    exit();