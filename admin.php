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

<h1>Pannello di Controllo</h1>

<a href="create_post.php"><button class="btn btn-primary add-post-btn d-flex align-items-center"><svg
            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-file-earmark-plus-fill" viewBox="0 0 16 16">
            <path
                d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0z" />
        </svg><span class="ms-2">Crea un nuovo post</span></button></a>

<table class="table table-primary table-striped">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Titolo</th>
            <th colspan="2" scope="col">Operazioni</th>

        </tr>
    </thead>
    <tbody>
        <?php while ($row = $stmt->fetch_assoc()) : ?>
        <tr>
            <th scope="row"> <?php echo htmlEscape($row['id']) ?></th>
            <td> <?php echo htmlEscape($row['title']) ?></td>
            <td>
                <a
                    href="<?php echo 'update_post.php?post_id=' . $row['id'] . '&post_tl=' . $row['title'] . '&post_bd=' . $row['body']; ?>">
                    <button class="btn btn-info">Modifica</button>
                </a>
            </td>
            <td>
                <a href="<?php echo 'delete_post.php?post_id=' . $row['id']; ?>">
                    <button class="btn btn-danger">Elimina</button>
                </a>
            </td>

        </tr>
        <?php endwhile ?>

    </tbody>
</table>

<?php require 'templates/footer.php' ?>
<?php require 'templates/bottom.php' ?>