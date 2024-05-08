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

	<div class="main">
		<?php
		include '../Extra/nav.html';
		?>
		<div id="content">
			<h2>Utenze</h2>
			<hr>
			<h4>Filtri: </h4>
			<form name="myform" method="POST">
				<input id="IdCodice" name="Codice" type="text" placeholder="Codice" value="<?php echo $Codice ?>" />
				<label for="IdDataApRic">Data Applicazione: </label>
				<input id="IdDataApRic" name="DataAp" type="date" value="<?php echo $DataAp ?>" />
				<input id="IdIndirizzo" name="Indirizzo" type="text" placeholder="Indirizzo" value="<?php echo $Indirizzo ?>" /> <br> <br>
				<input id="IdCitta" name="Citta" type="text" placeholder="Città" value="<?php echo $Citta ?>" />
				<input id="IdCodCliente" name="CodCliente" type="text" placeholder="Codice Cliente" value="<?php echo $CodCliente ?>" />
				<label for="IdAttiva">Attiva: </label>
				<?php if ($Attiva == 1) { ?>
					<input id="IdAttiva" name="Attiva" type="checkbox" checked />
				<?php } else { ?>
					<input id="IdAttiva" name="Attiva" type="checkbox" />
				<?php } ?>
				<label for="IdDataChRic">Data Chiusura: </label>
				<input id="IdDataChRic" name="DataCh" type="date" value="<?php echo $DataCh ?>" />
				<input type="submit" value="Cerca" />
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

					<table class="table">
						<tr class="header">
							<th>Codice</th>
							<!--th>id </th-->
							<th>Data Applicazione</th>
							<th>Indirizzo</th>
							<th>Città</th>
							<th>CodCliente</th>
							<th>Attiva</th>
							<th>Data Chiusura </th>
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
								<td> <?php echo $Codice; ?> </td>
								<td> <?php echo $DataAp; ?> </td>
								<td> <?php echo $Indirizzo; ?> </td>
								<td> <?php echo $Citta ?> </td>
								<td> <?php echo riferimentoCliente($CodCliente); ?> </td>
								<td> <?php echo $Attiva ?> </td>
								<td> <?php echo $DataCh ?> </td>
								<td> <?php echo modificaUtenza($Codice); ?></td>
								<td> <?php echo linkEliminaUtenza($Codice) ?></td>
							</tr>
						<?php } ?>
					</table>
				<?php }  ?>

			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="../js/script.js" defer></script>

</html>