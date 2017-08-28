<?php

echo $localizar=$_POST['coordenadas'];

$hora = substr($localizar,1,8);
$lat = substr($localizar,10,10);
$latC = $localizar[21];
$longit = substr($localizar,23,10);
$longiC = $localizar[34];

echo $hora;
echo $lat;
echo $latC;
echo $longit;
echo $longiC;

$datos = 
"<?xml version=".'"1.0"' ." " ."encoding=" . '"UTF-8"'."?>".
"\n<xml>
<GPS>
	<Hora>".$hora."</Hora>
	<Latitud>".$lat." ".$latC."</Latitud>
	<Longitud>".$longit." ".$longiC."</Longitud>
</GPS>
</xml>";

// file_put_contents('coorPrueba.xml', $datos, FILE_APPEND);
file_put_contents('coorPrueba.xml', $datos);

?>