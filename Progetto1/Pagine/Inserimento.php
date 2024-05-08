<!DOCTYPE HTML>
<html lang="it">

<head>
    <title>Inserimento Utenze</title>

    <meta charset="UTF-8">
    <meta name="description" content="Gestore database per Distribuzioni Acque">
    <meta name="author" content="Bellosi Jacopo, Signori Alessandro">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-control" content="no-cache">

    <link rel="stylesheet" href="../css/stile.css">
    <link rel="icon" href="../img/logo.jpeg" type="image/x-icon" alt="Logo" />
</head>

<body>
    <?php
    include '../Extra/header.html';
    include '../Extra/footer.html';
    include '../DB/dbManager.php';
    include '../DB/connDb.php';

    $Codice = "";
    $DataAp = "";
    $Indirizzo  = "";
    $Citta = "";
    $CodCliente  = "";
    $Attiva = "";
    $DataCh  = "";
    if (count($_POST) > 0) {
        $Codice = $_POST["Codice"];
        $DataAp = $_POST["DataAp"];
        $Indirizzo  = $_POST["Indirizzo"];
        $Citta = $_POST["Citta"];
        $CodCliente  = $_POST["CodCliente"];
        if(isset($_POST["Attiva"]))  {
            $Attiva = 1;
            $DataCh  = "";
        } else {
            $Attiva = 0;
            $DataCh  = $_POST["DataCh"];
        }

        if (controllo($Attiva, $DataCh)) {
            $query = insertUtenze($DataAp, $Indirizzo, $Citta, $CodCliente, $Attiva, $DataCh);
            try {
                $result = $conn->query($query);
            } catch (PDOException $e) {
                echo "<h3>DB Error on Query: " . $e->getMessage() . "</h3>";
                $error = true;
            }
            if (!$error) {
                echo ("<script>alert('Inserimento andato a buon fine')</script>");
                header('Location: ' . "Utenza.php");
            } else {
                echo ("<script>alert(" . $error . ")</script>");
            }
        }
    }
    $query = "SELECT DISTINCT Codice FROM Cliente";
    try {
        $result = $conn->query($query);
    } catch (PDOException $e) {
        echo "<h3 class='msg'>DB Error on Query: " . $e->getMessage() . "</h3>";
        $error = true;
    }
    ?>

    <div class="main">
        <?php
        include '../Extra/nav.html';
        ?>
        <div id="content">
            <h2>Inserimento Utenze</h2>
            <form name="myform" method="POST">
                <label for="IdDataAp">Data Applicazione: </label>
                <input type="date" name="DataAp" id="IdDataAp" required /> <br><br>
                <label for="IdIndirizzo">Indirizzo: </label>
                <input type="text" name="Indirizzo" id="IdIndirizzo" required /> <br><br>
                <label for="IdCitta">Città: </label>
                <input type="text" name="Citta" id="IdCitta" required /> <br><br>
                <label for="IdCodCliente">Codice Cliente: </label>
                <select name="CodCliente" id="IdCodCliente" required>
                    <?php

                    foreach ($result as $riga) {

                        echo "<option value=" . $riga["Codice"] . ">" . $riga["Codice"] . "</option>";
                    }
                    ?>
                </select><br><br>
                <label for="IdAttiva">Attiva: </label>
                <input type="checkbox" name="Attiva" id="IdAttiva" /> <br><br>
                <label for="IdDataCh">Data Chiusura: </label>
                <input type="date" name="DataCh" id="IdDataCh" /> <br><br>
                <input type="submit" value="Invia Dati" />
            </form>
        </div>
    </div>
</body>
<script type="text/javascript" src="../js/script.js" defer></script>

</html>