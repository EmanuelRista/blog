<?php
// Work out the path to the database, so SQLite/PDO can connect
require_once 'lib/common.php';
require_once 'connection.php';
$root = getRootPath();

// esegue una query, gestisce eventuali errori

$query = 'SELECT id, title, created_at, body FROM post ORDER BY created_at DESC';

$stmt = mysqli_query($conn, $query);

if ($stmt === false) {
    throw new Exception('Si è verificato un problema durante l\'esecuzione di questa query');
}
?>

<?php require 'templates/head.php' ?>
<?php require 'templates/navbar.php' ?>
<?php require 'templates/title.php' ?>

<!-- Finchè ci sono righe da postare, postale -->
<?php while ($row = $stmt->fetch_assoc()) : ?>
<h2>
    <?php echo htmlEscape($row['title']) ?>
</h2>
<div>
    <?php echo convertSqlDate($row['created_at']) ?>
</div>
<p>
    <?php echo htmlEscape($row['body']) ?>

    <!--  La ragione di htmlspecialchars è che, se l'input dell'utente (il titolo di un blog o un post di blog in questo caso) contiene parentesi angolari, potrebbe interrompere l'HTML utilizzato nel layout della pagina e, peggio ancora, potrebbe consentire a un utente di iniettare JavaScript non autorizzato che verrebbe eseguito. ATTENZIONE: sostituito con funzione htmlEscape -->
    (<?php echo countCommentsForPost($row['id']) ?> comments)
</p>
<p>
    <a href="view-post.php?post_id=<?php echo $row['id'] ?>">Read more...</a>
</p>
<?php endwhile ?>
<?php require 'templates/footer.php' ?>
<?php require 'templates/bottom.php' ?>