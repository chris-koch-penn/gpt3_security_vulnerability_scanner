<?php

require_once('../_helpers/strip.php');

// this database contains a table with 2 rows
$db = new SQLite3('test.db');

$id = $_GET['id'];

if (strlen($id) > 0) {
  $query = $db->query('select * from secrets where id = ' . (int)$id);

  while ($row = $query->fetchArray()) {
    echo 'Secret: ' . $row['secret'];
  }

  echo '<br /><br /><a href="/">Go back</a>';
} else {
  $query = $db->query('select * from secrets where user_id = 1');

  echo '<strong>Your secrets</strong><br /><br />';

  while ($row = $query->fetchArray()) {
    echo '<a href="/?id=' . $row['id'] . '">#' . $row['id'] . '</a><br />';
  }
