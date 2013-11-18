<?php

/**
 * Internet Programmierung
 *
 *
 * @package       Modul Internet-Programmierung
 * @author        Marcel Wallbaum <marcel.wallbaum@gmail.com>
 * @copyright     2013 Marcel Wallbaum
 * ESA2 - Teil 3
 *
 */

////////////////////////////////
//Start der Formular Validierung

$fehler = false;
$fehler_array = array();

//Prüfung der eingegebenen Werte

//Prüfen des Quelltextes
if(!isset($_POST["quelltext"]) or trim($_POST["quelltext"]) ==""){
    $fehler = true;
    $fehler_array[] = "Quelltext";
}

//Prüfen des Patterns
if(!isset($_POST["quelltext"]) or trim($_POST["quelltext"]) ==""){
    $fehler = true;
    $fehler_array[] = "Pattern";
}

//prüfen, ob ein Fehler bei den Formulareingaben erkannt wurde
//wenn ja, dann Ausgabe der Fehler
if ($fehler) {
    echo "Es ist ein Fehler bei der Eingabe aufgetreten, bitte prüfen Sie den Wert für : <br><br>";

    foreach($fehler_array AS $name) {
        echo " - ".$name." <br>";
    }
//wenn Fehler gefunden, dann Skript hier beenden
    exit;
}

//Ende der Formular Validierung
///////////////////////////////



///////////////////////////////
// Preg_Replace

$ergebnis = preg_replace($_POST['pattern'],$_POST['ersatztext'],$_POST['quelltext']);
echo htmlspecialchars($ergebnis);
?>