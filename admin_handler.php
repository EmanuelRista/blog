<?php
require_once 'lib/common.php';
require_once 'connection.php';


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
} else {
    header("location: /blog/admin.php");
    exit();
}

?>

<div class="alert alert-success">
    <strong>Success!</strong> Indicates a successful or positive action.
</div>