<?php     include("../common/header.php");   ?>

<form action="/api/index.php" method="GET">
    <input type="text" name="library">
</form>

<?php
include("includes/".$_GET['library'].".php"); 
?>

