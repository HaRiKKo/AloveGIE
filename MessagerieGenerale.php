<!DOCTYPE html>
<?php
session_start();
?>

<html lang="fr">
	
<head>
<title>MESSAGERIE GENERALE</title>
<meta charset="UTF-8">
<link rel="icon" href="logo3.jpg" />
<link rel="stylesheet" href="MessagerieGenerale.css" />
<?php include "BddInfoRecherche.php"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript">
	
	//fonction qui verifie si tu es un administrateur si NON te renvoie dans l'accueil	
	function choseAFaireAuChargementDeLaPageMG(administration){
		if (administration==0){
			alert("vous n'avez rien à faire ici :/");
			window.location.href="AccueilW3.php";
		}	
	}
	
	/* fonction qui est appeler dans la page messagerie et qui nous ramenne dans la page ProfilAutreUtilisateurW3 */
	function enregistrerPseudoDansFichierMG() {
		var Elements=document.getElementById('autrePseudo');
		var Pseudo=Elements.value;
		var body=document.getElementById('BodyMessagerieW3');   
			
		var xhr= new XMLHttpRequest();
   
		xhr.onreadystatechange = function() {
			if (xhr.readyState==4 && xhr.status==200) { 
				body.innerHTML=xhr.responseText; 
				var scripts=body.getElementsByTagName("script"); 
				 
				for (var i=0; i<scripts.length; i++) { 
					eval(scripts[i].innerHTML); 
				} 
			}
  
		}
       
		xhr.open("POST", "ProfilAutreUtilisateurW3.php", true);
   
		xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
   
		xhr.send("Pseudo="+Pseudo);
	}	
</script>
</head>


<body id="BodyMessagerieW3" onload="choseAFaireAuChargementDeLaPageMG(<?php if ( isset($_POST['Pseudo']) ){ echo ChercheBDD("Admin", $_SESSION['pseudo']); } else {echo "0";} ?>);">


<!-- En-tête du site -->
<div class="header">
  <h1>A<span id="Love"><i>LOVE</i></span>GIE</i></h1>
  <p style="font-size:20px;"><b>Fini les allergies, rencontrez enfin l'amour de votre vie !</b></p>
</div>


<!-- Onglets -->
<div id='listeOnglet' class="navbar">
  <a href="MonProfilW3.php" class="right"><b>Mon Profil</b></a>
  <a href="AbonnementW3.php" class="right"><b>Abonnement</b></a>
  <a href="RechercheW3.php" class="right"><b>Autres Profils</b></a>
  <a href="DeconnexionW3.php" class="right"><b>Deconnexion</b></a>
  <a href="MessagerieW3.php" class="right"><b>Messagerie</b></a>
  <a id="BoutonRemark" href="AccueilW3.php" class="right"><b>ACCUEIL</b></a>
</div>


<?php  $utilisateur = $_POST['Pseudo']; ?>

<!-- Zone des messages vue par l'administrateur-->
<div class="container">
  <div style="text-align:center">
    <h2 style="color : #E6362E;">MESSAGERIE DE <?php echo $utilisateur; ?> </h2>
  </div>
<br/><br/>

  <div class="row">  
	<div class="column">
		<?php		
		if(isset($_POST["formSup"])){	//si l'utilisateur a appuyer sur le bouton "supprimer"
			SupprimerMessage($_POST["sup"],$utilisateur);
		}
		if(isset($_POST["formRecup"])){	// si l'utilisateur a appuyer sur le pseudo d'un autre utilisateur
			$autrePseudo = $_POST["recupPseudo"];
		}
		// tableau des profils avec qui l'utilisateur a une conversation	
		$TabConv = TrouveNbConversations($utilisateur);
		if((sizeof($TabConv)==0)&&(!isset($autrePseudo))){
		echo "<b>Cet utilisateur n'a aucune conversation en cours. </b><br/><br/><div class='chip'><img src='Enveloppe.png' alt='Person'></div> ";
		}
		echo "<br/>";
		//affichage de la liste des profils avec qui l'utilisateur communique
		for($i=0;$i<sizeof($TabConv);$i++){
		//Affichage de la photo, du pseudo, du dernier message et du bouton supprimer ?>
		<img id="photo" height="70" style="border : 1px solid;" src="<?php echo ChercheBDD("Photo1",$TabConv[$i]);?>"/>
<?php
		echo "<form method='POST' action='MessagerieGenerale.php'><input type='hidden' name='recupPseudo' value='$TabConv[$i]' /><input type='hidden' name='Pseudo' value='$utilisateur'/><input type='submit' name='formRecup' style='background-color:#9AD9FA;' value='$TabConv[$i]' /> </form><br/>";
		
		
		$TabResult = TrouveDernierMessage($TabConv[$i],$_SESSION["pseudo"]);
        echo " Dernier message : ".$TabResult[0];
        echo " ".$TabResult[1]."<br/>";
		
		echo "<form method='POST' action='MessagerieGenerale.php'><input type='hidden' name='sup' value='$TabConv[$i]' /><input type='hidden' name='Pseudo' value='$utilisateur'/><input type='submit' name='formSup' style='background-color:#9AD9FA;' value='Supprimer cette conversation' /> </form><br/>";
		}
       ?>
     </div>
   
    <div class="column">
        <?php 
		//Affichage de la conversation
		if ( isset($autrePseudo) ){
			?>
			<img id="photo" height="70" style="border : 1px solid;" src="<?php echo ChercheBDD("Photo1",$autrePseudo);?>"/> 
			<?php echo "<br/><input id='autrePseudo' style='background-color:#9AD9FA;' type='button' value =".$autrePseudo." onclick='enregistrerPseudoDansFichierMG()' /> "; 
			TrouveAfficheMessages($autrePseudo,$utilisateur);
		}	
		
		?>
    </div>
  </div>
  </form>
  <br/><br/>
</div>


<!-- Pieds de page -->   
<div style="background-color:#E6263E;" class="footer">
  <p><i>ALOVEGIE</i>, create by CHEVRIER Chleo, GONTIE Margaux, JANELA CAMEIJO Alice, MARTIN Teo, CPI2 Groupe 5</p>
</div> 

</body>
</html>
