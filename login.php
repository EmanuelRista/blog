<?php

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: admin.php");
    exit;
}


require_once 'connection.php';

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Per favore inserisci un Nome utente.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Per favore inserisci la tua password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if ($stmt = $mysqli->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: admin.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Nome utente e/o password errati.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Nome utente e/o password errati..";
                }
            } else {
                echo "Oops! Qualcosa ?? andato storto. Riprova pi?? tardi.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $mysqli->close();
}

include 'templates/head.php';
include 'templates/navbar.php';
?>

<div class="wrapper">
    <h2>Login</h2>
    <p>Inserisci le tue credenziali per accedere.</p>

    <?php
    if (!empty($login_err)) {
        echo '<div class="alert alert-danger">' . $login_err . '</div>';
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group mb-3">
            <label>Username</label>
            <input type="text" name="username"
                class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group mb-3">
            <label>Password</label>
            <input type="password" name="password"
                class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group mb-3">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Non hai un account? <a href="sign-in.php">Registrati adesso</a>.</p>
    </form>
</div>


<?php
include 'templates/footer.php';
include 'templates/bottom.php';