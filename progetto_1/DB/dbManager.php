<?php
include 'connDb.php';
function getUtenze($Codice, $DataAp, $Indirizzo, $Citta, $CodCliente, $Attiva, $DataCh): string
{
	$qry = "SELECT 	* FROM Utenza WHERE 1=1 ";

	if ($Codice != "" || $Codice!=0)
		$qry = $qry . "AND Utenza.Codice = '" . $Codice . "'";

	if ($DataAp != "")
		$qry = $qry . "AND Utenza.DataAp LIKE '%" . $DataAp . "%' ";

	if ($Indirizzo != "")
		$qry = $qry . "AND (Utenza.Indirizzo LIKE '" . $Indirizzo . "%' OR Utenza.Indirizzo LIKE 'Via " . $Indirizzo . "%' 
		OR Utenza.Indirizzo LIKE 'Corso " . $Indirizzo . "%' OR Utenza.Indirizzo LIKE 'Piazza " . $Indirizzo . "%'
		OR Utenza.Indirizzo LIKE 'Viale " . $Indirizzo . "%')";

	if ($Citta != "")
		$qry = $qry . "AND Utenza.Città LIKE '" . $Citta . "%' ";

	if ($CodCliente != "")
		$qry = $qry . "AND Utenza.CodCliente = '" . $CodCliente . "' ";

	if ($Attiva == 1)
		$qry = $qry . "AND Utenza.Attiva = '" . $Attiva . "' ";

	if ($DataCh != "")
		$qry = $qry . "AND Utenza.DataCh LIKE '%" . $DataCh . "%' ";
	return $qry . " ORDER BY Utenza.Codice ";
}
function getCliente($Codice, $CF, $RagSoc, $Indirizzo, $citta): string
{
	$qry = "SELECT 	* FROM Cliente WHERE 1=1 ";

	if ($Codice != "")
		$qry = $qry . "AND Cliente.Codice = '" . $Codice . "' ";

	if ($CF != "")
		$qry = $qry . "AND Cliente.CF = '" . $CF . "' ";

	if ($RagSoc != "")
		$qry = $qry . "AND Cliente.RagSoc LIKE '%" . $RagSoc . "%' ";

	if ($Indirizzo != "")
	$qry = $qry . "AND (Cliente.Indirizzo LIKE '" . $Indirizzo . "%' OR Cliente.Indirizzo LIKE 'Via " . $Indirizzo . "%' 
	OR Cliente.Indirizzo LIKE 'Corso " . $Indirizzo . "%' OR Cliente.Indirizzo LIKE 'Piazza " . $Indirizzo . "%'
	OR Cliente.Indirizzo LIKE 'Viale " . $Indirizzo . "%')";

	if ($citta != "")
		$qry = $qry . "AND Cliente.citta LIKE '" . $citta . "%' ";

	return $qry . " ORDER BY Cliente.Codice";
}
function getLettura($Numero, $CodUtenza, $Data, $Valore, $NumFattura): string
{
	$qry = "SELECT 	* FROM Lettura WHERE 1=1 ";

	if ($Numero != "")
		$qry = $qry . "AND Lettura.Numero = '" . $Numero . " '";

	if ($Data != "")
		$qry = $qry . "AND Lettura.Data LIKE '%" . $Data . "%' ";

	if ($CodUtenza != "")
		$qry = $qry . "AND Lettura.CodUtenza = '" . $CodUtenza . "' ";

	if ($Valore != "")
		$qry = $qry . "AND Lettura.Valore = '" . $Valore . "' ";

	if ($NumFattura != "")
		$qry = $qry . "AND Lettura.NumFattura = '" . $NumFattura . "' ";

	return $qry . " ORDER BY Lettura.Numero";
}
function getFattura($Numero, $Imponibile, $Data, $Iva, $Totale): string
{
	$qry = "SELECT 	* FROM Fattura WHERE 1=1 ";

	if ($Numero != "")
		$qry = $qry . "AND Fattura.Numero = '" . $Numero . " '";

	if ($Data != "")
		$qry = $qry . "AND Fattura.Data LIKE '%" . $Data . "%' ";

	if ($Imponibile != "")
		$qry = $qry . "AND Fattura.Imponibile = '" . $Imponibile . "' ";

	if ($Iva != "")
		$qry = $qry . "AND Fattura.Iva = '" . $Iva . "' ";

	if ($Totale != "")
		$qry = $qry . "AND Fattura.Totale = '" . $Totale . "' ";

	return $qry . " ORDER BY Fattura.Numero";
}

function riferimentoCliente($nome, $CodCliente): string
{
	if (is_null($CodCliente) || $CodCliente == "")
		return "";
	return "<a href='Cliente.php?Codice=" . $CodCliente . "'>" . $nome . "</a>";
}

function riferimentoUtenza($CodUtenza): string
{
	if (is_null($CodUtenza) || $CodUtenza == "")
		return "";
	return "<a href='Utenza.php?Codice=" . $CodUtenza . "'>" . $CodUtenza . "</a>";
}

