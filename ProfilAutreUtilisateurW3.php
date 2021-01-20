<!DOCTYPE html>
<?php
session_start();
?>
<html lang="fr">
<head>
<title>AUTRE PROFIL</title>
<meta charset="UTF-8">
<link rel="icon" href="logo3.jpg" />
<link rel="stylesheet" href="ProfilAutreUtilisateurW3.css" />
<?php include "BddInfoRecherche.php"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>

    //Change la couleur des carrés et la photo de profil 		
	function ChangementPhotoCarrePAU(img,couleurUn,couleurDeux,couleurTrois){ //Le carré de droite = photo 3 (logo) 
		var photo = document.getElementById("PhoProfPAU");
		var CarreUn = document.getElementById("UnPAU");
		var CarreDeux = document.getElementById("DeuxPAU");
		var CarreTrois = document.getElementById("TroisPAU");
		photo.src = img;
		
		CarreUn.bgColor = couleurUn;
		CarreDeux.bgColor = couleurDeux;
		CarreTrois.bgColor = couleurTrois;
	}
		
		
	//si l'utilisateur n'a pas mis toutes les photos alors il va mettre automatiquement le logo du site sur les photos manquantes 
	function photoUtilisateurPAU(nbPhoto){

		switch (nbPhoto){
			case 1 :
				var Trois = document.getElementById("TroisPAU");
				Trois.setAttribute("onclick","ChangementPhotoCarrePAU('logo.png','#FF69B4','#FF69B4','#FFFFFF')"); 
			case 2 : 
				var Un = document.getElementById("UnPAU");
				Un.setAttribute("onclick","ChangementPhotoCarrePAU('logo.png','#FFFFFF','#FF69B4','#FF69B4')"); break;
			
			default : alert("default");
		}
	
	}
	
	//fonction qui ajoute les onglets en fonction de la connection et de l'abonnement dans la page ProfilAutreUtilisateur
	function OngletPAU (connection, abonnement){
		var liste = document.getElementById('listeOngletPAU');
		
		if (connection==1){
			switch (abonnement){
				
				case 1 :
				case 2 :
					var newlien4=document.createElement('a');
					newlien4.setAttribute("href","MessagerieW3.php");
					newlien4.setAttribute("class","right");
					
					newlien4.innerHTML= "<b> Messagerie </b>";
							
					liste.appendChild(newlien4);
					
				case 0 :
					var newlien1=document.createElement('a');
					var newlien2=document.createElement('a');
					
					newlien1.setAttribute("href","DeconnexionW3.php");
					newlien2.setAttribute("href","MonProfilW3.php");
					
					newlien1.setAttribute("class","right");
					newlien2.setAttribute("class","right");
					
					newlien1.innerHTML = "<b> Deconnexion </b>";
					newlien2.innerHTML = "<b> Mon Profil </b>";
					
					liste.appendChild(newlien1);
					liste.appendChild(newlien2);
			
				break;
				
				default : alert("Erreur de niveau d'abonement");

			}
		} else {     
			var newlien1=document.createElement('a');
			var newlien2=document.createElement('button');
			
			newlien1.setAttribute("href","InscriptionW3.php");
			newlien2.setAttribute("onclick","document.getElementById('id01').style.display='block'");
			
			newlien1.setAttribute("class","right");
			newlien1.setAttribute("id","BoutonRemarkPAU");
			newlien2.setAttribute("id","BoutonConnexion");
			
			newlien1.innerHTML = "<b> Inscription </b>";
			newlien2.innerHTML = "<b> Connexion </b>";
			
			liste.appendChild(newlien2);
			liste.appendChild(newlien1);
	
		}
	}
	
	//fonction qui supprime les allergies si tu n'en as pas trois dans la page ProfilAutreUtilisateur
	function AllergiePAU(nbAllergie){
		var allergie = document.getElementsByClassName('allergiePAU');
		switch (nbAllergie) {
			case 1 : allergie[2].remove(); allergie[1].remove();
			break;
			case 2 : allergie[2].remove();
			break;		
		}
	}
	
	
	function Profil_RecomandationPAU(connection){
		var profil=getElementById();
		profil.remove();	
	}
	
	/*fonction qui vérifie le niveau d'abonnement et la connection et
	qui execute toutes les fonctions à faire au chargement de la page */
	function choseAFaireAuChargementDeLaPagePAU(connection, abonnement, nbAllergie, aboAutre, administration,adminPAU){
		AllergiePAU(nbAllergie);
		OngletPAU(connection, abonnement);
		if (connection==0){
			alert("vous n'avez rien à faire ici :/");
			window.location.href="AccueilW3.php";
		}
		if (administration==0) { document.getElementById('infoPerso').remove(); }
		if (adminPAU==1) { document.getElementById('Blocage').remove(); }
		if (abonnement==1) { document.getElementById('SuperLike').remove(); }
		if (abonnement==2) { document.getElementById('Like').remove(); }
		if (abonnement==0) { document.getElementById('Like').remove(); document.getElementById('SuperLike').remove();}
		if ( (abonnement==0) || (aboAutre==0) ){ document.getElementById('messagePAU').remove(); }
	}
	
	/* Fonction qui récupère le pseudo de la personne qui nous interesse 
	et qui va ouvrir la page massagerieW3.php dans la page ProfilAutreUtilisateur*/
	function VersMessageriePAU(Pseudo){
		
		var body=document.getElementById('BodyProfilAUtreUtilisateurW3');   
        var xhr= new XMLHttpRequest();
   
        xhr.onreadystatechange = function() {
             if (xhr.readyState==4 && xhr.status==200) { 
				 body.innerHTML=xhr.responseText; 
				 var scripts=body.getElementsByTagName("script"); //recupère le script si il y en a.
				 
				 for (var i=0; i<scripts.length; i++) { 
					 eval(scripts[i].innerHTML); 
				} 
			}
  
        }
       
        xhr.open("POST", "MessagerieW3.php", true);
   
        xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
   
        xhr.send("Pseudo="+Pseudo); 
    }
