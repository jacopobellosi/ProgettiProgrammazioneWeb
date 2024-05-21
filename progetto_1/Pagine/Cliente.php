<!DOCTYPE HTML>
<html lang="it">

<head>
	<title>Cliente</title>

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
	$CF  = "";
	$RagSoc = "";
	$Indirizzo  = "";
	$Citta = "";

	if (count($_POST) > 0) {
		$Codice = $_POST["Codice"];
		$CF = $_POST["CF"];
		$RagSoc = $_POST["RagSoc"];
		$Indirizzo = $_POST["Indirizzo"];
		$Citta = $_POST["Citta"];
	} else if (count($_GET) > 0) {
		$Codice = $_GET["Codice"];
		$CF = $_GET["CF"];
		$RagSoc = $_GET["RagSoc"];
		$Indirizzo = $_GET["Indirizzo"];
		$Citta = $_GET["Citta"];
	}
	?>

	<div class="main">

		<?php
		include '../Extra/nav.html';
		?>

		<div id="content">
			<h2>Clienti</h2>
			<hr>
			<h4>Filtri:</h4>
			<form name="myform" id="searchForm" method="POST">
				<input id="IdCodice" name="Codice" type="number" placeholder="Codice" value="<?php echo $Codice; ?>" min="1" />
				<input id="IdCF" name="CF" type="text" pattern="[\p{L} \d]+"  title="Vietato mettere apici o virgolette " placeholder="Codice Fiscale" value="<?php echo $CF; ?>" />
				<input id="IdRagSoc" name="RagSoc" pattern="[\p{L} \d]+"  title="Vietato mettere apici o virgolette " type="text" placeholder="Ragione Sociale" value="<?php echo $RagSoc; ?>" /> <br> <br>
				<input id="IdIndirizzo" name="Indirizzo" pattern="[\p{L} \d]+" title="Vietato mettere apici o virgolette " type="text" placeholder="Indirizzo" value="<?php echo $Indirizzo; ?>" />
				<input id="IdCitta" name="Citta" type="text" pattern="[\p{L} \d]+" title="Vietato mettere apici o virgolette " placeholder="Città" value="<?php echo $Citta; ?>">
				<input type="submit" value="Cerca" />
				<input type="button" id="reset" value="Cancella" />
			</form>
			<hr>

			<div id="results" class="tabella-scorrevole">

				<?php
				$query = getCliente($Codice, $CF, $RagSoc, $Indirizzo, $Citta);

				try {
					$result = $conn->query($query);
				} catch (PDOException $e) {
					echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
					$error = true;
				}

				if (!$error) {
				?>
					<table class="table" id="myTableCliente">
						<tr class="header">
							<th onclick="sortTableCliente(0)"> Codice </th>
							<th onclick="sortTableCliente(1)">Codice Fiscale</th>
							<th onclick="sortTableCliente(2)">Ragione Sociale</th>
							<th onclick="sortTableCliente(3)">Indirizzo</th>
							<th onclick="sortTableCliente(4)">Città</th>
							<th onclick="sortTableCliente(5)">Numero Utenze</th>
						</tr>

						<?php
						foreach ($result as $riga) {
							$Codice = $riga["Codice"];
							$CF = $riga["CF"];
							$RagSoc = $riga["RagSoc"];
							$Indirizzo = $riga["Indirizzo"];
							$Citta = $riga["Citta"];
						?>

							<tr class="riga">
								<td class="centerTD"> <?php echo $Codice; ?> </td>
								<td> <?php echo $CF; ?> </td>
								<td> <?php echo  $RagSoc ?> </td>
								<td> <?php echo $Indirizzo; ?> </td>
								<td> <?php echo  $Citta; ?> </td>

								<?php
								try {
									$result = $conn->query(numeroUtenza($Codice));
								} catch (PDOException $e) {
									echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
									$error = true;
								}

								foreach ($result as $riga)
									$NumUtenze = $riga["NumeroUtenze"];
								?>

								<td class="centerTD"> <?php echo riferimentoNumeroUtenze($NumUtenze, $Codice); ?> </td>

							<?php } ?>

					</table>

				<?php }  ?>

			</div>
		</div>
	</div>

</body>

<script type=" text/javascript" src="../js/script.js" defer></script>

</html>