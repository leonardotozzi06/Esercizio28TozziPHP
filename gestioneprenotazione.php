<?php
// Array di camerieri
$camerieri = ["Mario", "Luigi", "Anna", "Carla", "Giorgio"];

// Estrai i dati dal form
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$tavolo = $_POST['tavolo'];
$orario = $_POST['orario'];
$note = $_POST['note'];
$pasti = $_POST['pasti'] ?? [];
$parcheggio = $_POST['parcheggio'];
$data_prenotazione = date("d-m-Y H:i");

// Calcola il prezzo in base ai pasti selezionati
$prezzo_antipasto = 5;
$prezzo_primo = 6;
$prezzo_secondo = 7;
$totale = 0;
$sconto = 0;
$errore = '';

// Controlla i pasti selezionati e calcola il prezzo
if (empty($pasti)) {
    $errore = "Errore: Non hai selezionato nessun pasto.";
} elseif (count($pasti) == 1 && in_array("antipasto", $pasti)) {
    $errore = "Errore: Non è possibile ordinare solo l'antipasto.";
} else {
    if (in_array("antipasto", $pasti)) $totale += $prezzo_antipasto;
    if (in_array("primo", $pasti)) $totale += $prezzo_primo;
    if (in_array("secondo", $pasti)) $totale += $prezzo_secondo;

    // Calcolo sconto
    if (in_array("primo", $pasti) && in_array("secondo", $pasti)) {
        $sconto = (count($pasti) == 3) ? 0.15 : 0.10;
        $totale -= $totale * $sconto;
    }

    // Aggiungi il costo del parcheggio
    if ($parcheggio == "custodito") {
        $totale += 5;
    } elseif ($parcheggio == "non_custodito") {
        $totale += 3;
    }
}

// Assegna un cameriere casuale
$cameriere = $camerieri[array_rand($camerieri)];

if ($errore) {
    echo "<h2>$errore</h2>";
    echo "<p>Data e ora della prenotazione: $data_prenotazione</p>";
    echo '<p><a href="prenotazione.html">Torna alla pagina di prenotazione</a></p>';
} else {
    echo "<h1>Resoconto Prenotazione</h1>";
    echo "<table border='1'>
            <tr><th>Nome</th><td>$nome</td></tr>
            <tr><th>Cognome</th><td>$cognome</td></tr>
            <tr><th>Tavolo</th><td>$tavolo</td></tr>
            <tr><th>Orario</th><td>$orario</td></tr>
            <tr><th>Note</th><td>$note</td></tr>
            <tr><th>Pasti</th><td>" . implode(", ", $pasti) . "</td></tr>
            <tr><th>Parcheggio</th><td>$parcheggio</td></tr>
            <tr><th>Cameriere</th><td>$cameriere</td></tr>
            <tr><th>Totale</th><td>€" . number_format($totale, 2) . "</td></tr>
            <tr><th>Data e Ora Prenotazione</th><td>$data_prenotazione</td></tr>
          </table>";
}
?>
