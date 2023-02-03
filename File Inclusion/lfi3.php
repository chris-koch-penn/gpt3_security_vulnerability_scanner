<?php     include("../common/header.php");   ?>

<form action="/api/index.php" method="GET">
    <input type="text" name="file">
</form>


<?php
if (substr($_GET['file'], -4, 4) != '.php')
 echo file_get_contents($_GET['file']);
else
 echo 'Lorem ipsum dolor sit amet consectetur adipisicing elit.'."\n";
?>

