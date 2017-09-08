<?php

echo $localizar=$_POST['coordenadas'];

$hora = substr($localizar,0,8);
$lat = substr($localizar,9,10);
$latC = $localizar[20];
$longit = substr($localizar,22,10);
$longiC = $localizar[33];

/*
echo $hora;
echo $lat;
echo $latC;
echo $longit;
echo $longiC;
*/
//$datos = $hora." ".$lat." ". $latC." ".$longit." ".$longiC;
$datos =
"<?xml version=".'"1.0"' ." " ."encoding=" . '"UTF-8"'."?>".
"\n<xml>
<GPS>
	<Hora>".$hora."</Hora>
	<Latitud>".$lat." ".$latC."</Latitud>
	<Longitud>".$longit." ".$longiC."</Longitud>
</GPS>
</xml>";

//file_put_contents('coorPrueba.xml', $datos, FILE_APPEND);
file_put_contents('coordenadasGPS.xml', $datos);
//file_put_contents('coorPrueba.xml', $localizar);


?>