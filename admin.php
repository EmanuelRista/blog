<?php require 'templates/head.php' ?>
<?php require 'templates/navbar.php' ?>


<main class="container my-5">

    <h1>Pannello di controllo ADMIN</h1>

    <h2>Inserimento post</h2>

    <form id="contact_form" method="post" action="admin_handler.php">
        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input id="title" type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Testo</label>
            <textarea id="body" rows="10" name="body" class="form-control" placeholder="Scrivi qui il tuo post"
                required></textarea>
        </div>
        <input id="submit_btn" name="submit_btn" type="submit" class="btn btn-success"></button>
        <input type="reset" class="btn btn-warning"></button>
        <button type="" class="btn btn-danger">Cancella un post</button>
    </form>

</main>

<?php require 'templates/footer.php' ?>
<?php require 'templates/bottom.php' ?>