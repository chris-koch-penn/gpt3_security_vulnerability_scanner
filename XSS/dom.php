<?php
require_once('../_helpers/strip.php');
?>
<html>
  <head>

  </head>
  <body>
    <p>
      Hi, <?= $_GET['name']; ?>
    </p>
    <script>
      window.onload = function(){
        let someObject = window.someObject || {};
        let script = document.createElement('script');
        script.src = someObject.url;
        document.body.appendChild(script);
     };
    </script>
  </body>
</html>
