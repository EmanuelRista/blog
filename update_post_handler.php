<?php

// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require 'templates/head.php';
require 'templates/navbar.php';
require_once 'connection.php';

$postId = $_POST['id'];
$postTl = $_POST['title'];
$postBd = $_POST['body'];
$updatedAt = date('Y-m-d');

$query = "UPDATE post SET title='$postTl', body='$postBd', updated_at='$updatedAt' WHERE id='$postId'";

$data = mysqli_query($conn, $query);

if ($data) {
    echo    '<div class="alert alert-success" role="alert">
        Il post è stato modificato con successo nel database.
    </div>
    <a href="admin.php"><button class="btn btn-secondary">Torna al Pannello di Controllo</button></a>';
} else {
    echo    '<div class="alert alert-success" role="alert">
        Errore nell\'esecuzione della query. Il post non è stato modificato nel database.
    </div>
    <a href="admin.php"><button class="btn btn-secondary">Torna al Pannello di Controllo</button></a>';
}


require 'templates/footer.php';
require 'templates/bottom.php';