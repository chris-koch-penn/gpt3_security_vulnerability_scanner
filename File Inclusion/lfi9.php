<?php     include("../common/header.php");   ?>

<form action="/api/index.php" method="POST">
    <input type="text" name="class">
</form>

<?php
include('includes/class_'.addslashes($_POST['class']).'.php');
?>

