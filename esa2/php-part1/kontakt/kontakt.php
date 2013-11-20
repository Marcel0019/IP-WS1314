<?php

/**
 * Internet Programmierung
 *
 *
 * @package       Modul Internet-Programmierung
 * @author        Marcel Wallbaum <marcel.wallbaum@gmail.com>
 * @copyright     2013 Marcel Wallbaum
 * ESA2 - Teil 2
 *
 */

//globale Variablen
$_FILENAME = "daten.csv";

////////////////////////////////
//Start der Formular Validierung

$fehler = false;
$fehler_array = array();
$vorname = "";
$nachname = "";
$matrikelnr = "";
$geschlecht = "";

//Prüfung der eingegebenen Werte mittels:
//HTMLENTITIES eine codierte Zeichenkette zurückgeben
//ENT_QUOTES konvertiert doppelte als auch einfache Anführungszeichen

//Prüfen des Vornamens
if(!isset($_POST["vorname"]) or trim($_POST["vorname"]) ==""){
    $fehler = true;
    $fehler_array[] = "Vorname";
} else {
    $vorname = htmlentities($_POST["vorname"],ENT_QUOTES);
}

//Prüfen des Nachnamens
if(!isset($_POST["nachname"]) or trim($_POST["nachname"]) ==""){
    $fehler = true;
    $fehler_array[] = "Nachname";
} else {
    $nachname = htmlentities($_POST["nachname"],ENT_QUOTES);
}

//Prüfen der Matrikelnummer
if(!is_numeric($_POST["matrikelnr"])){
    $fehler = true;
    $fehler_array[] = "Matrikelnummer";
} else {
    $matrikelnr = htmlentities($_POST["matrikelnr"]);
}

//Prüfen des Geschlechts
if($_POST['geschlecht'] == "") {
    $fehler = true;
    $fehler_array[] = "Geschlecht";
} else {
    $geschlecht = ($_POST['geschlecht']);
}

//prüfen, ob ein Fehler bei den Formulareingaben erkannt wurde
//wenn ja, dann Ausgabe der Fehler
if ($fehler) {
    echo "Es ist ein Fehler bei der Eingabe aufgetreten, bitte pruefen Sie den Wert fuer : <br><br>";

    foreach($fehler_array AS $name) {
        echo " - ".$name." <br>";
    }
//wenn Fehler gefunden, dann Skript hier beenden
    exit;
}

//Ende der Formular Validierung
///////////////////////////////

///////////////////////////////
// Dateihandling

/**
 * Prüfen, ob Datensatz bereits vorhanden ist
 *
 */
function _cvsSucheDatensatz($csvArray, $matrikelnr){

    $in_array = false;
    foreach ($csvArray as $key => $value){
       if($csvArray[$key][2] == $matrikelnr) {
           $in_array = true;
           break;
       }
    }

    return $in_array;
}

/**
 * Inhalt der csv Datei auslesen
 *
 */
function _csvRead() {
    global $_FILENAME;
    $csvArray[]="";

    if (($handle = fopen($_FILENAME, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 100, ",")) !== FALSE) {
            $csvArray[] = $data;
        }

        fclose($handle);
    } else {
        errorHandling("Fehler beim Lesen der Datei");
    }
    return $csvArray;
}

/**
 * Neuen Datensatz in die csv Datei schreiben
 *
*/
function _csvAdd($file,$csvArray,$vorname,$nachname,$matrikelnr,$geschlecht) {
    // Dateiname festlegen
    global $_FILENAME;

    //prüfen ob Datensatz vorhanden und Datei beschreibbar ist
    if (_cvsSucheDatensatz($csvArray,$matrikelnr)) {
        errorHandling("Matrikelnummer ist bereits vergeben!\nDaten wurden nicht gespeichert!");
    }

    //schreiben der Daten in die Datei
    $_newData = $vorname.",".$nachname.",".$matrikelnr.",".$geschlecht;
    $_newDataArray = explode (",", $_newData);

    $fp = fopen($_FILENAME, 'a');
    //csv Datensatz hinzufügen
    if (!fputcsv($fp, $_newDataArray)) {
        errorHandling("Daten konnten nicht gespeichert werden");
    } else {
        echo "Die Personendaten wurden erfolgreich gespeichert.";
    }
    fclose($fp);
}

function clean_array($array){
    foreach($array as $key => $value) {
        if($value == '') {
            unset($array[$key]);
        }
    }

    //re-index the array
    $array = array_values($array);

    return $array;
}

/**
 * Datensatz aus der Datei löschen
 *
 */
function _csvDelete($file,$csvArray,$matrikelnr) {

    if (!_cvsSucheDatensatz($csvArray,$matrikelnr)) {
        errorHandling("Datensatz zum Loeschen ist nicht vorhanden! Bitte pruefen Sie die Eingaben!");
    }

    //csv Datensatz löschen
    foreach ($csvArray as $key => $value){
        if($csvArray[$key][2] == $matrikelnr) {
            unset($csvArray[$key]);
            break;
        }
    }

    $csvArray = clean_array($csvArray);

    //neues Array zeilenweise in Datei schreiben
    $fp = fopen($file, 'w+');
    foreach ($csvArray as $fields)
    {
        if (!fputcsv($fp, $fields)) {
            errorHandling("Problem beim loeschen der Daten!");
        }
    }
    echo "Die Personendaten wurden erfolgreich geloescht.";

    fclose($fp);
}

/**
 * Fehlerhandling
 * Ausgabe und Programmende
 *
 */
function errorHandling($fehlercode) {
    echo "Fehler “.$fehlercode.”";
    exit;
}

/**
 * Basic Datei Handling
 *
 */
function _dateiHandling ($type,$vorname,$nachname,$matrikelnr,$geschlecht) {
    // Dateiname festlegen
    global $_FILENAME;

    //prüfen, ob Datei beschreibbar ist
    if (!is_writable($_FILENAME))
        errorHandling("Datei ist nicht beschreibbar!");

    //csv Inhalt auslesen
    $csvArray = _csvRead($_FILENAME);

    //hinzufügen von Daten
    if($type == "add") {
        _csvAdd($_FILENAME,$csvArray,$vorname,$nachname,$matrikelnr,$geschlecht);
    } elseif ($type == "delete") {
        _csvDelete($_FILENAME,$csvArray,$matrikelnr);
    }
}

//prüfen, welcher Button gedrückt wurde
//Hinzufügen eines Datensatzes
if (isset ($_POST['add'])) {
    //Personendaten in die Datei schreiben
    _dateiHandling("add",$vorname,$nachname,$matrikelnr,$geschlecht);
    } elseif (isset ($_POST['delete'])) {
    _dateiHandling("delete",$vorname,$nachname,$matrikelnr,$geschlecht);
}

?>