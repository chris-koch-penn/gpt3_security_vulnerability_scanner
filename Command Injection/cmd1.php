<?php     include("../common/header.php");   ?>
<?php
hint("something something something placeholder placeholder placeholder");
?>

<form action="/CMD-1/index.php" method="GET">
    <input type="text" name="cmd">
</form>

<?php
    system($_GET["cmd"]);
 ?>