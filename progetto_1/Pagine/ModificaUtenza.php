<!DOCTYPE HTML>
<html lang="it">

<head>
	<title>Modifica Utenza</title>
	<link rel="stylesheet" href="../css/stile.css">
	<link rel="icon" href="../img/logo.jpeg" type="image/x-icon" alt="Logo" />
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

				if (isset($_POST["Attiva"])) {
					$Attiva = 1;
					$DataCh  = "NULL";
				} else {
					$Attiva = 0;
					$DataCh  = $_POST["DataCh"];
				}

				if (controllo($Attiva, $DataCh, $DataAp)) {
					$query_utente= controllaUtente($CodCliente);
					try {
						$risulatto = $conn->query($query_utente);
					} catch (PDOException $e) {
						echo "<h3 class='msg'>DB Error on Query: " . $e->getMessage() . "</h3>";
						$error = true;
					}
					//controllo se è stato trovto un utente con quel codice
					//echo ("<script>alert('Utenti trovati " . $risulatto->rowCount() . "')</script>");
					if ($risulatto->rowCount() != 0) {
						if ($Codice != "") {
							$query_modifica = setUtenze($Codice, $DataAp, $Indirizzo, $Citta, $CodCliente, $Attiva, $DataCh);

							try {
								$result = $conn->query($query_modifica);
							} catch (PDOException $e) {
								echo "<h3>DB Error on Query: " . $e->getMessage() . " nell' aggiornamento</h3>";
								$error = true;
							}

							if (!$error) {
								header('Location: ' . "Utenza.php");
							} else {
								echo ("<script>alert('Errore durante la connessione" . $error . "')</script>");
							}
						} else {
							$query_inserimento = insertUtenze($DataAp, $Indirizzo, $Citta, $CodCliente, $Attiva, $DataCh);

							try {
								$result = $conn->query($query_inserimento);
							} catch (PDOException $e) {
								echo "<h3>DB Error on Query: " . $e->getMessage() . " durante l'inserimento</h3>";
								$error = true;
							}

							if (!$error) {
								header('Location: ' . "Utenza.php");
							} else {
								echo ("<script>alert(" . $error . ");//window.location = 'Utenza.php?Codice=".$Codice."';</script>");
							}
						}
					} else {
						if($Codice == ""){
							echo ("<script>alert('Inserire un codice cliente valido!');window.location = 'ModificaUtenza.php';</script>");
						}else{
							echo ("<script>alert('Cliente non esistente!');window.location = 'ModificaUtenza.php?Codice=".$Codice."';</script>");
						}
						
					}
				} else {
					if($Codice == ""){
						echo ("<script>alert('Dati inseriti non corretti!');window.location = 'ModificaUtenza.php';</script>");
					}else{
						echo ("<script>alert('Dati inseriti non corretti!');window.location = 'ModificaUtenza.php?Codice=".$Codice."';</script>");
					}
					
					//header('Location: ' . "Utenza.php?Codice=".$Codice."");

				}
			} else if (count($_GET) > 0) {
				// DA QUI FINISCE LA PARTE SULL'INSERIMENTO E COMINCIA QUELLA SULLA MODIFICA
				//rilevo il codice passato per get dall'Utenza
				$Codice = $_GET["Codice"];
				$query = getUtenze($Codice, $DataAp = "", $Indirizzo = "", $Citta = "", $CodCliente = "", $Attiva = "", $DataCh = "");

				try {
					$result = $conn->query($query);
				} catch (PDOException $e) {
					echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
					$error = true;
				}

				if (!$error) {
			?>
				<h2>Modifica l'utenza</h2>
				<hr>
					<br>
					<form name="myform" method="POST">
						<table class="smalltable">
							<tr class="header">

								<th>Codice</th>
								<th>Data Applicazione</th>
								<th>Indirizzo</th>
								<th>Città</th>
								<th>Codice Cliente</th>
								<th>Attiva</th>
								<th>Data Chiusura </th>
							</tr>

							<?php
							foreach ($result as $riga) {
								$Codice = $riga["Codice"];
								$DataAp = $riga["DataAp"];
								$Indirizzo = $riga["Indirizzo"];
								$Citta = $riga["Città"];
								$CodCliente = $riga["CodCliente"];

								if ($riga["Attiva"] == 1) {
									$checked = "checked";
									$disable = "disabled";
								} else {
									$checked = "";
									$disable = "";
								}

								$DataCh = $riga["DataCh"];
							?>

								<tr class="riga">
									<td> <input id='IdCodice' name='Codice' type='number' value=<?php echo $Codice; ?> readonly /> </td>
									<td> <input id="IdDataApMod" name="DataAp" type="date" value=<?php echo $DataAp; ?> required /> </td>
									<td> <input id="IdIndirizzo" name="Indirizzo" pattern="[\p{L} \d]+" type="text" placeholder="Indirizzo" value='<?php echo $Indirizzo; ?>' required /> </td>
									<td> <input id="IdCitta" name="Citta" type="text" pattern="[\p{L} \d]+" placeholder="Città" value='<?php echo $Citta ?>' required /> </td>
									<datalist name="CodCliente" id="IdCodCliente">
										<?php
										$query2 = "SELECT DISTINCT Codice FROM Cliente";

										try {
											$result2 = $conn->query($query2);
										} catch (PDOException $e) {
											echo "<h3 class='msg'>DB Error on Query: " . $e->getMessage() . "</h3>";
											$error = true;
										}
										
										foreach ($result2 as $riga2) {

											echo "<option value=" . $riga2["Codice"] . ">" . $riga2["Codice"] . "</option>";
										}
										?>
									</datalist>
									<td><input type="number" name="CodCliente" list="IdCodCliente" placeholder="Codice Cliente" value=<?php echo $CodCliente ?> min="1" required /></td>
									<?php echo "<td> <input id='IdAttiva' name='Attiva' type='checkbox' " . $checked . " /> </td>" ?>
									<?php echo "<td> <input id='IdDataChMod' name='DataCh' type='date' min='".$DataAp."' value='" . $DataCh . "' " . $disable . " /> </td>" ?>
								</tr>

							<?php } ?>

						</table>
						<br>
						<input type="submit" value="Applica modifiche" />
					</form>

				<?php
				}
			} else {
				//DA QUI IN POI e' SOLO PER l'INSERIMENTO - MA NON SI VEDE NULLA
				?>
				<h2>Aggiungi una utenza</h2>
				<hr>
				<br>
				<form name="myform" method="POST">
					<table class="smalltable">
						<tr class="header">
							<th>Data Applicazione</th>
							<th>Indirizzo</th>
							<th>Città</th>
							<th>Codice Cliente</th>
							<th>Attiva</th>
							<th>Data Chiusura </th>
						</tr>

						<tr class="riga">
							<td> <input id="IdDataApMod" name="DataAp" type="date" required /> </td>
							<td> <input id="IdIndirizzo" name="Indirizzo" pattern="[\p{L} \d]+" title="Vietato mettere apici o virgolette " type="text" placeholder="Indirizzo" required /> </td>
							<td> <input id="IdCitta" name="Citta" type="text" pattern="[\p{L} \d]+" title="Vietato mettere apici o virgolette "  placeholder="Città" required /> </td>
							<datalist name="CodCliente" id="IdCodCliente" >
								<?php
								$query2 = "SELECT DISTINCT Codice FROM Cliente";

								try {
									$result2 = $conn->query($query2);
								} catch (PDOException $e) {
									echo "<h3 class='msg'>DB Error on Query: " . $e->getMessage() . "</h3>";
									$error = true;
								}

								foreach ($result2 as $riga2) {

									echo "<option value=" . $riga2["Codice"] . ">" . $riga2["Codice"] . "</option>";
								}
								?>
							</datalist>
							<td><input type="number" name="CodCliente" list="IdCodCliente" placeholder="Codice Cliente" value=<?php echo $CodCliente ?> required /></td>
							<?php echo "<td> <input id='IdAttiva' name='Attiva' type='checkbox' " . $checked . " /> </td>" ?>
							<?php echo "<td> <input id='IdDataChMod' name='DataCh' type='date' value='" . $DataCh . "' " . $disable . " /> </td>" ?>
						</tr>
					</table>
					<br>
					<input type="submit" value="Inserisci utente" />
				</form>

			<?php }	?>

		</div>
	</div>
</body>

<script type="text/javascript" src="../js/script.js" defer></script>

</html>