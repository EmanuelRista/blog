<?php

require_once 'lib/common.php';
require_once 'connection.php';
$root = getRootPath();

//se ci sono errori di connessione al database
$error = mysqli_connect_errno();

$count = array();

foreach (array('post', 'comment') as $tableName) {
    if (!$error) {
        $query = "SELECT COUNT(*) AS c FROM " . $tableName;
        $stmt = mysqli_query($conn, $query);
        if ($stmt) {
            // We store each count in an associative array
            $count[$tableName] = $stmt->fetch_column();
        }
    }
}

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
        <?php foreach (array('post', 'comment') as $tableName) : ?>
        <?php if (isset($count[$tableName])) : ?>
        <?php // Prints the count 
                    ?>
        <?php echo $count[$tableName] ?> nuovi
        <?php // Prints the name of the thing 
                    ?>
        <?= ($tableName === 'comment') ? 'commenti' : null ?>
        <?= ($tableName === 'post') ? 'post' : null ?>
        sono stati creati.
        <?php endif ?>
        <?php endforeach ?>
    </div>
    <?php endif
    ?>
</body>

</html>