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
	include '../Extra/nav.html';
	include '../Extra/footer.html';
	include '../DB/dbManager.php';
	include '../DB/connDb.php';
	?>

	<div class="main">
		<?php
		include '../Extra/nav.html';
		?>
		<div id="content">
			<h2>Letture</h2>
			<form name="myform" method="POST">
				<input id="Numero" name="Numero" type="text" placeholder="Numero" />
				<input id="CodUtenza" name="CodUtenza" type="text" placeholder="CodUtenza" />
				<input id="Data" name="Data" type="text" placeholder="Data" />
				<input id="Valore" name="Valore" type="text" placeholder="Valore" />
				<input id="NumerFattura" name="NumerFattura" type="text" placeholder="NumerFattura" />
				<input type="submit" value="Cerca" />
			</form>

			<div id="results">
				<?php
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
							<!--th>id </th-->
							<th>CodUtenza</th>
							<th>Data</th>
							<th>Valore</th>
							<th>NumFattura</th>
						</tr>
						<?php
						$i = 0;
						foreach ($result as $riga) {
							$i = $i + 1;
							$classRiga = 'class="rowOdd"';
							if ($i % 2 == 0) {
								$classRiga = 'class="rowEven"';
							}
							$NumFattura = $riga["Numero"];
							$CodUtenza = $riga["CodUtenza"];
							$Data = $riga["Data"];
							$Valore = $riga["Valore"];
							$NumFattura = $riga["NumFattura"];

						?>
							<tr <?php echo $classRiga; ?>>
								<td> <?php echo $NumFattura; ?> </td>
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