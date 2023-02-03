<?php

require_once('../_helpers/strip.php');

// this database contains a table with 2 rows
// This is my first secret (ID = 1)
// This is my second secret (ID = 2)
$db = new SQLite3('test.db');

if (strlen($_GET['id']) < 1) {
  echo 'Usage: ?id=1';
} else {
  $count = $db->querySingle('select count(*) from secrets where id = ' . $_GET['id']);

  if ($count > 0) {
    echo 'Yes!';
  } else {
    echo 'No!';
  }
}
