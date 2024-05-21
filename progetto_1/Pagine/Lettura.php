<!DOCTYPE HTML>
<html lang="it">

<head>
	<title>Lettura</title>

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
	$CodUtenza  = "";
	$Data = "";
	$Valore  = "";
	$NumFattura = "";

	if (count($_POST) > 0) {
		$Numero = $_POST["Numero"];
		$CodUtenza = $_POST["CodUtenza"];
		$Data = $_POST["Data"];
		$Valore = $_POST["Valore"];
		$NumFattura = $_POST["NumFattura"];
	} else if (count($_GET) > 0) {
		$Numero = $_GET["Numero"];
		$CodUtenza = $_GET["CodUtenza"];
		$Data = $_GET["Data"];
		$Valore = $_GET["Valore"];
		$NumFattura = $_GET["NumFattura"];
	}
	?>

	<div class="main">

		<?php
		include '../Extra/nav.html';
		?>

		<div id="content">
			<h2>Letture</h2>
			<hr>
			<h4>Filtri:</h4>
			<form id="searchForm" name="myform" method="POST">
				<input id="IdCodice" name="Numero" type="number" placeholder="Numero" value="<?php echo $Numero; ?>" min="1" />
				<input id="IdCodUtenza" name="CodUtenza" type="number" placeholder="CodUtenza" value="<?php echo $CodUtenza; ?>" min="1" />
				<label for="IdData">Data Lettura: </label>
				<input id="IdData" name="Data" type="date" placeholder="Data" value="<?php echo $Data; ?>" /> <br> <br>
				<input id="IdValore" name="Valore" type="number" placeholder="Valore" value="<?php echo $Valore; ?>" min="1" />
				<input id="IdNumFattura" name="NumFattura" type="number" placeholder="NumFattura" value="<?php echo $NumFattura; ?>" min="1" />
				<input type="submit" value="Cerca" />
				<input type="button" id="reset" value="Cancella" />
			</form>
			<hr>

			<div id="results" class="tabella-scorrevole">

				<?php
				$query = getLettura($Numero, $CodUtenza, $Data, $Valore, $NumFattura);

				try {
					$result = $conn->query($query);
				} catch (PDOException $e) {
					echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
					$error = true;
				}

				if (!$error) {
				?>

					<table class="table" id="myTableLettura">
						<tr class="header">
							<th onclick="sortTableLettura(0)">Numero</th>
							<th onclick="sortTableLettura(1)">Codice Utenza</th>
							<th onclick="sortTableLettura(2)">Data Lettura</th>
							<th onclick="sortTableLettura(3)">Valore</th>
							<th onclick="sortTableLettura(4)">Numero Fattura</th>
						</tr>

						<?php
						foreach ($result as $riga) {
							$Numero = $riga["Numero"];
							$CodUtenza = $riga["CodUtenza"];
							$Data = $riga["Data"];
							$Valore = $riga["Valore"];
							$NumFattura = $riga["NumFattura"];
						?>
							<tr class="riga">
								<td class="centerTD"> <?php echo $Numero; ?> </td>
								<td class="centerTD"> <?php echo riferimentoUtenza($CodUtenza); ?> </td>
								<td> <?php echo $Data; ?> </td>
								<td> <?php echo $Valore; ?> </td>
								<td class="centerTD"> <?php echo riferimentoFattura($NumFattura); ?> </td>
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