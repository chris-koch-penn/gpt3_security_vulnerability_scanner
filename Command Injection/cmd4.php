<?php     include("../common/header.php");   ?>
<?php  hint("something something something placeholder placeholder placeholder"); ?>

<form action="/CMD-4/index.php" method="POST">
    <input type="text" name="domain">
</form>

<pre>
<?php
    system("whois " . $_POST["domain"]);
 ?>
</pre>