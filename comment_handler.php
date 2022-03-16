<?php

require_once 'lib/common.php';
require_once 'connection.php';

require 'templates/head.php';
require 'templates/navbar.php';

if (isset($_POST['submit'])) {

    $postId = $_POST['post_id'];
    $name = $_POST['name'];
    $text = $_POST['text'];
    $createdAt = date('Y-m-d');

    $queryLastRecord = "SELECT * FROM comment ORDER BY id DESC LIMIT 1";
    $resultLastRecord = $conn->query($queryLastRecord);
    $lastRecord = $resultLastRecord->fetch_assoc();
    $lastRecordBody = $lastRecord['text'];

    if ($lastRecordBody !== $text) {
        //qui per evitare mysql injections
        $stmt = $conn->prepare("INSERT INTO comment (post_id, created_at, name, text) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $postId, $createdAt, $name, $text);
        $stmt->execute();
    }

    echo    '<div class="alert alert-success" role="alert">
                Il commento è stato inserito con successo nel database.
            </div>
            <a href="view-post.php?post_id=' . $postId . '"><button class="btn btn-secondary">Torna al post</button></a>';
} else {
    header('location: view-post.php?post_id=' . $postId);
    exit();
}

require 'templates/footer.php';
require 'templates/bottom.php';