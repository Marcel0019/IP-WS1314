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

//Variablen Init
$_FEHLERCODE[] = "";
$ergebnis = "";
$error = false;
$quelltext = "";
$pattern = "";
$ersatztext = "";
$status = "";

////////////////////////////////
//Start der Formular Validierung

/**
 * Fehlerhandling
 * Ausgabe und Programmende
 *
 */
function errorHandling($code) {
    global $_FEHLERCODE;

    array_push($_FEHLERCODE, $code);
}


//Pruefung der eingegebenen Werte
if (isset($_POST['Submit'])) {

    //Pruefung des Quelltextes
    if (isset($_POST["quelltext"]) && is_string($_POST["quelltext"])) {
        $quelltext = htmlentities($_POST['quelltext']);
    } else {
        errorHandling("Quelltext!");
        $error = true;
    }

    //Pruefung des Patterns
    if (isset($_POST["pattern"]) && is_string($_POST["pattern"])) {
        $pattern = htmlentities($_POST['pattern']);
    } else {
        errorHandling("Pattern!");
        $error = true;
    }

    //Pruefung des Ersatztextes
    if (isset($_POST["ersatztext"]) && is_string($_POST["ersatztext"])) {
        $ersatztext = htmlentities($_POST['ersatztext']);
    } else {
        errorHandling("Ersatztext!");
        $error = true;
    }

    //PREG_REPLACE, sofern kein Fehler bei der Eingabe gefunden wurde
    if (!$error) {
        if(!$ergebnis = @preg_replace($_POST['pattern'], $_POST['ersatztext'], $_POST['quelltext'])){
            $status = "Es ist ein Problem bei der Verarbeitung aufgetreten.";
        } else {
            $status = "erfolgreich";
        }
    } else {
        $status = "Fehler: ".print_r($_FEHLERCODE)." ";
    }

}

//Ende der Formular Validierung
///////////////////////////////

///////////////////////////////
// Preg_Replace

//   $ergebnis = htmlspecialchars(preg_replace($_POST['pattern'], $_POST['ersatztext'], $_POST['quelltext']));

//Ende Preg_Replace
///////////////////////////////

?>
<!DOCTYPE html>
<html>
<!-- header -->
<head>
    <!-- Titel des HTML Dokuments -->
    <title>Regex - Formular</title>
    <link rel="stylesheet" type="text/css" href="css/format.css"/>
</head>

<!-- body -->
<body>
<!-- Beginn Content -->
<div class="content">

    <h1>RegEx</h1>
    <br/>
    <!-- Formulare -->
    <form method="post" action="index.php">
        <fieldset>
            <legend>Eingabe</legend>
            <label>Quelltext: </label>
            <textarea name="quelltext" rows="5" cols="35" tabindex="1"><?php echo $quelltext; ?></textarea>
            <br/>
            <label>Pattern: </label>
            <input name="pattern" type="text" tabindex="2" value="<?php echo $pattern; ?>">
            <br/>
            <label>Ersatztext: </label>
            <input name="ersatztext" type="text" tabindex="3" value="<?php echo $ersatztext; ?>">
            <br/> <br/>
            <label>Ergebnis: </label>
            <textarea name="ergebnis" readonly rows="5" cols="35" tabindex="4"><?php echo $ergebnis; ?></textarea>
            <br/> <br/>
            <label>Status: <?php echo $status; ?></label><br><br>
            <input style="margin-left: 160px;" type="Submit" value="Submit" name='Submit' tabindex="5"/>
            <input type="reset" tabindex="6"/>
        </fieldset>
    </form>
</div>
</body>
</html>