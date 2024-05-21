<!DOCTYPE HTML>
<html lang="it">

<head>
	<title>Gestore Acque</title>

	<meta charset="UTF-8">
	<meta name="description" content="Gestore database per Distribuzioni Acque">
	<meta name="author" content="Bellosi Jacopo, Signori Alessandro">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Cache-control" content="no-cache">

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

	<div id="Err" class="sfondoErr">
		<div class="errore">
			<h2><u>ATTENZIONE!</u></h2>
			<p>Sei veramente sicuro di voler elimare questa utenza?</p>
			<p>Non si torna più indietro.</p>
			<div class="pulsanti">
				<input type="button" id="elimPuls" value="Elimina" class="elimina" />
				<input type="button" value="Annulla" onclick="document.getElementById('Err').style.display='none'" />
			</div>
		</div>
	</div>

	<div class="main">

		<?php
		include '../Extra/nav.html';
		?>

		<div id="content">
			<div class="divTitolo">
				<h2>Utenze</h2>
				<a href="ModificaUtenza.php">
					<img src="../img/Aggiungi.png" class="iconaPiu"></i>
				</a>
			</div>

			<hr>

			<h4>Filtri: </h4>
			<form name="myform" id="searchForm" method="POST">
				<input id="IdCodice" name="Codice" type="number" placeholder="Codice" value="<?php echo $Codice ?>" min="1" />
				<label for="IdDataApRic">Data Applicazione: </label>
				<input id="IdDataApRic" name="DataAp" type="date" value="<?php echo $DataAp ?>" />
				<input id="IdIndirizzo" name="Indirizzo" pattern="[\p{L} \d]+" title="Vietato mettere apici o virgolette " type="text" placeholder="Indirizzo" value="<?php echo $Indirizzo ?>" /> <br> <br>
				<input id="IdCitta" name="Citta" type="text" pattern="[\p{L} \d]+" title="Vietato mettere apici o virgolette " placeholder="Città" value="<?php echo $Citta ?>" />
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
				<input type="button" id="reset" value="Cancella" />
			</form>
			<hr>

			<div id="results" class="tabella-scorrevole">

				<?php
				$query = getUtenze($Codice, $DataAp, $Indirizzo, $Citta, $CodCliente, $Attiva, $DataCh);

				try {
					$result = $conn->query($query);
				} catch (PDOException $e) {
					echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
					$error = true;
				}

				if (!$error) {
				?>

					<table class="table" id="myTableUtenza">
						<tr class="header">
							<th onclick="sortTableUtenza(0)">Codice</th>
							<th onclick="sortTableUtenza(1)">Data Applicazione</th>
							<th onclick="sortTableUtenza(2)">Indirizzo</th>
							<th onclick="sortTableUtenza(3)">Città</th>
							<th onclick="sortTableUtenza(4)">Cliente</th>
							<th onclick="sortTableUtenza(5)">Attiva</th>
							<th onclick="sortTableUtenza(6)">Data Chiusura </th>
							<th onclick="sortTableUtenza(7)">Numero Letture</th>
							<th>Modifica</th>
							<th>Elimina</th>
						</tr>

						<?php
						foreach ($result as $riga) {
							$Codice = $riga["Codice"];
							$DataAp = $riga["DataAp"];
							$Indirizzo = $riga["Indirizzo"];
							$Citta = $riga["Città"];
							$CodCliente = $riga["CodCliente"];
							$Attiva  = $riga["Attiva"];
							$DataCh = $riga["DataCh"];
						?>

							<tr class="riga">
								<td class="centerTD"> <?php echo $Codice; ?> </td>
								<td> <?php echo $DataAp; ?> </td>
								<td> <?php echo $Indirizzo; ?> </td>
								<td> <?php echo $Citta ?> </td>

								<?php
								try {
									$result = $conn->query(nomeCliente($CodCliente));
								} catch (PDOException $e) {
									echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
									$error = true;
								}
								foreach ($result as $riga)
									$RagSoc = $riga["RagSoc"];
								?>

								<td class="centerTD">
									<?php echo riferimentoCliente($RagSoc, $CodCliente); ?>
								</td>
								<td class="centerTD">
									<?php if ($Attiva == 1) { ?>
										<input id="IdAttiva" name="Attiva" type="checkbox" checked disabled />
									<?php } else { ?>
										<input id="IdAttiva" name="Attiva" type="checkbox" disabled />
									<?php } ?>
								</td>
								<td> <?php echo $DataCh ?> </td>

								<?php
								try {
									$result = $conn->query(numeroLetture($Codice));
								} catch (PDOException $e) {
									echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
									$error = true;
								}

								foreach ($result as $riga)
									$NumLet = $riga["NumeroLetture"];
								?>

								<td class="centerTD"> <?php echo  riferimentoNumeroLettura($NumLet, $Codice); ?> </td>
								<td class="centerTDicona"> <?php echo modificaUtenza($Codice); ?> </td>
								<td class="centerTDicona">
									<a onclick="setEliminazione(<?php echo $Codice ?>)" class='centerIcon'>
										<img src="../img/Elimina.png" alt="Cestino Elimina" class="icona">
									</a>
								</td>
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