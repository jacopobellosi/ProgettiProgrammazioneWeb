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
			<form name="myform" method="POST">
				<input id="Codice" name="Codice" type="text" placeholder="Codice" value="<?php echo $Codice; ?>" />
				<input id="CF" name="CF" type="text" placeholder="Codice Fiscale" value="<?php echo $CF; ?>" />
				<input id="RagSoc" name="RagSoc" type="text" placeholder="Ragione Sociale" value="<?php echo $RagSoc; ?>" /> <br> <br>
				<input id="Indirizzo" name="Indirizzo" type="text" placeholder="Indirizzo" value="<?php echo $Indirizzo; ?>" />
				<input id="Citta" name="Citta" type="text" placeholder="Città" value="<?php echo $Citta; ?>">
				<input type="submit" value="Cerca" />
			</form>
			<hr>

			<div id="results" class="tabella-scorrevole">
				<?php

				$query = getCliente($Codice, $CF, $RagSoc, $Indirizzo, $Citta);
				echo "<p>getCliente: " . $query . "</p>";

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
							<th>Codice </th>
							<th>Codice Fiscale</th>
							<th>Ragione Sociale</th>
							<th>Indirizzo</th>
							<th>Città</th>
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
							$CF = $riga["CF"];
							$RagSoc = $riga["RagSoc"];
							$Indirizzo = $riga["Indirizzo"];
							$Citta = $riga["Citta"];
						?>
							<tr <?php echo $classRiga; ?>>
								<td> <?php echo $Codice; ?> </td>
								<td> <?php echo $CF; ?> </td>
								<td> <?php echo  $RagSoc ?> </td>
								<td> <?php echo $Indirizzo; ?> </td>
								<td> <?php echo  $Citta; ?> </td>
							</tr>
						<?php } ?>
					</table>
				<?php }  ?>

			</div>
		</div>
	</div>

</body>

</html>