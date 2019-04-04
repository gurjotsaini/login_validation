<?php require "includes/header.php"; ?>
<?php require "includes/nav.php"; ?>
    <div class="jumbotron">
        <?php if (loggedIn()) { echo "Logged In"; } else { redirect("index.php"); } ?>
        <h1 class="text-center">Admin</h1>
    </div>
<?php require "includes/footer.php"; ?>