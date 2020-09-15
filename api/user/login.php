<?php

if (!isset($_POST['login']) && !isset($_POST['password'])) {
} else {
    // Start a session
    session_start();

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instatiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instatiate User Object
    $user = new User($db);

    // Get login
    $user->login = $_POST['login'];

    // Get password
    $user->password = $_POST['password'];

    // Get user
    $user->login();

    // Create array
    $user_arr = array(
        'id' => $user->id,
        'login' => $user->login
    );

    // Put id and login on the Session Storage
    $_SESSION['user'] = $user_arr;
}