</script>
</head>

<body id="BodyProfilAUtreUtilisateurW3" style="background-color: f1f1f1;" onload='choseAFaireAuChargementDeLaPagePAU(<?php if(isset($_POST["Pseudo"])){ echo VerifCo();}else{echo "0";}?>, <?php if(isset($_POST["Pseudo"])){ echo VerifAbo();}else{echo "0";}?>, <?php if(isset($_POST["Pseudo"])){ echo CalculNbAllergiesPAU($_POST['Pseudo']);}else{echo "0";}?>, <?php if(isset($_POST["Pseudo"])){ echo VerifAboPAU($_POST["Pseudo"]);}else{echo "0";}?>, <?php if(isset($_POST["Pseudo"])){ echo ChercheBDD("Admin", $_SESSION['pseudo']);}else{echo "0";}?>,<?php if(isset($_POST["Pseudo"])){ echo ChercheBDD("Admin", $_POST["Pseudo"]);}else{echo "0";} ?>);'>	


<!-- En-tête du site -->
<div class="headerPAU">
  <h1>A<span id="LovePAU"><i>LOVE</i></span>GIE</i></h1>
  <p style="font-size:20px;"><b>Fini les allergies, rencontrez enfin l'amour de votre vie !</b></p>
</div>


<!-- Onglets -->
<div id='listeOngletPAU' class="navbarPAU">
  <a href="AbonnementW3.php" class="right"><b>Abonnement</b></a>
  <a href="RechercheW3.php" class="right"><b>Autres Profils</b></a>
  <a id="BoutonRemarkPAU" href="AccueilW3.php" class="right"><b>ACCUEIL</b></a>
</div>


<!-- Autre Profil  -->
<div class="sidePAU">
    <h2>PROFIL de <?php  echo  $_POST["Pseudo"];  ?></h2>
</div>

<!-- Appel des fonctions php en fonction des boutons activés par l'utilisateur -->
<?php
if(isset($_POST["like"])&&(VerifAbo()==1)){
	 Liker($_SESSION["pseudo"],$_POST["Pseudo"]);
 }else if(isset($_POST["like"])&&(VerifAbo()==2)){
	 SuperLiker($_SESSION["pseudo"],$_POST["Pseudo"]);
 }
 ?>
 
<!-- Bouton LIKE pour les abonnés de niveau 1-->
<div class="sidePAU">
<div id="Like" class="chipPAU">
  <img src="Coeur.png" alt="Person" width="106" height="106"> 
  <div><b>Envoyer un Like</b></div>
 <?php 
 $pseu = $_POST["Pseudo"];
 $aime =0;	//profil non liké par l'utilisateur
 $Tab = TrouveLike($_POST["Pseudo"]);		
	if(isset($Tab)){
		for($i=0;$i<sizeof($Tab);$i++){
			if ($_SESSION['pseudo']==$Tab[$i] ){
				$aime=1;	//j'aime déjà ce profil
				break; 
			}
		}
	} 
	//affichage du formulaire "LIKE"
 if($aime==0){
 echo '<form action="ProfilAutreUtilisateurW3.php" method="POST"><input type="hidden" name="Pseudo" value="'.$pseu.'" /><input type="submit" name="like" style="background-color:#9AD9FA;" value="LIKER"/> </form>	';
 }else{	echo"<h4><u> Vous avez mis un Like à ce profil </u></h4>";
}
?>
</div>

