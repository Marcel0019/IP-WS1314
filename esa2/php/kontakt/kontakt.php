<?php

/**
  * Internet Programmierung
  *
  *
  * @package	Modul Internet-Programmierung
  * @author	Marcel Wallbaum <marcel.wallbaum@gmail.com>
  * @copyright	2013 Marcel Wallbaum
  *
  */

//Prüfen ob der Vorname vorhanden ist und nicht leer
//mittels htmlentities eine codierte Zeichenkette zurückgeben
if(!isset($_POST["vorname"] Or Trim($_POST['vorname']) == "")){
    $fehler = 1;
    $fehlertext = "Bitte geben Sie einen gültigen Vornamen ein.<br>";
} else {
    $vorname = htmlentities($_POST["vorname"]);
}

//Prüfen ob der Nachname vorhanden ist und nicht leer
//mittels htmlentities eine codierte Zeichenkette zurückgeben
if(!isset($_POST["nachname"] Or Trim($_POST['nachname']) == "")){
    $fehler = 1;
    $fehlertext = "Bitte geben Sie einen gültigen Nachname ein.<br>";
} else {
    $vorname = htmlentities($_POST["nachname"]);
}

//Prüfen ob der Nachname vorhanden ist und nicht leer
//mittels htmlentities eine codierte Zeichenkette zurückgeben
if(!isset($_POST["matrikelnr"]) Or is_numeric($_POST["matrikelnr"])){
    $fehler = 1;
    $fehlertext = "Bitte geben Sie eine gültige Matrikelnummer ein.<br>";
} else {
    $vorname = htmlentities($_POST["nachname"]);
}



?>