function riferimentoFattura($NumFattura): string
{
	if (is_null($NumFattura) || $NumFattura == "")
		return "";
	return "<a href='Fattura.php?Numero=" . $NumFattura . "'>" . $NumFattura . "</a>";
}

function modificaUtenza($Codice): string
{
	if (is_null($Codice) || $Codice == "")
		return "";
	return "<a href='ModificaUtenza.php?Codice=" . $Codice . "'>
			<img src='../img/Modifica.png' alt='Modifica' class='icona'>
			</a>";
}

function linkEliminaUtenza($Codice)
{
	if (is_null($Codice) || $Codice == "")
		return "";
	return "<a href='EliminaUtenza.php?Codice=" . $Codice . "'  >Elimina</a>";
}

function setUtenze($Codice, $DataAp, $Indirizzo, $Citta, $CodCliente, $Attiva, $DataCh): string
{

	$qry = "UPDATE Utenza SET ";
	$qry = $qry . " Utenza.DataAp='" . $DataAp . "' ";
	$qry = $qry . ", Utenza.Indirizzo = '" . $Indirizzo . "' ";
	$qry = $qry . ", Utenza.Città = '" . $Citta . "' ";
	$qry = $qry . ", Utenza.CodCliente = '" . $CodCliente . "' ";
	$qry = $qry . ", Utenza.Attiva = '" . $Attiva . "' ";
	if ($DataCh != "NULL")
		$qry = $qry . ", Utenza.DataCh='" . $DataCh . "' ";
	$qry = $qry . " WHERE Utenza.Codice='" . $Codice . "' ";


	return $qry;
}

function insertUtenze($DataAp, $Indirizzo, $Citta, $CodCliente, $Attiva, $DataCh): string
{
	$qry = "INSERT INTO Utenza(DataAp, Indirizzo, Città, CodCliente, Attiva, DataCh) VALUES(";

	$qry .= "'" . $DataAp . "', ";
	$qry .= "'" . $Indirizzo . "', ";
	$qry .= "'" . $Citta . "', ";
	$qry .= "'" . $CodCliente . "', ";
	$qry .= "'" . $Attiva . "', ";

	if ($DataCh != "NULL") {
		$qry .= "'" . $DataCh . "'";
	} else {
		$qry .= "NULL";
	}
	$qry .= ")";
	echo "<script> alert(" . $qry . ")</script>";

	return $qry;
}

function controllo($Attiva, $DataCh,$DataAp)
{
	if ($Attiva == 1 && $DataCh != "NULL") {
		$response = "NON E' POSSIBILE METTERE LA DATA DI CHIUSURA SE E' ANCORA ATTIVA";

		echo ("<script>alert('" . $response . "')</script>");
		return false;
	} else if (($Attiva == 0 && $DataCh == "NULL")|| ($DataAp>=$DataCh)) {
		//$response = "NECESSARIO INSERIRE DATI CORRETTI";
		//echo ("<script>alert('" . $response . "')</script>");
		return false;
	} else {
		return true;
	}
}
function numeroUtenza($Codice): String
{
	$qry = "SELECT COUNT(*) as NumeroUtenze FROM Utenza WHERE CodCliente = '" . $Codice . "'";

	return $qry;
}
function riferimentoNumeroUtenze($numero, $CodCliente): String
{
	if (is_null($CodCliente) || $CodCliente == "")
		return "";
	return "<a href='Utenza.php?CodCliente=" . $CodCliente . "'>" . $numero . "</a>";
}

function numeroLetture($Codice): String
{
	$qry = "SELECT COUNT(*) as NumeroLetture FROM Lettura WHERE CodUtenza = '" . $Codice . "'";

	return $qry;
}

function riferimentoNumeroLettura($numero, $CodUtenza): String
{
	if (is_null($CodUtenza) || $CodUtenza == "")
		return "";
	return "<a href='Lettura.php?CodUtenza=" . $CodUtenza . "'>" . $numero . "</a>";
}

function numeroLettureDaFattura($Numero): string
{
	$qry = "SELECT COUNT(*) as NumeroLetture FROM Lettura WHERE NumFattura = '" . $Numero . "'";

	return $qry;
}

function riferimentoNumeroLetturaDaFattura($numero, $NumeroFattura): string
{
	if (is_null($NumeroFattura) || $NumeroFattura == "")
		return "";
	return "<a href='Lettura.php?NumFattura=" . $NumeroFattura . "'>" . $numero . "</a>";
}

function nomeCliente($CodCliente): string
{
	$qry = "SELECT RagSoc FROM Cliente WHERE Codice = '" . $CodCliente . "'";
	return $qry;
}

function controllaUtente($CodCliente){
	//Controllo se il codice cliente è presente nella tabella cliente
	$qry = "SELECT  * FROM Cliente WHERE Codice = '" . $CodCliente . "'";
	//Eseguo la query e controllo se il risultato è 0

	//Se è 0 allora il codice cliente non è presente nella tabella cliente
	//Quindi ritorno false
	//Altrimenti ritorno true
	return $qry;

}