<!DOCTYPE HTML>
<html lang="it">

<head>
	<title>Fattura</title>

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

	$Numero = "";
	$Data  = "";
	$Imponibile = "";
	$Iva  = "";
	$Totale = "";

	if (count($_POST) > 0) {
		$Numero = $_POST["Numero"];
		$Imponibile = $_POST["Imponibile"];
		$Data = $_POST["Data"];
		$Iva = $_POST["Iva"];
		$Totale = $_POST["Totale"];
	} else if (count($_GET) > 0) {
		$Numero = $_GET["Numero"];
		$Imponibile = $_GET["Imponibile"];
		$Data = $_GET["Data"];
		$Iva = $_GET["Iva"];
		$Totale = $_GET["Totale"];
	}
	?>

	<div class="main">

		<?php
		include '../Extra/nav.html';
		?>

		<div id="content">
			<h2>Fatture</h2>
			<hr>
			<h4>Filtri:</h4>
			<form name="myform" id="searchForm" method="POST">
				<input id="IdCodice" name="Numero" type="number" placeholder="Numero" value="<?php echo $Numero; ?>" min="1" />
				<input id="IdData" name="Data" type="date" placeholder="Data" value="<?php echo $Data; ?>" />
				<input id="IdImponibile" name="Imponibile" type="number" placeholder="Imponibile" value="<?php echo $Imponibile; ?>" min="1" /> <br> <br>
				<input id="IdIva" name="Iva" type="number" placeholder="Iva" value="<?php echo $Iva; ?>" min="1" />
				<input id="IdTotale" name="Totale" type="number" placeholder="Totale" value="<?php echo $Totale; ?>" min="1" />
				<input type="submit" value="Cerca" />
				<input type="button" id="reset" value="Cancella" />
			</form>
			<hr>

			<div id="results" class="tabella-scorrevole">

				<?php
				$query = getFattura($Numero, $Imponibile, $Data, $Iva, $Totale);

				try {
					$result = $conn->query($query);
				} catch (PDOException $e) {
					echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
					$error = true;
				}

				if (!$error) {
				?>

					<table class="table" id="myTableFattura">
						<tr class="header">
							<th onclick="sortTableFattura(0)">Numero</th>
							<th onclick="sortTableFattura(1)">Data</th>
							<th onclick="sortTableFattura(2)">Imponibile</th>
							<th onclick="sortTableFattura(3)">Iva</th>
							<th onclick="sortTableFattura(4)">Totale</th>
							<th onclick="sortTableFattura(5)">Numero Letture</th>
						</tr>

						<?php
						foreach ($result as $riga) {
							$Numero = $riga["Numero"];
							$Data = $riga["Data"];
							$Imponibile = $riga["Imponibile"];
							$Iva = $riga["Iva"];
							$Totale = $riga["Totale"];
						?>
							<tr class="riga">
								<td class="centerTD"> <?php echo $Numero; ?> </td>
								<td> <?php echo $Data; ?> </td>
								<td> <?php echo $Imponibile; ?> </td>
								<td> <?php echo $Iva; ?> </td>
								<td> <?php echo $Totale ?> </td>

								<?php
								try {
									$result = $conn->query(numeroLettureDaFattura($Numero));
								} catch (PDOException $e) {
									echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
									$error = true;
								}

								foreach ($result as $riga)
									$NumLet = $riga["NumeroLetture"];
								?>

								<td class="centerTD"> <?php echo  riferimentoNumeroLetturaDaFattura($NumLet, $Numero); ?> </td>
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