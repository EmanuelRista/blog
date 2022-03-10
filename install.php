<?php

require_once 'lib/common.php';
require_once 'connection.php';
$root = getRootPath();

//se ci sono errori di connessione al database
$error = mysqli_connect_errno();

/* QUANTE ROWS ABBIAMO CREATO */

$query = "SELECT COUNT(*) FROM post;";

// Esegue la query e ne conserva il risultato
$stmt = mysqli_query($conn, $query);

if ($stmt) { //se il risultato c'è
    $count = $stmt->fetch_column(); //come fetch_assoc ma ritorna una stringa
};


?>
<!DOCTYPE html>
<html>

<head>
    <title>Blog installer</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <style type="text/css">
    .box {
        border: 1px dotted silver;
        border-radius: 5px;
        padding: 4px;
    }

    .error {
        background-color: #ff6666;
    }

    .success {
        background-color: #88ff88;
    }
    </style>
</head>

<body>
    <?php if ($error) :
    ?>
    <div class="error box">
        <?php echo 'Connessione al database fallita.'
            ?>
    </div>
    <?php else :
    ?>
    <div class="success box">
        Connessione al database riuscita.
        <?php if ($count) :
            ?>
        <?php echo $count
                ?> nuove righe sono state create.
        <?php endif
            ?>
    </div>
    <?php endif
    ?>
</body>

</html>