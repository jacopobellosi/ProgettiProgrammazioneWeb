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
			<h2>Utenze</h2>
			<form name="myform" method="POST">
				<input id="Codice" name="Codice" type="text" placeholder="Codice" />
				<input id="DataAp" name="DataAp" type="text" placeholder="Data Applicazione" />
				<input id="Indirizzo" name="Indirizzo" type="text" placeholder="Indirizzo" />
				<input id="Citta" name="Citta" type="text" placeholder="Città" />
				<input id="CodCliente" name="CodCliente" type="text" placeholder="Codice Cliente" />
				<input id="Attiva" name="Attiva" type="text" placeholder="Attiva (1 o 0)" />
				<input id="DataCh" name="DataCh" type="text" placeholder="Data Chiusura (solo se non Attiva)" />
				<input type="submit" value="Cerca" />
			</form>

			<div id="results">
				<?php
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
					$Attiva = $_POST["Attiva"];
					$DataCh  = $_POST["DataCh"];
				} else if (count($_GET) > 0) {
					$Codice = $_GET["Codice"];
					$DataAp = $_GET["DataAp"];
					$Indirizzo  = $_GET["Indirizzo"];
					$Citta = $_GET["Citta"];
					$CodCliente  = $_GET["CodCliente"];
					$Attiva = $_GET["Attiva"];
					$DataCh  = $_GET["DataCh"];
				}
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

</html>