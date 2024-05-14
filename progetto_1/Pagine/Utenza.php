<!DOCTYPE HTML>
<html lang="it">

<head>
	<title>Gestore Acque</title>

	<meta charset="UTF-8">
	<meta name="description" content="Gestore database per Distribuzioni Acque">
	<meta name="author" content="Bellosi Jacopo, Signori Alessandro">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Cache-control" content="no-cache">
	<script src="https://kit.fontawesome.com/01ed1bbc7a.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<!--
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	-->
	<link rel="stylesheet" href="../css/stile.css">
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
		if (isset($_POST["Attiva"])) {
			$Attiva = 1;
			$DataCh  = "";
		} else {
			$Attiva = 0;
			$DataCh  = $_POST["DataCh"];
		}
	} else if (count($_GET) > 0) {
		$Codice = $_GET["Codice"];
		$DataAp = $_GET["DataAp"];
		$Indirizzo  = $_GET["Indirizzo"];
		$Citta = $_GET["Citta"];
		$CodCliente  = $_GET["CodCliente"];
		if (isset($_GET["Attiva"])) {
			$Attiva = 1;
			$DataCh  = "";
		} else {
			$Attiva = 0;
			$DataCh  = $_GET["DataCh"];
		}
	}
	?>
	<div id="id01" class="w3-modal">
		<div class="w3-modal-content w3-card-4 w3-animate-zoom modal-dimension-custom">
			<header class="w3-container w3-red">
				<span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-red w3-xlarge w3-display-topright">&times;</span>
				<h2>ATTENZIONE!</h2>
			</header>

			<div class="w3-bar w3-border-bottom">


				<div class="w3-container city">
					<p>Sei veramente sicuro di voler elimare questa utenza?</p>
					<p>Non si torna più indietro</p>
				</div>

				<div class="w3-container w3-light-gre w3-padding">
					<button class="w3-button w3-right w3-red w3-border  " onclick="document.getElementById('id01').style.display='none'"> <span id="utente_eliminare"></span> </button>
					<button class="w3-button w3-right w3-white w3-border w3-margin-right-custom" onclick="document.getElementById('id01').style.display='none'">Close</button>
				</div>

			</div>
		</div>

	</div>

	<div class="main">
		<?php
		include '../Extra/nav.html';
		?>
		<div id="content">
			<h2>Utenze</h2>
			<hr>
			<h4>Filtri: </h4>
			<form name="myform" method="POST">
				<input id="IdCodice" name="Codice" type="number" placeholder="Codice" value="<?php echo $Codice ?>" min="1" />
				<label for="IdDataApRic">Data Applicazione: </label>
				<input id="IdDataApRic" name="DataAp" type="date" value="<?php echo $DataAp ?>" />
				<input id="IdIndirizzo" name="Indirizzo" type="text" placeholder="Indirizzo" value="<?php echo $Indirizzo ?>" /> <br> <br>
				<input id="IdCitta" name="Citta" type="text" placeholder="Città" value="<?php echo $Citta ?>" />
				<input id="IdCodCliente" name="CodCliente" type="number" placeholder="Codice Cliente" value="<?php echo $CodCliente ?>" min="1" />
				<label for="IdAttiva">Attiva: </label>
				<?php if ($Attiva == 1) { ?>
					<input id="IdAttiva" name="Attiva" type="checkbox" checked />
				<?php } else { ?>
					<input id="IdAttiva" name="Attiva" type="checkbox" />
				<?php } ?>
				<label for="IdDataChRic">Data Chiusura: </label>
				<input id="IdDataChRic" name="DataCh" type="date" value="<?php echo $DataCh ?>" />
				<input type="submit" value="Cerca" />
				<input type="reset" value="Cancella" />
			</form>
			<hr>

			<div id="results" class="tabella-scorrevole">
				<?php

				$query = getUtenze($Codice, $DataAp, $Indirizzo, $Citta, $CodCliente, $Attiva, $DataCh);
				echo "<p>Utenze: " . $query . "</p>";

				try {
					$result = $conn->query($query);
				} catch (PDOException $e) {
					echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
					$error = true;
					echo $query;
				}
				if (!$error) {
				?>

					<table class="table" id="myTable">
						<tr class="header">
							<th onclick="sortTable(0)">Codice</th>
							<th onclick="sortTable(1)">Data Applicazione</th>
							<th onclick="sortTable(2)">Indirizzo</th>
							<th onclick="sortTable(3)">Città</th>
							<th onclick="sortTable(4)">CodCliente</th>
							<th onclick="sortTable(5)">Attiva</th>
							<th onclick="sortTable(6)">Data Chiusura </th>
							<th>Modifica</th>
							<th>Elimina</th>
						</tr>
						<?php
						$i = 0;
						foreach ($result as $riga) {
							$i = $i + 1;
							$classRiga = 'class="rowOdd"';
							if ($i % 2 == 0) {
								$classRiga = 'class="rowEven"';
							}
							$Codice = $riga["Codice"];
							$DataAp = $riga["DataAp"];
							$Indirizzo = $riga["Indirizzo"];
							$Citta = $riga["Città"];
							$CodCliente = $riga["CodCliente"];
							$Attiva  = $riga["Attiva"];
							$DataCh = $riga["DataCh"];

						?>
							<tr <?php echo $classRiga; ?>>
								<td class="centerTD"> <?php echo $Codice; ?> </td>
								<td> <?php echo $DataAp; ?> </td>
								<td> <?php echo $Indirizzo; ?> </td>
								<td> <?php echo $Citta ?> </td>
								<td class="centerTD"> <?php echo riferimentoCliente($CodCliente); ?> </td>
								<td class="centerTD"> <?php if ($Attiva == 1) { ?>
										<input id="IdAttiva" name="Attiva" type="checkbox" checked disabled />
									<?php } else { ?>
										<input id="IdAttiva" name="Attiva" type="checkbox" disabled />
									<?php } ?>
								</td>
								<td> <?php echo $DataCh ?> </td>
								<td> <?php echo modificaUtenza($Codice); ?></td>
								<td><a onclick="document.getElementById('id01').style.display='block'; document.getElementById('utente_eliminare').innerHTML=setEliminazione(<?php echo $Codice ?>); " class='centerIcon'"><i class='far fa-trash-alt'></i> </button></a>
							</tr>
						<?php } ?>
					</table>
				<?php }  ?>

			</div>
		</div>
	</div>
</body>
<script type=" text/javascript" src="../js/script.js" defer></script>

</html>