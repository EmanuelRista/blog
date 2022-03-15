<?php
require_once 'lib/common.php';
require_once 'connection.php';
require 'templates/head.php';
require 'templates/navbar.php';

if (isset($_POST['submit_btn'])) {

    $title = $_POST['title'];
    $body = $_POST['body'];
    $createdAt = date('Y-m-d');

    $queryLastRecord = "SELECT * FROM post ORDER BY id DESC LIMIT 1";
    $resultLastRecord = $conn->query($queryLastRecord);
    $lastRecord = $resultLastRecord->fetch_assoc();
    $lastRecordBody = $lastRecord['body'];

    if ($lastRecordBody !== $body) {
        //qui per evitare mysql injections
        $stmt = $conn->prepare("INSERT INTO post (title, body, created_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $body, $createdAt);
        $stmt->execute();
    }

    echo    '<div class="alert alert-success" role="alert">
                Il post è stato inserito con successo nel database.
            </div>
            <a href="admin.php"><button class="btn btn-secondary">Torna al Pannello di Controllo</button></a>';
} else {
    header("location: create_post.php");
    exit();
}

require 'templates/footer.php';
require 'templates/bottom.php';