<!-- Bouton SUPERLIKE pour les abonnés de niveau 2-->
<div id="SuperLike" class="chipPAU">
  <img src="ventoline.png" alt="Person" width="106" height="106"> 
  <div><b>Envoyer un SuperLike</b></div> 
 <?php 
 $pseu = $_POST["Pseudo"];
 $aime =0;	//profil non superliké par moi
 $Tab = TrouveSuperLike($_POST["Pseudo"]);		
	if(isset($Tab)){
		for($i=0;$i<sizeof($Tab);$i++){
			if ($_SESSION['pseudo']==$Tab[$i] ){
				$aime=1;	//j'aime déjà ce profil
				break; 
			}
		}
	} 
	//affichage du formulaire de "Superlike"
 if($aime==0){
 echo '<form action="ProfilAutreUtilisateurW3.php" method="POST"><input type="hidden" name="Pseudo" value="'.$pseu.'" /><input type="submit" name="like" style="background-color:#9AD9FA;" value="SUPERLIKER"/> </form>	';
}else{	echo"<h4><u> Vous avez mis un SuperLike à ce profil </u></h4>";
}
 ?>
</div>

 <!-- Bouton de blocage du profil affiché-->
<div id="Blocage" class="chipPAU">
<img src="Suppr.png" alt="Person" width="106" height="106">
  <div><b>Bloquer cet utilisateur</b></div>
 <?php 
 if(isset($_POST["bloquer"])){
	 Bloquer($_SESSION["pseudo"],$_POST["Pseudo"]);
	 SupprimerMessage($_SESSION["pseudo"],$_POST["Pseudo"]);
 }
  if(isset($_POST["debloquer"])){
	 Debloquer($_SESSION["pseudo"],$_POST["Pseudo"]);
 }
 $pseu = $_POST["Pseudo"];
 $blok =0;	//profil non bloqué par moi
 $TabBloc = TrouveBloquesPar($_SESSION["pseudo"]); 
	if(isset($TabBloc)){
		for($i=0;$i<sizeof($TabBloc);$i++){
			if ($_POST['Pseudo']==$TabBloc[$i] ){
				$blok=1;	//profil bloqué par moi
				break; 
			}
		}
	}
if($blok==0){	//si je n'ai pas bloqué ce profil
 echo '<form action="ProfilAutreUtilisateurW3.php" method="POST"><input type="hidden" name="Pseudo" value="'.$pseu.'" /><input type="submit" name="bloquer" style="background-color:#9AD9FA;" value="BLOQUER"/> </form>	';
}else{ 		//si j'ai bloqué ce profil
echo '<form action="ProfilAutreUtilisateurW3.php" method="POST"><input type="hidden" name="Pseudo" value="'.$pseu.'" /><input type="submit" name="debloquer" style="background-color:#9AD9FA;" value="DEBLOQUER"/> </form>	';
}
 ?>
</div>

<!-- Bouton d'accès à la page MessagerieW3.php -->

<?php
if ((ChercheBDD("Abonnement", $_SESSION["pseudo"]) != 0) && ( ChercheBDD("Abonnement", $_POST["Pseudo"]) != 0 )){
?>
<div class="chipPAU">
  <img src="Enveloppe.png" alt="Person" width="116" height="116">
  <div><b>Envoyer un message</b></div>
  <input type='button' value="Envoyer un Message" onclick="VersMessageriePAU('<?php echo $_POST['Pseudo']; ?>');"/>
</div>
</div>
<?php
}
?>

