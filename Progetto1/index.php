<!DOCTYPE html>
<html lang="it">

<head>
	<title>Gestore Acque</title>

	<meta charset="UTF-8">
	<meta name="description" content="Gestore database per Distribuzioni Acque">
	<meta name="author" content="Bellosi Jacopo, Signori Alessandro">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Cache-control" content="public">

	<link rel="stylesheet" href="../css/stile.css">
</head>

<body>
	<?php
	include 'Extra/header.html';
	?>

	<div class="main">
		<nav>
			<ol>
				<li><a href="Pagine/Utenza.php">Utenze</a></li>
				<li><a href="Pagine/Cliente.php">Clienti</a></li>
				<li><a href="Pagine/Lettura.php">Letture</a></li>
				<li><a href="Pagine/Fattura.php">Fatture</a></li>
				<li><a href="Pagine/Inserimento.php">Inserimento Utenze</a></li>
				<li><a href="index.php">Back Home</a></li>
			</ol>
		</nav>
		<div id="content">
			<h3>Introduzione</h3>
			<p>Questo portale è stato sviluppato per fornire agli addetti dell'erogazione acque un accesso facile e veloce alle informazioni relative al servizio di distribuzione dell'acqua. Il portale consente di effettuare ricerche e visualizzare dati relativi a:</p>
			<ul>
				<li>Utenze: Codice (univoco) di utenza, data di apertura, indirizzo di erogazione, città, stato utenza: attiva/inattiva (con data di disattivazione se inattiva), cliente associato;</li>
				<li>Clienti: Codice (univoco) cliente, ragione sociale, indirizzo di residenza, città, codice fiscale;</li>
				<li>Letture: Numero lettura, data della lettura, valore letto, utenza a cui si riferisce;</li>
				<li>Fatture: Numero fattura (univoco), data emissione, imponibile, IVA, totale da pagare, letture fatturate.</li>
			</ul>

			<h3>Ricerca di valori</h3>
			<p>Il portale offre una potente funzionalità di ricerca che permette di trovare rapidamente i dati desiderati. È possibile effettuare ricerche per filtri per restringere i risultati della ricerca a un intervallo di date, a un tipo di utenza (attiva o inattiva) o ad un altro criterio specifico.</p>

			<h3>Visualizzazione dei dati</h3>
			<p>Una volta trovati i dati desiderati, il portale li visualizza in modo chiaro e organizzato. È possibile visualizzare i dettagli di ogni record, nonché esportarli in formato CSV o PDF.</p>

			<h3>Benefici</h3>
			<p>Il portale di gestione del servizio di distribuzione acqua offre numerosi vantaggi agli utenti, tra cui:</p>
			<ul>
				<li>Accesso rapido e facile alle informazioni: Gli addetti possono trovare le informazioni di cui hanno bisogno in pochi clic;</li>
				<li>Visualizzazione chiara dei dati: I dati sono visualizzati in modo chiaro e organizzato, facilitando la loro comprensione;</li>
				<li>Esportazione dei dati: È possibile esportare i dati in formato CSV o PDF per un'ulteriore analisi o archiviazione.</li>
			</ul>
		</div>
	</div>
	<div>
		<?php
		include 'Extra/footer.html';
		?>
	</div>
</body>

</html>