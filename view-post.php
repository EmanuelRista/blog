<?php
require_once 'lib/common.php';
require_once 'connection.php';
$root = getRootPath();

$db = $config['mysql_db'];

isset($_GET['post_id']) ? $postId = $_GET['post_id'] : $postId = 0;

$query = "SELECT title, created_at, body FROM post WHERE id = $postId";

$stmt = mysqli_query($conn, $query);

if ($stmt === false) {
    throw new Exception('Si è verificato un problema durante la preparazione di questa query');
}

$row = $stmt->fetch_assoc();

$bodyText = htmlEscape($row['body']);
$paraText = str_replace("\n", "</p><p>", $bodyText);

?>
<!DOCTYPE html>
<html>

<?php require 'templates/head.php' ?>
<?php require 'templates/navbar.php' ?>

<h2>
    <?php echo htmlEscape($row['title']) ?>
</h2>
<div>
    <?php echo convertSqlDate($row['created_at']) ?>
</div>
<p>
    <?php echo $paraText ?>
</p>

<h3><?php echo countCommentsForPost($postId) ?> comments</h3>
<?php if (getCommentsForPost($postId)) { ?>
<?php foreach (getCommentsForPost($postId) as $comment) : ?>
<?php // For now, we'll use a horizontal rule-off to split it up a bit 
        ?>
<hr />
<div class="comment">
    <div class="comment-meta">
        Commento scritto da
        <?php echo htmlEscape($comment['name']) ?>
        il
        <?php echo convertSqlDate($comment['created_at']) ?>
    </div>
    <div class="comment-body">
        <?php echo htmlEscape($comment['text']) ?>
    </div>
</div>
<?php endforeach ?>
<?php } ?>
<form method="post" action="comment_handler.php">
    <div class="mb-3 d-none">
        <label for="post_id" class="form-label">ID</label>
        <input type="text" name="post_id" class="form-control" value="<?= $postId ?>">
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input type="text" name="name" class="form-control">
    </div>
    <div class="mb-3">
        <label for="text" class="form-label">Commento</label>
        <div class="form-floating">
            <textarea class="form-control" name="text" placeholder="Leave a comment here"
                id="floatingTextarea"></textarea>
            <label for="floatingTextarea">Lascia qui il tuo commento</label>
        </div>
    </div>
    <button id="submit" name="submit" type="submit" class="btn btn-primary">Submit</button>
</form>

<?php require 'templates/footer.php' ?>
<?php require 'templates/bottom.php' ?>