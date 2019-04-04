<?php require "includes/header.php"; ?>
<?php if (loggedIn()) { redirect("admin.php"); } ?>
<?php require "includes/nav.php"; ?>
    <div class="jumbotron">
        <h1 class="text-center">Activate</h1>
        <?php
            if (activateUser()) {
                echo "Hi";
            } else {
                echo "Hiiii";
            }
        ?>
    </div>
<?php require "includes/footer.php"; ?>