<!-- Carte du profil -->
<div class="card2PAU">
<table id="ProfilPAU"  style=" width: 85%; height: 450px; margin-left: 47px; background-color : #f1f1f1;">
            <thead>
              <tr>
			    <th>
					<b><br/><div href="MonProfilW3.php" id="PseudonymePAU"> <?php echo $_POST["Pseudo"]; ?>  </div></b> <br/><br/>		
					<div id='infoPerso'> <!-- visible uniquement par les administrateurs-->
						Prénom : <?php echo ChercheBDD("Prenom",$_POST["Pseudo"]); ?> <br/>
						Nom : <?php echo ChercheBDD("Nom",$_POST["Pseudo"]); ?><br/>
						Adresse E-mail  : <?php echo ChercheBDD("Email",$_POST["Pseudo"]); ?><br/>
						Niveau d abonnement : <?php echo ChercheBDD("Abonnement",$_POST["Pseudo"]); ?>
						<br/>
					</div>
					<br/>
					
					 <img id="PhoProfPAU" height="220" style="border : 2px solid;" src="<?php echo ChercheBDD("Photo1",$_POST['Pseudo']);  ?>"/><br/><br/> 
				    <?php  
						$p1 = ChercheBDD("Photo1",$_POST['Pseudo']);
						$p2 = ChercheBDD("Photo2",$_POST['Pseudo']);
						$p3 = ChercheBDD("Photo3",$_POST['Pseudo']);
					?> 
					 <table class="carreau" id="UnPAU" border="1px;" bgcolor="#FFFFFF" style="width:13px; height:13px; top:650px; left:410px;" onclick="ChangementPhotoCarrePAU('<?php echo $p2; ?>','#E6362E','#FFFFFF','#FFFFFF');"> </table><table class="carreau" id="DeuxPAU" border="1px;" style="width:13px; height:13px; top:650px; left:430px;" bgcolor="#E6362E" onclick="ChangementPhotoCarrePAU('<?php echo $p1; ?>','#FFFFFF','#E6362E','#FFFFFF');"> </table><table class="carreau" id="TroisPAU" border="1px;" style="width:13px; height:13px; top:650px; left:450px;" bgcolor="#FFFFFF" onclick="ChangementPhotoCarrePAU('<?php echo $p3; ?>','#FFFFFF','#FFFFFF','#E6362E');"> </table>
					<b> <?php echo CalculAge(ChercheBDD("DateNaissance", $_POST['Pseudo'])); ?> ans, <?php AfficheDepartement(ChercheBDD("Lieu", $_POST['Pseudo'])); ?> </b><br/><br/>
					Description : <center><div class="CadrePAU"><?php echo ChercheBDD("Description", $_POST['Pseudo']); ?> <br/> </div></center></br>
			    </th> 
			    <th>
					<b> SEXE :  <?php AfficheSexe(ChercheBDD("sexe", $_POST['Pseudo'])); ?> <br/>
					    ORIENTATION : <?php AfficheOrientation(ChercheBDD("Orientation", $_POST['Pseudo'])); ?><br/><br/><br/>
						ALLERGIE(S) : <div class='allergiePAU' style="color : #E6362E;"> <?php AfficheAllergie(ChercheBDD("Allergie1", $_POST['Pseudo'])); ?> <br/> <?php $valeur=ChercheBDD("NiveauAllergie1", $_POST['Pseudo']); echo"<input type='range' min='0' max='5' value='$valeur' style='color : gold;'>"; ?> </div><br/>
									  <div class='allergiePAU' style="color : #E6362E;"> <?php AfficheAllergie(ChercheBDD("Allergie2", $_POST['Pseudo'])); ?> <br/> <?php $valeur=ChercheBDD("NiveauAllergie2", $_POST['Pseudo']); echo"<input type='range' min='0' max='5' value='$valeur' style='color : gold;'>"; ?> </div><br/>
									  <div class='allergiePAU' style="color : #E6362E;"> <?php AfficheAllergie(ChercheBDD("Allergie3", $_POST['Pseudo'])); ?> <br/> <?php $valeur=ChercheBDD("NiveauAllergie3", $_POST['Pseudo']); echo"<input type='range' min='0' max='5' value='$valeur' style='color : gold;'>"; ?> </div><br/>					
					</b>
			    </th> 
			    <th>
					Qualités et défauts : <center><div class="CadrePAU"><?php echo ChercheBDD("QualitesDefauts", $_POST['Pseudo']); ?><br/></div></center><br/>
					Passions : <center><div class="CadrePAU"><?php echo ChercheBDD("Passions", $_POST['Pseudo']); ?> <br/> </div></center><br/>
					Phobies : <center><div class="CadrePAU"> <?php echo ChercheBDD("Phobies", $_POST['Pseudo']); ?><br/> </div></center><br/>
					Pire date : <center><div class="CadrePAU"> <?php echo ChercheBDD("PireDate", $_POST['Pseudo']); ?><br/> </div></center><br/>
			    </th> 
              </tr>
            </thead>
          </table>
</div>


<div class="side">
    <h2><span style="color: #f1f1f1;">A<br/></span></h2>
</div>
</div>

<!-- Pied de page -->   
<div class="footerPAU">
  <p><i>ALOVEGIE</i>, create by CHEVRIER Chleo, GONTIE Margaux, JANELA CAMEIJO Alice, MARTIN Teo, CPI2 Groupe 5</p>
</div> 


<!-- SCRIPT JAVASCRIPT CAR PAGE APPELEE EN AJAX -->
	<script>
		choseAFaireAuChargementDeLaPagePAU(<?php echo VerifCo();?>, <?php echo VerifAbo();?>, <?php echo CalculNbAllergiesPAU($_POST['Pseudo']);?>, <?php echo VerifAboPAU($_POST['Pseudo']); ?>, <?php echo ChercheBDD("Admin", $_SESSION['pseudo']); ?>,<?php echo ChercheBDD("Admin",$_POST["Pseudo"]); ?>);
	</script>


</body>
</html>








