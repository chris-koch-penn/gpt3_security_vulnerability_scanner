<?php     include("../common/header.php");   ?>

<form action="/api/index.php" method="GET">
    <input type="text" name="class">
</form>

<?php
include('includes/class_'.addslashes($_GET['class']).'.php');
?>

