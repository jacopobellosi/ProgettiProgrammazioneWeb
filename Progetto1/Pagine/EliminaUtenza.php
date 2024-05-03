<?php
    include '../DB/dbManager.php';
    include '../DB/connDb.php';

    $Codice = "";
	if(count($_POST)>0) {
		$Codice = $_POST["Codice"];
	}	     
	else if(count($_GET)>0) {
		$Codice = $_GET["Codice"];
	}	
    if (is_null($Codice) || $Codice == "")
        return "";

    $qry = "DELETE FROM Utenza WHERE ";	
    
    #potrebbe non servire if
    if ($Codice != "")
        $qry = $qry . "Utenza.Codice = '" . $Codice . "'";

    try {   
        $result = $conn->query($qry);
    } catch(PDOException$e) {

        echo "<p>DB Error on Query: " . $e->getMessage() . "</p>";
        $error = true;
        echo("<script>alert(".$e->getMessage().")</script>");

        echo("ecco la ".$qry);
        echo $qry;
    }
    #anche questo potrebbe non servire
    if(!$error) {
        echo("<script>alert('Utenza'".$Codice."' eliminata correttamente)</script>");

    }
    header('Location: '."Utenza.php");
    echo("<script>alert('Utenza'".$Codice."' eliminata correttamente)</script>");
    die();
?>