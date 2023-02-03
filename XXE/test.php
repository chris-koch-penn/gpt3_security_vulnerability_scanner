<?php

require_once('../_helpers/strip.php');

libxml_disable_entity_loader (false);

$xml = strlen($_GET['xml']) > 0 ? $_GET['xml'] : '<root><content>No XML found</content></root>';

$document = new DOMDocument();
$document->loadXML($xml, LIBXML_NOENT | LIBXML_DTDLOAD);
$parsedDocument = simplexml_import_dom($document);

echo $parsedDocument->content;
