<?php
require_once 'lib/common.php';
require_once 'connection.php';
$root = getRootPath();

$db = $config['mysql_db'];

isset($_GET['post_id']) ? $postId = $_GET['post_id'] : $postId = 0;

$query = "SELECT title, created_at, body FROM post WHERE id = $postId = 0;";

$stmt = mysqli_query($conn, $query);

if ($stmt === false) {
    throw new Exception('Si è verificato un problema durante la preparazione di questa query');
}

// Let's get a row
$row = $stmt->fetch_assoc();
?>
<!DOCTYPE html>
<html>

<head>
    <title>
        A blog application |
        <?php echo htmlspecialchars($row['title'], ENT_HTML5, 'UTF-8') ?>
    </title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>

<body>
    <?php require 'templates/title.php' ?>
    <h2>
        <?php echo htmlEscape($row['title']) ?>
    </h2>
    <div>
        <?php echo $row['created_at'] ?>
    </div>
    <p>
        <?php echo htmlEscape($row['body']) ?>
    </p>
</body>

</html>