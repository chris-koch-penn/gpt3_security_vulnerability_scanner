<?php     include("../common/header.php");   ?>

<form action="/api/index.php" method="GET">
    <input type="text" name="file">
</form>

<?php
   $file = str_replace('../', '', $_GET['file']);
   if(isset($file))
   {
       include("pages/$file");
   }
   else
   {
       include("index.php");
   }
?>
