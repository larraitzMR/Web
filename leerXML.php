<?php

header('Content-type: application/xml');

$xml = file_get_contents("coordenadasGPS.xml");
echo $xml;

?>