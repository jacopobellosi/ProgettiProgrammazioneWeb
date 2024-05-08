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
	<link rel="icon" href="../img/logo.jpeg" type="image/x-icon"  alt="Logo" />
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
			<form name="myform" method="POST">
				<input id="Numero" name="Numero" type="text" placeholder="Numero"  value="<?php echo $Numero; ?>"/>
				<input id="CodUtenza" name="CodUtenza" type="text" placeholder="CodUtenza"  value="<?php echo $CodUtenza; ?>"/>
				<input id="Data" name="Data" type="text" placeholder="Data"  value="<?php echo $Data; ?>"/> <br> <br>
				<input id="Valore" name="Valore" type="text" placeholder="Valore"  value="<?php echo $Valore; ?>"/>
				<input id="NumFattura" name="NumFattura" type="text" placeholder="NumFattura"  value="<?php echo $NumFattura; ?>"/>
				<input type="submit" value="Cerca" />
			</form>
			<hr>

			<div id="results" class="tabella-scorrevole">
				<?php

				$query = getLettura($Numero, $CodUtenza, $Data, $Valore, $NumFattura);
				echo "<p>getLettura: " . $query . "</p>";

				try {
					$result = $conn->query($query);
				} catch (PDOException $e) {
					echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
					$error = true;
				}
				if (!$error) {
				?>

					<table class="table">
						<tr class="header">
							<th>Numero</th>
							<th>Codice Utente</th>
							<th>Data</th>
							<th>Valore</th>
							<th>Numero Fattura</th>
						</tr>
						<?php
						$i = 0;
						foreach ($result as $riga) {
							$i = $i + 1;
							$classRiga = 'class="rowOdd"';
							if ($i % 2 == 0) {
								$classRiga = 'class="rowEven"';
							}
							$Numero = $riga["Numero"];
							$CodUtenza = $riga["CodUtenza"];
							$Data = $riga["Data"];
							$Valore = $riga["Valore"];
							$NumFattura = $riga["NumFattura"];

						?>
							<tr <?php echo $classRiga; ?>>
								<td> <?php echo $Numero; ?> </td>
								<td> <?php echo riferimentoUtenza($CodUtenza); ?> </td>
								<td> <?php echo $Data; ?> </td>
								<td> <?php echo $Valore; ?> </td>
								<td> <?php echo riferimentoFattura($NumFattura); ?> </td>
							</tr>
						<?php } ?>
					</table>
				<?php }  ?>

			</div>
		</div>
	</div>

</body>

</html>