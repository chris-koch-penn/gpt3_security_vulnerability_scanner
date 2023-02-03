<?php     include("../common/header.php");   ?>

<form action="/api/index.php" method="POST">
    <input type="text" name="file">
    <input type="hidden" name="style" name="stylepath">
</form>

<?php include($_POST['stylepath']); ?>
