<!DOCTYPE html>
<?php
session_start();
?>
<html lang="fr">
<head>
<title>MON PROFIL</title>
<meta charset="UTF-8">
<link rel="icon" href="logo3.jpg" />
<link rel="stylesheet" href="MonProfilW3.css" />
<?php include "BddInfoRecherche.php"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script type="text/javascript" >
		
	//Change la couleur des carrés et la photo de profil 		
	function ChangementPhotoCarre(img,couleurUn,couleurDeux,couleurTrois){ //Le carré de droite = photo 3 (logo) 
		var photo = document.getElementById("PhoProf");
		var CarreUn = document.getElementById("Un");
		var CarreDeux = document.getElementById("Deux");
		var CarreTrois = document.getElementById("Trois");
		photo.src = img;
		
		CarreUn.bgColor = couleurUn;
		CarreDeux.bgColor = couleurDeux;
		CarreTrois.bgColor = couleurTrois;
	}	
	
	
	//si l'utilisateur n'a pas mis toutes les photos alors il va mettre automatiquement le logo du site sur les photos manquantes 
	function photoUtilisateur(nbPhoto){

		switch (nbPhoto){
			case 1 :
				var Trois = document.getElementById("Trois");
				Trois.setAttribute("onclick","ChangementPhotoCarre('logo.png','#FF69B4','#FF69B4','#FFFFFF')"); 
			case 2 : 
				var Un = document.getElementById("Un");
				Un.setAttribute("onclick","ChangementPhotoCarre('logo.png','#FFFFFF','#FF69B4','#FF69B4')"); break;
			
			default : alert("default");
		}
	
	}
	
	
	//fonction qui ajoute les onglets en fonction de la connection et de l'abonnement  
	function Onglet (connection, abonnement){
		
		var liste = document.getElementById('listeOnglet');
		if (connection==1){
			switch (abonnement){
				
				case 1 :
				case 2 :
					
					var newlien=document.createElement('a');
					newlien.setAttribute("href","MessagerieW3.php");
					newlien.setAttribute("class","right");
					newlien.innerHTML= "<b>Messagerie</b>";
					
					liste.appendChild(newlien);
				
				break;
				
				default : //alert("pas d'abonnement");

			}
		}
		
	}
	
	
	function Profil_Recomandation(connection){
		alert('debut '+connection);
		var profil=getElementById();
		profil.remove();	
	}
	
	//fonction qui supprimer les allergies si tu n'en a pas trois 
	function Allergie(nbAllergie){
		var allergie = document.getElementsByClassName('allergie');
		switch (nbAllergie) {
			case 1 : allergie[2].remove(); allergie[1].remove();
			break;
			case 2 : allergie[2].remove();
			break;	
		}
	}
	
	//affiche le pop-up 
	function Supprime(){
		Modal2.style.display = 'block';
	}
	
	/*fonction qui verifie le niveau d'abonnement et la connection et
	qui execute toutes les fonctions à faire au chargement de la page */	
	function choseAFaireAuChargementDeLaPage (connection, abonnement, nbAllergie,administration){
		if (connection==0){
			alert("vous n'avez rien à faire ici :/");
			window.location.href="AccueilW3.php";
		}
		if(administration!=1){document.getElementById('pageAdmin').remove();}
		Onglet(connection, abonnement);
		Allergie(nbAllergie);
		Supprime();
	}
	
	</script>
</head>


<body id="BodyMonProfilW3"  onload="choseAFaireAuChargementDeLaPage(<?php echo VerifCo();?>,<?php echo VerifAbo();?>,<?php echo CalculNbAllergies();?>,<?php echo ChercheBDD("Admin", $_SESSION["pseudo"]); ?>)">


<!-- En-tête du site -->
<div class="header">
  <h1>A<span id="Love"><i>LOVE</i></span>GIE</i></h1>
  <p style="font-size:20px;"><b>Fini les allergies, rencontrez enfin l'amour de votre vie !</b></p>
</div>


<!-- Onglets -->
<div id='listeOnglet' class="navbar">
  <a href="AbonnementW3.php" class="right"><b>Abonnement</b></a>
  <a href="RechercheW3.php" class="right"><b>Autres Profils</b></a>
  <a href="DeconnexionW3.php" class="right"><b>Deconnexion</b></a>
  <a id="BoutonRemark" href="AccueilW3.php" class="right"><b>ACCUEIL</b></a>
