<?php require 'templates/head.php' ?>
<?php require 'templates/navbar.php' ?>



<?php

// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once 'connection.php';

isset($_GET['post_id']) ? $postId = $_GET['post_id'] : $postId = 0;

$query = "DELETE FROM post WHERE id = '$postId'";

$data = mysqli_query($conn, $query);

if ($data) {
    echo    '<div class="alert alert-success" role="alert">
                Post cancellato con successo dal database.
            </div>
            <a href="admin.php"><button class="btn btn-secondary">Torna al Pannello di Controllo</button></a>';
} else {
    echo    '<div class="alert alert-danger" role="alert">
                Errore di esecuzione della query. Il post non è stato cancellato dal database.
            </div>
            <a href="admin.php"><button class="btn btn-secondary">Torna al Pannello di Controllo</button></a>';
}
?>

<?php require 'templates/footer.php' ?>
<?php require 'templates/bottom.php' ?>