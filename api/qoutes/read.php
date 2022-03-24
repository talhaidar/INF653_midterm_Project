<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    

    include_once '../../config/Database.php';
    include_once '../../models/Qoutes.php';

    //Instantiate DB & Connect
    $database = new Database();
    $db = $database -> connect();

    // Instantiate qoute object
    $qoute = new Qoute($db);

    // qoute Query
    $result = $qoute->read();
    // Get Row Count
    $num = $result->rowCount();

    // Check if any Qoutes
    if($num > 0) {
        // Qoute array
        $qoutes_arr = array();
        $qoutes_arr['data'] = array();

        while($row = $result -> fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $author_item = array(
                'id' => $id,
                'qoute' => html_entity_decode($qoute),
                'authorid' => $authorid,
                'author_name' => $author_name,
                'categoryid' => $categoryid,
                'author_name' => $author_name
            );

            // Push to 'data'
            array_push($qoutes_arr['data'], $qoute_item);

        }

        // Turn to JSON & output
        echo json_encode($qoutes_arr);

    } else {
        // No qoutes
        echo json_encode(
            array('message' => 'No Qoutes Found')
        ); 

    }
