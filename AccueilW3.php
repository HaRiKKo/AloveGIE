<!DOCTYPE html>
<?php
session_start();
?>
<html lang="fr">
<head>
<title>ACCUEIL</title>
<meta charset="UTF-8">
<link rel="icon" href="logo3.jpg" />
<link rel="stylesheet" href="AccueilW3.css" />
<?php include "BddInfoRecherche.php"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" >

   
   //Change la couleur des carrés et la photo de profil 		
	function ChangementPhotoCarre( img, couleurUn, couleurDeux, couleurTrois){ //Le carré de droite = photo 3 (logo)
		var photo = document.getElementById("PhoProf");
		var CarreUn = document.getElementById("Un");
		var CarreDeux = document.getElementById("Deux");
		var CarreTrois = document.getElementById("Trois");
		photo.src = img;
		
		CarreUn.bgColor = couleurUn;
		CarreDeux.bgColor = couleurDeux;
		CarreTrois.bgColor = couleurTrois;
	}
	
	
	/*fonction qui permet de "changer" de page quand on clic sur le pseudo d'une personne
	la fonction va récuperer le pseudo de la personne que l'utilisateur à choisie,
	puis on va utiliser ajax pour envoyer son pseudo dans la page php 'ProfilAutreUtilisateurW3' 
	et pour charger son code dans le body de cette page */
    function enregistrerPseudoDansFichier(i,connection) {
		if(connection==1){
			var Elements=document.getElementsByClassName('PseudonymesAutresUtilisateurs');
			var Pseudo=Elements[i].value;
			var body=document.getElementById('BodyAccueilW3');   
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
   
    }
    
	//fonction qui ajoute les onglets en fonction de la connection et de l'abonnement 
	function Onglet(connection, abonnement){
		 
		var liste = document.getElementById('listeOnglet');
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
			newlien1.setAttribute("id","BoutonRemark");
			newlien2.setAttribute("id","BoutonConnexion");
			
			newlien1.innerHTML = "<b> Inscription </b>";
			newlien2.innerHTML = "<b> Connexion </b>";
			
			liste.appendChild(newlien1);
			liste.appendChild(newlien2);
		}
	
	}
	
	
	/* Fonction qui récupère le pseudo de la personne qui nous interèsse et qui va ouvrir la page massagerieW3.php */
	function VersMessagerie(i){
		var Pseudo=document.getElementsByClassName('PseudonymesAutresUtilisateurs')[i].value;
		var body=document.getElementById('BodyAccueilW3');   
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
    
    //function qui ajoute les boutons messageries sur chaque proposition de profil
    function messagerie (abonnement){
        if ( (abonnement==2) || (abonnement==1) ){
      
            var messagerie = document.getElementsByClassName('Messagerie');

            for (var i=0; i<messagerie.length; i++){
                var bouton = document.createElement('input');
                
                bouton.setAttribute('type', 'button');
                bouton.setAttribute('class', 'button');
                bouton.setAttribute('value',"Message");
                bouton.setAttribute('onclick','VersMessagerie('+i+')');
               
                messagerie[i].appendChild(bouton);
                
            }

        }
        
    }
    
	//fonction qui supprime les allergies si tu n'en a pas trois
	function Allergie(nbAllergie){
		var allergie = document.getElementsByClassName('allergie');
		switch (nbAllergie) {
			case 1 : allergie[2].remove(); allergie[1].remove();
			break;
			case 2 : allergie[2].remove();
			break;
			
		}
	}
		
	/*fonction qui verifie le niveau d'abonnement et la connection et
	qui execute toutes les fonctions à faire au chargement de la page */	
	function choseAFaireAuChargementDeLaPage(connection, abonnement, nbAllergie){
		if (connection!=0){ messagerie(abonnement); }
		if(connection==0){
            document.getElementById('id01').style.display='block';
            document.getElementsByClassName('card2')[0].remove();
        }
		Allergie(nbAllergie);
		Onglet(connection, abonnement);
	}
	
	
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// -------------------------------------------------- FONCTION DE PROFIL AUTRE UTILISATEUR ------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	
	//Change la couleur des carrés et la photo de profil dans la page ProfilAutreUtilisateur		
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
			case 1 : allergie[1].remove(); allergie[2].remove();
			break;
			case 2 : allergie[2].remove();
			break;
			
		}
	}
	
	
	function Profil_RecomandationPAU(connection){
		var profil=getElementById();
		profil.remove();
		
	}
	
	/*fonction qui verifie le niveau d'abonnement et la connection et
	qui execute toutes les fonctions à faire au chargement de la page dans la page ProfilAutreUtilisateur*/
	function choseAFaireAuChargementDeLaPagePAU (connection, abonnement, nbAllergie){
		if (connection==0){
			alert("vous n'avez rien à faire ici :/");
			window.location.href="AccueilW3.php";
		}
		if (abonnement==0){ document.getElementById('messagePAU').remove(); }
		
		AllergiePAU(nbAllergie);
		OngletPAU(connection, abonnement);
	}
	
	/* Fonction qui récupère le pseudo de la personne qui nous interèsse 
	et qui vas ouvrir la page 'massagerieW3.php' dans la page ProfilAutreUtilisateur*/
	function VersMessageriePAU(Pseudo){
		//alert(Pseudo);
		
		var body=document.getElementById('BodyAccueilW3');   
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
    
    /////////////Function de messagerie\\\\\\\\\\\\\\\\\\\\
    /* fonction qui est appelé dans la page messagerie et qui nous remenne dans la page ProfilAutreUtilisateurW3 */
    function enregistrerPseudoDansFichierM() {
		var Elements=document.getElementById('autrePseudo');
		var Pseudo=Elements.value;
		var body=document.getElementById('BodyAccueilW3');   
			
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


<body id="BodyAccueilW3" style="background-color: f1f1f1;" onload="choseAFaireAuChargementDeLaPage(<?php echo VerifCo();?>,<?php echo VerifAbo();?>,<?php echo CalculNbAllergies();?>);">


<!-- En-tête du site -->
<div class="header">
  <h1>A<span id="Love"><i>LOVE</i></span>GIE</i></h1>
  <p style="font-size:20px;"><b>Fini les allergies, rencontrez enfin l'amour de votre vie !</b></p>
</div>


<!-- Onglets -->
<div id='listeOnglet' class="navbar">
  <a href="AbonnementW3.php" class="right"><b>Abonnement</b></a>
  <a href="RechercheW3.php" class="right"><b>Autres Profils</b></a>  
 </div>
 
 
<!-- Pop-up Connexion -->
<div id="id01" class="modal">
  <?php
  echo' <form class="modal-content animate" action="AccueilW3.php" method="POST">';
    echo '<div class="imgcontainer">
      <img src="logo.jpg" alt="Avatar" class="avatar">
    </div>';?>

 
 <?php   if(isset($_POST['mdp'])){
                            if (empty($_POST['pseudo']) || empty($_POST['mdp'])) // si oublie d'un champ
                            {
                                $message = '<p>Vous devez remplir tous les champs</p>';
                                //<p>Cliquez <a href="./Connexion.php" style="color : gold;">ici</a> pour ressayer</p>';
                            }
                            else // Vérification du mot de passe
                            {//on récupère le mdp dans la BDD  
                                if (($_POST['mdp'] == ChercheBDD("MotDePasse", $_POST['pseudo']))) // si bon mot de passe
                                {
                                InitSession($_POST['pseudo']);  
                                    $message='<center><p class="side" id="NivActu">Connexion établie !</p></center>';
                                }
                                else // si mauvais mot de passe
                                {
                                    $message = '<center><p class="side" id="NivActu">Identifiants incorrects.</p></center>';
                                }
                                } 
                                echo "<form action='AccueilW3.php'><div style='color: red; font-size: 18px;'><b>".$message."</b></div><br/><center><input type='submit' value='OK'/></center></form>";
                                echo "</br>"; 
                        } else{

echo '<div class="container">';?>
       <span onclick="document.getElementById('id01').style.display='none';"
class="close" title="Close Modal">&times;</span>
    <?php //formulaire de connexion
     echo "<p>
      Pseudo :<input name='pseudo' type='text' required/><br/><br/>
      Mot de Passe :<input type='password' name='mdp' required/><br/>
      </p>";
    echo '<button id="BoutonSeConnecter" type="submit"><b>Me connecter</b></button>
    </div>
    <br/>
    </form>';
    ?>
    <!--  Bas du pop-up de connexion  -->
  <div class="modal-content animate">
    <div class="container" style="background-color:#f1f1f1">
      <span style="color: #f1f1f1;">espace</span>
      <br/>
      
      <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn"><b>Retour</b></button> <!-- Bouton retour à la page d'accueil -->
      
      <span class="psw"><a href="InscriptionW3.php">Vous n êtes pas encore inscrit ?</a></span> <!-- Bouton menant à la page InscriptionW3.php -->
      <br/>
      <span style="color: #f1f1f1;">espace</span>
    </div>
  </div>
  <?php } ?>
</div>


<!-- Texte de présentation -->
   <div class="side">
    <h2>A PROPOS</h2>
    <div class="fakeimg" style=" text-align: left; font-size: 18px; background-color:#FFE6E6; color: #333; font-family: Snell Roundhand, cursive;">  Grâce à ALOVEGIE, j'ai fait de merveilleuses rencontres.</br> Le site m'a permis de rencontrer des gens comme moi, avec des allergies. <br/> Maintenant, je n'ai à m'inquiéter au sujet de mon premier rendez-vous (quel restaurant choisir... ?)<br/> Toutes les personnes avec qui j'ai pu discuter étaient adorables !<br/> En plus de cela, les administrateurs du site sont vraiment à l'écoute de toutes nos réclamations !<br/> Chléo, 19 ans.  
</div>
  
<!-- Profils autres utilisateurs du site -->
<?php																			  // Sélection des profils
 if(isset($_SESSION["pseudo"])){ // si utilisateur
  $init = $_SESSION["pseudo"];
}else{			// si visiteur
    $init = "";
}
 $_SESSION["Prof1"]=$init;
    while($_SESSION["Prof1"]==$init){
    $_SESSION["Prof1"] = TrouveLigne(2); }
    $_SESSION["Prof2"]=$_SESSION["Prof1"];
    while(($_SESSION["Prof2"]==$_SESSION["Prof1"])||($_SESSION["Prof2"]==$init)){  // Boucle tant que qui verifie qu'on tire pas deux fois le meme profil !
    $_SESSION["Prof2"] = TrouveLigne(2);                  
    }
    $_SESSION["Prof3"]=$init;
    while($_SESSION["Prof3"]==$init){
    $_SESSION["Prof3"] = TrouveLigne(1); }
?>


<div class="side">
    <h2><br/>PROFILS</h2>
</div>				<!-- Affichage du premier profil -->
					<div class="column">
					<div class="card">
					<center><img src="<?php echo ChercheBDD("Photo1",$_SESSION['Prof1']); ?>" alt="Logo" style="width:35%;"></center>
					<div class="container">
						<center>
						<h2><input type="button" class="PseudonymesAutresUtilisateurs" onclick="enregistrerPseudoDansFichier(0,<?php echo VerifCo();?>);" value= "<?php echo $_SESSION['Prof1']; ?>" /></h2>
						<p class="title"><b><?php echo CalculAge(ChercheBDD("DateNaissance", $_SESSION['Prof1'])); ?> ans, <?php AfficheDepartement(ChercheBDD("lieu", $_SESSION['Prof1'])); ?></b></p>
						<p><b><?php AfficheSexe(ChercheBDD("Sexe", $_SESSION['Prof1'])); ?>, <?php AfficheOrientation(ChercheBDD("orientation", $_SESSION['Prof1'])); ?></b></p>
						<p><b>
						<div style="color : #E6362E;"><?php AfficheAllergie(ChercheBDD("Allergie1", $_SESSION['Prof1']));AfficheAllergie(ChercheBDD("Allergie2", $_SESSION['Prof1']));AfficheAllergie(ChercheBDD("Allergie3", $_SESSION['Prof1'])); ?></div>
						</b></p>
						<p class='Messagerie' ></p>  <!-- Ne s'affiche que si l'utilisateur du site est connecté et abonné -->
						</div>
						<br/>  
						<br/> 
						<br/>
					</center>
					</div>
				  </div>
				  </div>
				 <!-- Affichage du deuxieme profil -->
					 <div class="column">
					<div class="card">
					<center><img src="<?php echo ChercheBDD("Photo1",$_SESSION['Prof2']); ?>" alt="Logo" style="width:35%;"></center>
					<div class="container">
						<center>
						<h2><input type="button" class="PseudonymesAutresUtilisateurs" onclick="enregistrerPseudoDansFichier(1,<?php echo VerifCo();?>);" value= "<?php echo $_SESSION['Prof2']; ?>" /></h2>
						<p class="title"><b><?php echo CalculAge(ChercheBDD("DateNaissance", $_SESSION['Prof2'])); ?> ans, <?php AfficheDepartement(ChercheBDD("lieu", $_SESSION['Prof2'])); ?></b></p>
						<p><b><?php AfficheSexe(ChercheBDD("sexe", $_SESSION['Prof2'])); ?>, <?php AfficheOrientation(ChercheBDD("orientation", $_SESSION['Prof2'])); ?></b></p>
						<p><b>
						<div style="color : #E6362E;"><?php AfficheAllergie(ChercheBDD("Allergie1", $_SESSION['Prof2']));AfficheAllergie(ChercheBDD("Allergie2", $_SESSION['Prof2']));AfficheAllergie(ChercheBDD("Allergie3", $_SESSION['Prof2'])); ?></div>
						</b></p>
						<p class='Messagerie' ></p>  <!-- Ne s'affiche que si l'utilisateur du site est connecté et abonné -->
						</div>
						<br/>  
						<br/> 
					</center>
					</div>
				  </div>
				  </div>
				 <!-- Affichage du troisieme profil -->
					 <div class="column">
					<div class="card">
					<center><img src="<?php echo ChercheBDD("Photo1",$_SESSION['Prof3']); ?>" alt="Logo" style="width:35%;"></center>
					<div class="container">
						<center>
						<h2><input type="button" class="PseudonymesAutresUtilisateurs" onclick="enregistrerPseudoDansFichier(2,<?php echo VerifCo();?>);" value= "<?php echo $_SESSION['Prof3']; ?>" /></h2>
						<p class="title"><b><?php echo CalculAge(ChercheBDD("DateNaissance", $_SESSION['Prof3'])); ?> ans, <?php AfficheDepartement(ChercheBDD("lieu", $_SESSION['Prof3'])); ?></b></p>
						<p><b><?php AfficheSexe(ChercheBDD("sexe", $_SESSION['Prof3'])); ?>, <?php AfficheOrientation(ChercheBDD("orientation", $_SESSION['Prof3'])); ?></b></p>
						<p><b>
						<div style="color : #E6362E;"><?php AfficheAllergie(ChercheBDD("Allergie1", $_SESSION['Prof3']));AfficheAllergie(ChercheBDD("Allergie2", $_SESSION['Prof3']));AfficheAllergie(ChercheBDD("Allergie3", $_SESSION['Prof3'])); ?></div>
						</b></p>
						<p class='Messagerie' ></p>  <!-- Ne s'affiche que si l'utilisateur du site est connecté et abonné -->
						</div>
						<br/>  
						<br/> 
					</center>
					</div>
				  </div>
				  </div>

				  


<!-- Mon profil --><!-- Ne s'affiche que si utilisateur connecté à son compte -->
<div class="card2">
<div class="side">
    <h2><span style="color: #f1f1f1;">A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/>A<br/></span>MON PROFIL</h2>
</div>

<table id="Profil"  style=" width: 85%; height: 450px; margin-left: 47px; background-color : #f1f1f1;">
            <thead>
              <tr>
			    <th>
				<b><br/><a href="MonProfilW3.php" id="Pseudonyme"> <?php echo $_SESSION["pseudo"]; ?></a></b> <br/><br/>	
					  <img id="PhoProf" height="220" style="border : 2px solid;" src="<?php echo $_SESSION['photo1']; ?>"/>
					  <?php $p1 = $_SESSION['photo1'];
							$p2 = $_SESSION['photo2'];
							$p3 = $_SESSION['photo3'];
					   ?> 
					 <table class="carreau" id="Un" border="1px;" bgcolor="#FFFFFF" style="width:13px; height:13px; top:650px; left:410px;" onclick="ChangementPhotoCarre('<?php echo $p2; ?>','#E6362E','#FFFFFF','#FFFFFF');"> </table><table class="carreau" id="Deux" border="1px;" bgcolor="#E6362E" style="width:13px; height:13px; top:650px; left:410px;" onclick="ChangementPhotoCarre('<?php echo $p1; ?>','#FFFFFF','#E6362E','#FFFFFF');"> </table><table class="carreau" id="Trois" border="1px;" bgcolor="#FFFFFF" style="width:13px; height:13px; top:650px; left:410px;" onclick="ChangementPhotoCarre('<?php echo $p3; ?>','#FFFFFF','#FFFFFF','#E6362E');"> </table>
             		 <b> <?php echo CalculAge($_SESSION["DateNaissance"]); ?> ans, <?php AfficheDepartement($_SESSION["lieu"]); ?> </b><br/><br/>
					Description : <center><div class="Cadre"><?php echo $_SESSION["description"]; ?> <br/> </div></center></br>
			    </th> 
			    <th>
					<b> SEXE :  <?php AfficheSexe($_SESSION["sexe"]); ?> <br/>
					    ORIENTATION : <?php AfficheOrientation($_SESSION["orientation"]); ?> <br/><br/><br/>
						ALLERGIE(S) : <?php CalculNbAllergies($_SESSION["allergie"][1],$_SESSION["allergie"][2]);?>
						<br/><br/>		
								<div class='allergie' style="color : #E6362E;"> <?php AfficheAllergie($_SESSION["allergie"][0]); ?> <?php $valeur=$_SESSION["NivAllergie"][0]; echo"<input type='range' min='0' max='5' value='$valeur' style='color : gold;'>"; ?> </div><br/>
								<div class='allergie' style="color : #E6362E;"> <?php AfficheAllergie($_SESSION["allergie"][1]); ?> <?php $valeur=$_SESSION["NivAllergie"][1]; echo"<input type='range' min='0' max='5' value='$valeur' style='color : gold;'>"; ?> </div><br/>
								<div class='allergie' style="color : #E6362E;"> <?php AfficheAllergie($_SESSION["allergie"][2]); ?> <?php $valeur=$_SESSION["NivAllergie"][2]; echo"<input type='range' min='0' max='5' value='$valeur' style='color : gold;'>"; ?> </div><br/>										
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
</div>


<div class="side">
    <h2><span style="color: #f1f1f1;">A<br/>A<br/>A<br/></span></h2>
</div>


     

<!-- Pieds de page -->   
<div class="footer">
  <p><i>ALOVEGIE</i>, create by CHEVRIER Chleo, GONTIE Margaux, JANELA CAMEIJO Alice, MARTIN Teo, CPI2 Groupe 5</p>
</div>        

</body>
</html>
