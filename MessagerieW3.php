<!DOCTYPE html>
<?php
session_start();
?>

<html lang="fr">
	
<head>
<title>MESSAGERIE</title>
<meta charset="UTF-8">
<link rel="icon" href="logo3.jpg" />
<link rel="stylesheet" href="MessagerieW3.css" />
<?php include "BddInfoRecherche.php"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript">
	
	/*fonction qui verifie le niveau d'abonnement et la connection et
	qui execute toutes les fonctions à faire au chargement de la page == la sécurité du site */	
	function choseAFaireAuChargementDeLaPage(connection, abonnement){
		if ( (connection==0)||(abonnement==0) ){
			alert("vous n'avez rien à faire ici :/");
			window.location.href="AccueilW3.php";
		}
		Signalement();
	}


	function Signalement(){
		Modal.style.display = 'block';
	}
	
	/* fonction qui est appeler dans la page messagerie et qui nous ramenne dans la page ProfilAutreUtilisateurW3 */
	function enregistrerPseudoDansFichierM() {
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


<body id="BodyMessagerieW3" onload="choseAFaireAuChargementDeLaPage(<?php echo VerifCo();?>,<?php echo VerifAbo();?>);">


<!-- En-tête du site -->
<div class="header">
  <h1>A<span id="Love"><i>LOVE</i></span>GIE</i></h1>
  <p style="font-size:20px;"><b>Fini les allergies, rencontrez enfin l'amour de votre vie !</b></p>
</div>


<!-- Onglets -->
<div id='listeOnglet' class="navbar">
  <a href="AbonnementW3.php" class="right"><b>Abonnement</b></a>
  <a href="RechercheW3.php" class="right"><b>Autres Profils</b></a>
  <a href="MonProfilW3.php" class="right"><b>Mon Profil</b></a>
  <a href="DeconnexionW3.php" class="right"><b>Deconnexion</b></a>
  <a id="BoutonRemark" href="AccueilW3.php" class="right"><b>ACCUEIL</b></a>
</div>


<!-- Zone des messages -->
<div class="container">
  <div style="text-align:center">
    <h2 style="color : #E6362E;">Messagerie</h2>
  </div>
<br/><br/>
	<?php 
	if(isset($_POST["motif"])){?>
		<div id="Modal" class="modal">
		<div class='modal-content'>
		<span class="close" onclick="Modal.style.display = 'none';">&times;</span>
	<?php	echo "<p id='NivActu'><br/> Signalement effectué ! Un administrateur va bientôt vous contacter <br/><br/></p>";
		//affiche bloc
		Signaler($_SESSION["pseudo"],$_POST["nom"],$_POST["motif"]);
	
	?>
	</div></div>
<?php } ?>
	
	
  <div class="row">
	<div class="column">
		
		<?php
		// vérification du Post pseudo si la page à été appelée en AJAX 
		if( isset($_POST['autre']) ){ $autrePseudo = $_POST['autre']; }
		if (isset($_POST['Pseudo']) ) {
			$TabConv = TrouveNbConversations($_SESSION["pseudo"]);
			for($i=0;$i<sizeof($TabConv);$i++){
				if ( $_POST['Pseudo']==$TabConv[$i] ){
					$autrePseudo=$_POST['Pseudo'];
					break; 
				}
			}
			//vérifie si les deux personnes peuvent ouvrir une nouvelle discussion
			if( !isset($autrePseudo) ){
				if((ChercheBDD("Admin",$_SESSION["pseudo"])==1)||(ChercheBDD("Admin",$_POST['Pseudo'])==1)){ // L'administrateur a un nombre illimité de conversations
					$autrePseudo=$_POST['Pseudo'];
				}else{				
				$TabConv2 = TrouveNbConversations($_POST['Pseudo']);
				if ( (( VerifAbo()==1) && (sizeof($TabConv)<1)) || (( VerifAbo()==2) && (sizeof($TabConv)<5)) ) { //mon profil si abo = 1 et - de 1 conv => OK  OU si abo = 2 et - de 5 conv => OK
					if ( (( VerifAboPAU($_POST['Pseudo'])==1) && (sizeof($TabConv2)<1)) || (( VerifAboPAU($_POST['Pseudo'])==2) && (sizeof($TabConv2)<5)) ) {//autre profil si abo = 1 et - de 1 conv => OK  OU si abo = 2 et - de 5 conv => OK
						$autrePseudo=$_POST['Pseudo'];
					} else { ?> <script>alert('L autre utilisateur ne peut pas avoirt plus de conversation :(');</script> <?php }
					
				} else { ?> <script>alert('Vous ne pouvez pas avoir plus de conversation :( Mais vous pouvez toujours en supprimer !');</script> <?php }
				}
			}
					
			//}
				
			$TabBloc = TrouveBloquesPar($_SESSION["pseudo"]); 		//si le profil est bloqué par moi 
			if(isset($TabBloc)){
			for($i=0;$i<sizeof($TabBloc);$i++){
				if ( $_POST['Pseudo']==$TabBloc[$i] ){
					unset($autrePseudo);			//on n'autorise pas la discussion
					?> <script>alert('Vous avez bloqué ce profil :(');</script> <?php
					break; 
				}
			}
			}
			$TabBloc2 = TrouveBloquesPar($_POST['Pseudo']); 		//si le profil m'a bloqué 
			if(isset($TabBloc2)){
			for($i=0;$i<sizeof($TabBloc2);$i++){
				if ( $_SESSION["pseudo"]==$TabBloc2[$i] ){
					unset($autrePseudo);		//on n'autorise pas la discussion
					?> <script>alert('Cet utilisateur vous a bloqué :(');</script> <?php
					break; 
				}
			}
			}
			if((isset($autrePseudo))&&($autrePseudo==$_SESSION["pseudo"])){        //pour ne pas discuter avec soi-même
                unset($autrePseudo);
                ?> <script>alert('Vous ne pouvez pas discuter avec vous-même :(');</script> <?php
            }

		}		
		
		
		if(isset($_POST["formSup"])){
			SupprimerMessage($_POST["sup"],$_SESSION["pseudo"]);
		}
		if(isset($_POST["formRecup"])){
			$autrePseudo = $_POST["recupPseudo"];
		}
			if(isset($_POST["message"])&&($_POST["message"]!="")){
				date_default_timezone_set('Europe/Paris');
				$heure = date('H:i:s');
				NouveauMessage($_SESSION["pseudo"],$autrePseudo, $_POST["message"],$heure);	
			}
				
		// tableau des profils avec qui utilisateur a une conversation	
		$TabConv = TrouveNbConversations($_SESSION["pseudo"]);
		if((sizeof($TabConv)==0)&&(!isset($autrePseudo))){
		echo "<b>Vous n'avez pas encore de discussion</b> <br/><br/> <b>Consultez les autres profils : <a href='RechercheW3.php' style='color: gold;'>ici</a></b><br/><br/><div class='chip'><img src='Enveloppe.png' alt='Person'> 
</div> ";
		}
		echo "<br/>";
		//affichage de la liste des profils avec qui l'utilisateur communique
		for($i=0;$i<sizeof($TabConv);$i++){
		//Affichage de la photo, du pseudo, du dernier message et du bouton supprimer ?>
		<img id="photo" height="70" style="border : 1px solid;" src="<?php echo ChercheBDD("Photo1",$TabConv[$i]);?>"/>
<?php
		echo "<form method='POST' action='MessagerieW3.php'><input type='hidden' name='recupPseudo' value='$TabConv[$i]' /><input type='submit' name='formRecup' style='background-color:#9AD9FA;' value='$TabConv[$i]' /> </form><br/>";
		
		$TabResult = TrouveDernierMessage($TabConv[$i],$_SESSION["pseudo"]);
		echo " Dernier message : ".$TabResult[0];
		echo " ".$TabResult[1]."<br/>";
		
		echo "<form method='POST' action='MessagerieW3.php'><input type='hidden' name='sup' value='$TabConv[$i]' /><input type='submit' name='formSup' style='background-color:#9AD9FA;' value='Supprimer cette conversation' /> </form><br/>";
		}
       ?>
     </div>
   
    <div class="column">
        <?php 
        //Affichage de la conversation
		if ( isset($autrePseudo) ){
			echo "<center>";
			?>
			<img id="photo" height="70" style="border : 1px solid;" src="<?php echo ChercheBDD("Photo1",$autrePseudo);?>"/> 
			<?php
			echo "<br/><input id='autrePseudo' style='background-color:#9AD9FA;' type='button' value =".$autrePseudo." onclick='enregistrerPseudoDansFichierM()' /> "; 
			TrouveAfficheMessages($autrePseudo,$_SESSION["pseudo"]);	//Affiche toute la conv entre toto et Croquette
			echo "</center>";

			/////////////////////////////////////////////////////////////////////////////////
			echo'<form method="POST" action="MessagerieW3.php">';
			echo "<textarea  type='text' size='40' id='message' name='message' rows='10' cols='50' placeholder='Entrez votre message'></textarea>";
			echo "<input type='hidden' value='$autrePseudo' name='autre' ";
			echo "<br/><center> <input type='submit' style='background-color:#E6263E;' value='Envoyer'/> </center>";
		}	
		
		?></form>
    </div>
    <!-- Formulaire pour signaler un profil -->
    <div class="column"> <p><b>Signaler un profil ici :</b></p> 
		<div id="BlocSignal">
		<form action="MessagerieW3.php" method="POST"> <input type="text" name="nom" placeholder="Entrez un pseudo à signaler" required/> <br/> <input type="text" name="motif" size="80" placeholder="Entrez un motif de signalement : propos injurieux, harcelement ...." required/> <br/> <input type="submit" style="background-color:#9AD9FA;" value="Valider"/> </form>
		</div>
    
    
    </div>
    
    
    
  </div>
  
</div>

</body>
</html>
