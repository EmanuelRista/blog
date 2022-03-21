<?php
// Initialize the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require 'templates/head.php' ?>
<?php require 'templates/navbar.php' ?>



<?php

require_once 'connection.php';

isset($_GET['post_id']) ? $postId = $_GET['post_id'] : $postId = 0;
isset($_GET['post_tl']) ? $postTl = $_GET['post_tl'] : $postTl = '';
isset($_GET['post_bd']) ? $postBd = $_GET['post_bd'] : $postBd = '';

?>

<h1>Modifica il post</h1>
<form id="contact_form" method="post" action="update_post_handler.php">
    <div class="mb-3 d-none">
        <label for="Id" class="form-label">ID</label>
        <input id="id" type="text" name="id" class="form-control" value="<?= $postId ?>" required>
    </div>
    <div class="mb-3">
        <label for="title" class="form-label">Titolo</label>
        <input id="title" type="text" name="title" class="form-control" value="<?= $postTl ?>" required>
    </div>
    <div class="mb-3">
        <label for="body" class="form-label">Testo</label>
        <textarea id="body" rows="10" name="body" class="form-control" placeholder="Scrivi qui il tuo post"
            required><?= $postBd ?></textarea>
    </div>
    <input id="submit" name="submit" type="submit" value="Modifica" class="btn btn-primary"></input>
    <input type="reset" class="btn btn-warning"></button>
    <a href="/blog/admin.php" class="btn btn-secondary">Torna al Pannello di Controllo</a>
</form>


<?php require 'templates/footer.php' ?>
<?php require 'templates/bottom.php' ?>