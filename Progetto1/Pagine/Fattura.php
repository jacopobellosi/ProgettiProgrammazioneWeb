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
	<link rel="icon" href="../img/logo.jpeg" type="image/x-icon"  alt="Logo" />
</head>

<body>
	<?php
	include '../Extra/header.html';
	include '../Extra/footer.html';
	include '../DB/dbManager.php';
	include '../DB/connDb.php';
	?>

	<div class="main">
		<?php
		include '../Extra/nav.html';
		?>
		<div id="content">
			<h2>Fatture</h2>
			<form name="myform" method="POST">
				<input id="Numero" name="Numero" type="text" placeholder="Numero" />
				<input id="Data" name="Data" type="text" placeholder="Data" />
				<input id="Imponibile" name="Imponibile" type="text" placeholder="Imponibile" />
				<input id="Iva" name="Iva" type="text" placeholder="Iva" />
				<input id="Totale" name="Totale" type="text" placeholder="Totale" />
				<input type="submit" value="Cerca" />
			</form>

			<div id="results">
				<?php
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
				$query = getFattura($Numero, $Imponibile, $Data, $Iva, $Totale);
				echo "<p>getFattura: " . $query . "</p>";

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
							<th>Data</th>
							<th>Imponibile</th>
							<th>Iva</th>
							<th>Totale</th>
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
							$Data = $riga["Data"];
							$Imponibile = $riga["Imponibile"];
							$Iva = $riga["Iva"];
							$Totale = $riga["Totale"];

						?>
							<tr <?php echo $classRiga; ?>>
								<td> <?php echo $Numero; ?> </td>
								<td> <?php echo $Data; ?> </td>
								<td> <?php echo $Imponibile; ?> </td>
								<td> <?php echo $Iva; ?> </td>
								<td> <?php echo $Totale ?> </td>
							</tr>
						<?php } ?>
					</table>
				<?php }  ?>

			</div>
		</div>
	</div>

</body>

</html>