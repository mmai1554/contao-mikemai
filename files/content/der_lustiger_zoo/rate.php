<?php

if (!defined('INCLUDES_DIR')) {
    define('INCLUDES_DIR', '../../includes/');
}
require_once INCLUDES_DIR . 'config.php';
try {
    $objTier = new Tierchen($_POST['diervoter']);
    $objTier->addVote();

    $xml = "<result><button_after>Vielen Dank, Sie dürfen auch gern nochmal</button_after><ergebnis>Dieses Tier hat jetzt Dank Ihnen <strong>" . $objTier->getCount() . "</strong> Stimmen</ergebnis></result>";
} catch (Exception $e) {
    $error = $e->getMessage();
    $xml = "<result><button_after>Fehler!</button_after><ergebnis>$error</ergebnis></result>";
}
header('Content-type: text/xml');
echo $xml;
?>