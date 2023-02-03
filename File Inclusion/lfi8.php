<?php     include("../common/header.php");   ?>

<form action="/api/index.php" method="POST">
    <input type="text" name="file">
</form>


<?php
if (substr($_POST['file'], -4, 4) != '.php')
 echo file_get_contents($_POST['file']);
else
 echo 'Lorem ipsum dolor sit amet consectetur adipisicing elit.'."\n";
?>