</div>


<!-- Mon Profil  -->
<div class="side">
    <h2>MON PROFIL</h2>
</div>


<!-- Boutons liées au Profil  -->
<div class="side">
<div class="chip">
  <img src="ParamProfil.png" alt="Person" width="106" height="106"> <!-- Bouton d'accès à la page ModifierMonProfilW3.php -->
  <a href="ModifierMonProfilW3.php"><b style="color:#333;">Modifier mon profil</b></a>
</div>
<div id="pageAdmin" class="chip">
  <img src="Admin.jpg" alt="Person" width="57" height="57"> <!-- Bouton d'accès à la page PageAdminW3.php -->
  <a href="PageAdminW3.php"><b style="color:#333;">Page administrateur</b></a>
</div>
<div class="chip">
  <img src="Suppr.png" alt="Person" width="106" height="106">
  <button id="boutonSuppr" onclick="Modal.style.display = 'block';"><b style="color:#333;">Supprimer mon profil</b></button> <!-- Bouton permettant de supprimer son profil du site (et de la base d edonnées principale) -->
</div>
</div>

<div class="side">
<?php if(isset($_POST["confirm"])){	?>
	
<!-- pop up de suppression  -->	
<div id="Modal2" class="modal" >
	<?php if($_POST["confirmMDP"]==ChercheBDD("MotDePasse",$_SESSION["pseudo"])){	// vérifie si bon mot de passe
		echo "<div class='modal-content'>";
		    SupprimerSignalement($_SESSION["pseudo"]);
		    SupprimerBlocage($_SESSION["pseudo"]);
		    SupprimerLike($_SESSION["pseudo"]);
		    SupprimerSuperLike($_SESSION["pseudo"]);
		    $TabConv = TrouveNbConversations($_SESSION["pseudo"]);
			for($i=0;$i<sizeof($TabConv);$i++){
				SupprimerMessage($_SESSION["pseudo"], $TabConv[$i]);
			}
			ModifierProfil($_SESSION["pseudo"],"co",0);
			session_destroy();	
			SupprimerProfil($_SESSION["pseudo"]);
    echo "<p id='NivActu'><br/> Votre compte a bien été supprimé. <br/> Nous espérons vous revoir très vite sur <a href='AccueilW3.php'><b><span style='color:#333;'>A<span id='Love'><i>LOVE</i></span>GIE</span></b></a> !<br/></p><br/>";
	echo "</div>";
	}else{	echo "<div class='modal-content'>";?>
		<span class="close" onclick="Modal2.style.display = 'none';">&times;</span>
	<?php	echo "<div id='NivActu2'><p>Mot de passe incorrect, nous ne pouvons pas autoriser la suppression</p><p style='color:red;'><b>L'opération a été annulée</b></p></div>";
	echo "</div>";
	}
}?>
</div>

<div id="Modal" class="modal">
  <div class="modal-content">
	<div id="NivActu">
    <span class="close" onclick="Modal.style.display = 'none';">&times;</span>
    <p>Pour confirmer la suppression de votre compte veuillez entrer votre <span style="color:red;"><b>mot de passe :</b></span></p><br/>
	<?php	echo "<form action='MonProfilW3.php' method='POST'><input type='password' name='confirmMDP' /><input type='submit' name='confirm' value='Confirmer la suppression'/> </form> "; ?>
	<br/>
	</div>
  </div>
</div>


