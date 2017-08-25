<?php

// if($_POST){
	
echo $localizar=$_POST['coordenadas'];

$hora = substr($localizar,5,8);
$lat = substr($localizar,14,10);
$latC = $localizar[25];
$longit = substr($localizar,27,10);
$longiC = $localizar[38];

$coor = new SimpleXMLElement('coorPrueba.xml', null, true);
// Primero creamos un elemento <book> y lo agregamos al elemento raíz <library>
$GPS = $coor->addChild('GPS');
// Le asignamos el atributo [isbn] al elemento <book>
// $book->addAttribute('isbn', '0812550706');
// Creamos los elementos que van dentro de <book>: <title>, <author> y <publisher>
$GPS->addChild('Hora', $hora);
$GPS->addChild('Latitud', $lat." ".$latC);
$GPS->addChild('Longitud', $longit." ".$longiC);

 
header('Content-type: text/xml');
echo $coor->asXML();
$coor->asXML('coorPrueba.xml');
/* } */
?>