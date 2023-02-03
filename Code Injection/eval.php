<?php

require_once('../_helpers/strip.php');

$variable = strlen($_GET['variable']) > 0 ? $_GET['variable'] : 'empty';
$empty = 'No variable given';
eval('echo $' . $variable . ';');
