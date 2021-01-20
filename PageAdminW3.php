<!DOCTYPE html>
<?php
session_start();
?>
<html lang="fr">
<head>
<title>ADMINISTRATEUR</title>
<meta charset="UTF-8">
<link rel="icon" href="logo3.jpg" />
<link rel="stylesheet" href="PageAdminW3.css" />
<?php include "BddInfoRecherche.php"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" >
	
	//fonction qui verifie si tu es administrateur si NON te renvoie dans l'accueil
	function choseAFaireAuChargementDeLaPage (administration){
		if (administration==0){
			alert("vous n'avez rien à faire ici :/");
			window.location.href="AccueilW3.php";
		}
	}
	
	
	/* charger la page ProfilAutreUtilisateur en AJAX*/
	function enregistrerPseudoDansFichier(i) {
		//alert('sousou');
			var Elements=document.getElementsByClassName('PseudonymesAutresUtilisateursA');
			var Pseudo=Elements[i].value;
			var body=document.getElementById('BodyPageAdminW3');      
		
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
		
		
	/* Charger la page MessagerieGeneral en AJAX */ 	
	function VersMessagerieG(Pseudo){
		var body=document.getElementById('BodyPageAdminW3');   
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
       
        xhr.open("POST", "MessagerieGenerale.php", true);
   
        xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
   
        xhr.send("Pseudo="+Pseudo);
  
   
    }
    
    
    /* Charger la page MessagerieGeneral en AJAX */
    function VersModifierProfilG(Pseudo){
		//alert(Pseudo);
		var body=document.getElementById('BodyPageAdminW3');   
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
       
        xhr.open("POST", "ModifierProfilGeneral.php", true);
   
        xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
   
        xhr.send("Pseudo="+Pseudo);
  
   
    }	
    
    //affiche un message si le profil de l'utilisateur choisie a bien été supprimé
    function supprimerProfil(nom){
		alert('Le profil de '+nom+' a bien été supprimé !');
	}
	
 //////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/  
    ////////////////////FUNCTION ModifierProfilGeneral\\\\\\\\\\\\\\\\\\\\\\
    
    //affiche le mot de passe de l'utilisateur avec un alert	
    function passWord(){
		var mot = document.getElementById('mdp').value;
		alert("Le mot de Passe : "+mot);
	}
	
	
	//fonction qui verifie si tu es administrateur si NON te renvoie dans l'accueil
	function choseAFaireAuChargementDeLaPageMPG (administration){
		if (administration==0){
			alert("vous n'avez rien à faire ici :/");
			window.location.href="AccueilW3.php";
		}

	}
	
	//Envoie un alert si le profil a bien été supprimé
	function supprimerMonProfil(){
		alert('Votre profil a bien été supprimé !');
	}
    
    
    //////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/    
    ////////////////////////FUNCTION MessagerieGenerale\\\\\\\\\\\\\\\\\\\\\\
    
    
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
		var body=document.getElementById('BodyPageAdminW3');   
			
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
    
    
    //////////////////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/    
    //////////////////FUNCTION ProfilAutreUtilisateur\\\\\\\\\\\\\\\\\\\\\\\
    
    
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
		
		
	//si l'utilisateur n'a pas mis toute les photos alors il va mettre automatiquement le logo du site sur les photos manquantes 
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
	function choseAFaireAuChargementDeLaPagePAU (connection, abonnement, nbAllergie, aboAutre, administration){
		if (connection==0){
			alert("vous n'avez rien à faire ici :/");
			window.location.href="AccueilW3.php";
		}
		if (administration==0) { document.getElementById('infoPerso').remove(); }
		if ( (abonnement==0) || (aboAutre==0) ){ document.getElementById('messagePAU').remove(); }
		
		AllergiePAU(nbAllergie);
		OngletPAU(connection, abonnement);
	}
	
	/* Fonction qui récupère le pseudo de la personne qui nous interesse 
	et qui va ouvrir la page massagerieW3.php dans la page ProfilAutreUtilisateur*/
	function VersMessageriePAU(Pseudo){
		
		var body=document.getElementById('BodyPageAdminW3');   
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


<body id="BodyPageAdminW3" style="background-color: #f1f1f1;"  onload="choseAFaireAuChargementDeLaPage(<?php echo ChercheBDD("Admin", $_SESSION['pseudo']); ?>)">

<!-- En-tête du site -->
<div class="header">
  <h1>A<span id="Love"><i>LOVE</i></span>GIE</i></h1>
  <p style="font-size:20px;"><b>Fini les allergies, rencontrez enfin l'amour de votre vie !</b></p>
</div>


<!-- Onglets -->
<div id='listeOnglet' class="navbar">
  <a href="MessagerieW3.php" class="right"><b>Messagerie</b></a>
  <a href="AbonnementW3.php" class="right"><b>Abonnement</b></a>
  <a href="RechercheW3.php" class="right"><b>Autres Profils</b></a>
  <a href="DeconnexionW3.php" class="right"><b>Deconnexion</b></a>
  <a id="BoutonRemark" href="AccueilW3.php" class="right"><b>ACCUEIL</b></a>
</div>


<!-- Zone administrative  -->
<?php

if(isset($_POST["envoi"])){
	SupprimerSignalement($_POST["suppr"]);
		    SupprimerBlocage($_POST["suppr"]);
		    SupprimerLike($_POST["suppr"]);
		    SupprimerSuperLike($_POST["suppr"]);
		    $TabConv = TrouveNbConversations($_POST["suppr"]);
			for($i=0;$i<sizeof($TabConv);$i++){
				SupprimerMessage($_POST["suppr"], $TabConv[$i]);
			}
	SupprimerProfil($_POST["suppr"]);
}


$TabUtilisateurs = ListeUtilisateurs();
// affiche un tableau avec l'ensemble des utilisateurs du site
echo"<center><table border 1px solid #E6263E >";
for($i=0; $i<sizeof($TabUtilisateurs); $i++){
	?>
	<tr>
	<td><br/><b><center><input type="button" class="PseudonymesAutresUtilisateursA" style="color:#E6263E;" onclick="enregistrerPseudoDansFichier(<?php echo $i; ?>);" value="<?php echo $TabUtilisateurs[$i]; ?>" /></center></b><br/></td>
	<td><input type="button" onclick="VersModifierProfilG('<?php echo $TabUtilisateurs[$i]; ?>');" value="Modifier ce profil"/> </td>
	<td><input type="button" onclick="VersMessagerieG('<?php echo $TabUtilisateurs[$i]; ?>');" value="Accéder à la messagerie"/> </td>
	
	<td><form action="PageAdminW3.php" method="POST">
		<input type="hidden" name="suppr" value="<?php echo $TabUtilisateurs[$i]; ?>" />
		<input type="submit" name="envoi" value="Supprimer ce profil" onclick="supprimerProfil('<?php echo $TabUtilisateurs[$i]; ?>')"/>
	</form></td>
	<td><?php echo TrouveSignalement($TabUtilisateurs[$i]); ?></td>
	<td><?php echo TrouveBlocage($TabUtilisateurs[$i]); ?></td>
	</tr>
<?php
}
?>

</table></center>
<br/><br/><br/>

<!-- Pied de page -->   
<div class="footer">
  <p><i>ALOVEGIE</i>, create by CHEVRIER Chleo, GONTIE Margaux, JANELA CAMEIJO Alice, MARTIN Teo, CPI2 Groupe 5</p>
</div>        

</body>
</html>








