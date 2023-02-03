<?php     include("../common/header.php");   ?>
<?php
hint("something something something placeholder placeholder placeholder");
?>

<form action="/CMD-3/index.php" method="GET">
    Whois: <input type="text" name="domain">
</form>

<pre>
<?php
    system("/usr/bin/whois " . $_GET["domain"]);
 ?>
</pre>