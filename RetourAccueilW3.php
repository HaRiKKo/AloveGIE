<!DOCTYPE html>
<?php
session_start();
?>
<html lang="fr">
<head>
<title>RETOUR ACCUEIL</title>
<meta charset="UTF-8">
<link rel="icon" href="logo3.jpg" />
<link rel="stylesheet" href="RetourAccueilW3.css" />
<?php include "BddInfoRecherche.php"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript">
	
//fonction qui verifie si tu es connecté ou si tu as un abonnement si NON te renvoie dans l'accueil		
function choseAFaireAuChargementDeLaPage(connection, niv){
	if ((connection==0) || (niv==0)){
			alert("vous n'avez rien à faire ici :/");
			window.location.href="AccueilW3.php";
		}
	
}

</script>
</head>


<body id="DeconnexionW3" style="background-color: #FFC7C7;" onload="choseAFaireAuChargementDeLaPage(<?php echo VerifCo();?>,<?php if (!isset($_POST['niv']) ){ echo "0";} else {echo "1";}?> );" >

<!-- En-tête du site -->
<div class="header">
  <h1>A<span id="Love"><i>LOVE</i></span>GIE</i></h1>
  <p style="font-size:20px;"><b>Fini les allergies, rencontrez enfin l'amour de votre vie !</b></p>
</div>


<!-- Onglets -->
<div class="navbar">
  <a id="BoutonRemark" href="AccueilW3.php" class="right"><b>ACCUEIL</b></a>
</div>


<!-- Zone de retour à l'accueil -->
 <table id="Abonne" style="border: 1px solid #E6362E; margin: 0; position: absolute; left: 39%; top: 47%; width: 380px; height: 300px; background-color : white;">
		<thead>
              <tr>
                <th>
	</br>
	<?php
	
	if ( $_POST['niv']=='Résilier mon abonnement' ){
		$_SESSION["abonne"]=ModifierProfil($_SESSION["pseudo"],"Abonnement",0);
		
		echo "	<span  style='color: #E6362E;'>Votre abonnement a bien été résilié.</span></br> </br>
				Pour retourner sur l'accueil cliquer <a href='AccueilW3.php' style='color: #E6362E;' > ici </a> ";	
	} else {
	
	
	echo"	<span  style='color: #E6362E;'>Votre abonnement a bien été pris en compte.</span></br> </br>
			Pour retourner sur l'accueil cliquer <a href='AccueilW3.php' style='color: #E6362E;' > ici </a> ";
		
	
		if ($_POST['niv']== 'Niveau1'){
			$_SESSION["abonne"]=ModifierProfil($_SESSION["pseudo"],"Abonnement",1);
			$dateAbo=date('Y-m-d');
            ModifierProfil($_SESSION["pseudo"],"DateAbonnement",$dateAbo);
		}
		if ($_POST['niv']== 'Niveau2'){
			$_SESSION["abonne"]=ModifierProfil($_SESSION["pseudo"],"Abonnement",2);
			$dateAbo=date('Y-m-d');
            ModifierProfil($_SESSION["pseudo"],"DateAbonnement",$dateAbo);
		}	
	
	}
	?>
		</br>
		<center><img src="logo.jpg" alt="Logo" style="width:35%;"></center>

			  </th>  
              </tr>
            </thead>
	</table>
	

<!-- Pied de page -->   
<div class="footer">
  <p><i>ALOVEGIE</i>, create by CHEVRIER Chleo, GONTIE Margaux, JANELA CAMEIJO Alice, MARTIN Teo, CPI2 Groupe 5</p>
</div>        

</body>
</html>