<!-- Carte du Profil  -->
<div class="card2">
<table id="Profil"  style=" width: 85%; height: 450px; margin-left: 47px; background-color : #f1f1f1;">
            <thead>
              <tr>
			    <th>
					<b><br/><div href="MonProfilW3.php" id="Pseudonyme"> <?php echo $_SESSION["pseudo"]; ?>  </div></b> <br/><br/>	
					 <img id="PhoProf" height="220" style="border : 2px solid;" src="<?php echo $_SESSION['photo1'];  ?>"/><br/><br/> 
				 <?php  $p1 = $_SESSION['photo1'];
						$p2 = $_SESSION['photo2'];
						$p3 = $_SESSION['photo3'];
					?> 
					 <table class="carreau"  id="Un" border="1px;" style="width:13px; height:13px; top:650px; left:410px;" bgcolor="#FFFFFF" onclick="ChangementPhotoCarre('<?php echo $p2; ?>','#E6362E','#FFFFFF','#FFFFFF');"> </table><table class="carreau" id="Deux" border="1px;" style="width:13px; height:13px; top:650px; left:430px;" bgcolor="#E6362E" onclick="ChangementPhotoCarre('<?php echo $p1; ?>','#FFFFFF','#E6362E','#FFFFFF');"> </table><table class="carreau" id="Trois" border="1px;" style="width:13px; height:13px; top:650px; left:450px;" bgcolor="#FFFFFF" onclick="ChangementPhotoCarre('<?php echo $p3; ?>','#FFFFFF','#FFFFFF','#E6362E');"> </table>
            		 <b> <?php echo CalculAge($_SESSION["DateNaissance"]); ?> ans, <?php AfficheDepartement($_SESSION["lieu"]); ?> </b><br/><br/>
					Description : <center><div class="Cadre"><?php echo $_SESSION["description"]; ?> <br/> </div></center></br>
			    </th> 
			    <th>
					<b> SEXE :  <?php AfficheSexe($_SESSION["sexe"]); ?> <br/>
					    ORIENTATION : <?php AfficheOrientation($_SESSION["orientation"]); ?><br/><br/><br/>
						ALLERGIE(S) : <?php CalculNbAllergies($_SESSION["allergie"][1],$_SESSION["allergie"][2]);?> 
						<br/><br/>
									  <div class='allergie' style="color : #E6362E;"> <?php AfficheAllergie($_SESSION["allergie"][0]); ?>  <?php $valeur=$_SESSION["NivAllergie"][0]; echo"<input type='range' min='0' max='5' value='$valeur' style='color : gold;'>"; ?> </div><br/>
									  <div class='allergie' style="color : #E6362E;"> <?php AfficheAllergie($_SESSION["allergie"][1]); ?>  <?php $valeur=$_SESSION["NivAllergie"][1]; echo"<input type='range' min='0' max='5' value='$valeur' style='color : gold;'>"; ?> </div><br/>
									  <div class='allergie' style="color : #E6362E;"> <?php AfficheAllergie($_SESSION["allergie"][2]); ?>  <?php $valeur=$_SESSION["NivAllergie"][2]; echo"<input type='range' min='0' max='5' value='$valeur' style='color : gold;'>"; ?> </div><br/>					
					</b>
			    </th> 
			    <th>
					Qualités et défauts : <center><div class="Cadre"><?php echo $_SESSION["defauts"]; ?><br/></div></center><br/>
					Passions : <center><div class="Cadre"><?php echo $_SESSION["passions"]; ?> <br/> </div></center><br/>
					Phobies : <center><div class="Cadre"> <?php echo $_SESSION["phobies"]; ?><br/> </div></center><br/>
					Pire date : <center><div class="Cadre"> <?php echo $_SESSION["piredate"]; ?><br/> </div></center><br/>
			    </th> 
              </tr>
            </thead>
          </table>
          
          
         <!--  Affiche les personnes qui ont liker mon profil -->
          <?php $Result = TrouveSuperLike($_SESSION["pseudo"]);
			if(isset($Result)){
			echo "<div id='NivActu2' style='color:red; font-size:19px; background-color:#B0E2FD;'><center><b>";
			echo "<br/>J'ai reçu un superlike de  : "; 
				for($i=0;$i<sizeof($Result);$i++){
					echo $Result[$i].", ";
				}
			echo"<br/><br/>";	
			echo "</b></center></div>";
			}
			 // Affiche les personnes qui ont Superliker mon profil 
			$Result2 = TrouveLike($_SESSION["pseudo"]); 
			if(isset($Result2)){
				echo "<div id='NivActu2' style='color:#E6362E;'><center><b>";
			echo "<br/>J'ai reçu un like de  : "; 
				for($i=0;$i<sizeof($Result2);$i++){
					echo $Result2[$i].", ";
				}
			echo"<br/><br/>";
			echo "</b></center></div>";	
			}
			
          ?>          
</div>


<div class="side">
    <h2><span style="color: #f1f1f1;">A<br/></span></h2>
</div>
</div>

<div class="modal">
<div class="modal-content animate">laaaaaaaaaaaaaaaa</div>
</div>
     

<!-- Pieds de page -->   
<div class="footer">
  <p><i>ALOVEGIE</i>, create by CHEVRIER Chleo, GONTIE Margaux, JANELA CAMEIJO Alice, MARTIN Teo, CPI2 Groupe 5</p>
</div>        

</body>
</html>








