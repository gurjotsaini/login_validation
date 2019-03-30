<?php require "includes/header.php"; ?>
<?php require "includes/nav.php"; ?>
<div class="jumbotron">
    <h1 class="text-center"> Home Page</h1>
</div>
<?php
    $sql =  "SELECT * FROM users";
    $result = query($sql);
    confirmQuery($result);
    $row = fetchArray($result);
    echo $row["username"];
?>
<?php require "includes/footer.php"; ?>