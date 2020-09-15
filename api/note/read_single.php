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

    // Get ID
    $note->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Author
    $note->author = isset($_SESSION['user']);

    // Get Note
    $note->read_single();

    // Create array
    $note_arr = array(
        'id' => $note->id,
        'title' => $note->title,
        'content' => $note->content,
        'created_at' => $note->created_at,
        'updated_at' => $note->updated_at
    );

    // Make JSON 
    print_r(json_encode($note_arr));
}
