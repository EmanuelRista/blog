<?php

require_once 'connection.php';

// Definisce variabili e le inizializza con valori vuoti
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Quando il form è submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validazione username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Per favore inserisci un Nome Utente.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Il nome utente può contenere soltanto lettere, numeri e underscores.";
    } else {
        // Prepara la query SELECT
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = $mysqli->prepare($sql)) {

            $stmt->bind_param("s", $param_username);

            // Set parametri
            $param_username = trim($_POST["username"]);

            // Tenta di eseguire la query
            if ($stmt->execute()) {
                // store result
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $username_err = "Questo nome utente è già stato preso.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Qualcosa è andato storto. Riprova più tardi.";
            }

            // Chiude lo statement
            $stmt->close();
        }
    }

    // Validazione password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Per favore inserisci una password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "La password deve essere composta da almeno 6 caratteri.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validazione conferma password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Per favore conferma la password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Le due password non corrispondono.";
        }
    }

    // Fa un check di errori dell'input prima di inserire nel database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepara la query di inserimento dati
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if ($stmt = $mysqli->prepare($sql)) {

            $stmt->bind_param("ss", $param_username, $param_password);

            // Set parametri
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Tenta di eseguire la query
            if ($stmt->execute()) {
                $alertDanger = false;
                $alertSuccess = true;
            } else {
                $alertSuccess = false;
                $alertDanger = true;
            }

            // Chiude lo statement
            $stmt->close();
        }
    }

    // Chiude la connessione
    $mysqli->close();
}

include 'templates/head.php';
include 'templates/navbar.php';
?>


<div class="wrapper">
    <h2>Registrazione</h2>
    <p>Compila il form per creare un account.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group mb-3">
            <label>Nome Utente</label>
            <input type="text" name="username"
                class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group mb-3">
            <label>Password</label>
            <input type="password" name="password"
                class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $password; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group mb-3">
            <label>Conferma Password</label>
            <input type="password" name="confirm_password"
                class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $confirm_password; ?>">
            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group mb-3">
            <input type="submit" class="btn btn-primary" value="Registrati">
            <input type="reset" class="btn btn-secondary ml-2" value="Reset">
        </div>
        <?php if (!isset($alertSuccess) && !isset($alertDanger)) { ?>
        <div>
            <p>Hai già un account? <a href="login.php">Accedi qui</a>.</p>
        </div>
        <?php } else if ($alertSuccess === true) { ?>
        <div class="alert alert-success" role="alert">
            L'account è stato creato con successo.
        </div>
        <a href="login.php"><button class="btn btn-secondary">Vai al Login</button></a>
        <?php } ?>
    </form>
</div>

<?php
include 'templates/footer.php';
include 'templates/bottom.php';