<?php require 'templates/head.php' ?>
<?php require 'templates/navbar.php' ?>


<h1>Inserisci un post</h1>

<form id="contact_form" method="post" action="create_post_handler.php">
    <div class="mb-3">
        <label for="title" class="form-label">Titolo</label>
        <input id="title" type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="body" class="form-label">Testo</label>
        <textarea id="body" rows="10" name="body" class="form-control" placeholder="Scrivi qui il tuo post"
            required></textarea>
    </div>
    <button id="submit_btn" name="submit_btn" type="submit" class="btn btn-success">Crea</button>
    <input type="reset" class="btn btn-warning"></button>
    <a href="/blog/admin.php" class="btn btn-secondary">Torna al Pannello di Controllo</a>
</form>


<?php require 'templates/footer.php' ?>
<?php require 'templates/bottom.php' ?>