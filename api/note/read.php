<?php

if (!isset($_SESSION['user'])) {
    echo 'You need to be authenticated before going further.';
} else {

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Note.php';

    // Instatiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instatiate Note Object
    $note = new Note($db);

    // Note query
    $result = $note->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any notes
    if ($num > 0) {
        // Note array
        $notes_arr = array();
        $notes_arr['data'] = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $note_item = array(
                'id' => $id,
                'title' => $title,
                'content' => html_entity_decode($content),
                'created_at' => $created_at,
                'updated_at' => $updated_at
            );

            // Push to "data"
            array_push($notes_arr['data'], $note_item);
        }

        // Turn to JSON & Output
        echo json_encode($notes_arr);
    } else {
        // No Notes
        echo json_encode(
            array('message' => 'No Notes Found')
        );
    }
}
