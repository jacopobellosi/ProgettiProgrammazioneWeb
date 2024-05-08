<!DOCTYPE HTML>
<html lang="it">

<head>
	<title>Modifica Utenza</title>
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

			<?php
			$error = false;
			
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
				if(isset($_POST["Attiva"]))  {
					$Attiva = 1;
					$DataCh  = "NULL";
				} else {
					$Attiva = 0;
					$DataCh  = $_POST["DataCh"];
				}

				if (controllo($Attiva, $DataCh)) {
					$query = setUtenze($Codice, $DataAp, $Indirizzo, $Citta, $CodCliente, $Attiva, $DataCh);
					try {
						$result = $conn->query($query);
					} catch (PDOException $e) {
						echo "<h3>DB Error on Query: " . $e->getMessage() . "</h3>";
						$error = true;
					}
					//non stampa qui
					if (!$error) {
						header('Location: ' . "Utenza.php");
						echo ("<script>alert('Modifica andata a buon fine')</script>");
					} else {
						echo ("<script>alert(" . $error . ")</script>");
					}
				}
			} else if (count($_GET) > 0) {
				$Codice = $_GET["Codice"];
			}

			$query = getUtenze($Codice, $DataAp = "", $Indirizzo = "", $Citta = "", $CodCliente = "", $Attiva = "", $DataCh = "");
			echo "<p>getUtenza: " . $query . "</p>";
			try {
				$result = $conn->query($query);
			} catch (PDOException $e) {
				echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
				$error = true;
			}

			if (!$error) {
			?>
				<form name="myform" method="POST">
					<table class="smalltable">
						<tr class="header">
							<th>Codice</th>
							<th>Data Applicazione</th>
							<th>Indirizzo</th>
							<th>Città</th>
							<th>CodCliente</th>
							<th>Attiva</th>
							<th>Data Chiusura </th>
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
							if($riga["Attiva"] == 1) {
								$checked = "checked";
								$disable = "disabled";
							}
							else {
								$checked = "";
								$disable = "";
							}
							$DataCh = $riga["DataCh"];

						?>

							<tr <?php echo $classRiga; ?>>
								<td> <input id="IdCodice" name="Codice" type="text" value=<?php echo $Codice; ?> readonly /> </td>
								<td> <input id="IdDataApMod" name="DataAp" type="date" value=<?php echo $DataAp; ?> /> </td>
								<td> <input id="IdIndirizzo" name="Indirizzo" type="text" placeholder="Indirizzo" value='<?php echo $Indirizzo; ?>' /> </td>
								<td> <input id="IdCitta" name="Citta" type="text" placeholder="Città" value='<?php echo $Citta ?>' /> </td>
								<td> <input id="IdCodCliente" name="CodCliente" type="text" placeholder="Codice Cliente" value=<?php echo $CodCliente ?> /> </td>
								<?php echo "<td> <input id='IdAttiva' name='Attiva' type='checkbox' ". $checked ." /> </td>" ?>
								<?php echo "<td> <input id='IdDataChMod' name='DataCh' type='date' value='". $DataCh ."' ". $disable. " /> </td>" ?>
							</tr>
						<?php } ?>
					</table>
					<br>
					<input type="submit" value="Applica modifiche" />
				</form>
			<?php }  ?>

		</div>
	</div>
	</div>
</body>
<script type="text/javascript" src="../js/script.js" defer></script>
</html>