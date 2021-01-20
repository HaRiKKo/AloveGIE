<!DOCTYPE html>
<?php
session_start();
?>
<html lang="fr">
<head>
<title>ABONNEMENT</title>
<meta charset="UTF-8">
<link rel="icon" href="logo3.jpg" />
<link rel="stylesheet" href="AbonnementW3.css" />
<?php include "BddInfoRecherche.php"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script type="text/javascript">
	
	
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
					
					liste.appendChild(newlien4);
				break;
				
				default : alert("Erreur de niveau d'abonement");

			}
		} else {     
			var newlien1=document.createElement('a');
			
			newlien1.setAttribute("href","InscriptionW3.php");
			
			newlien1.setAttribute("class","right");
			
			newlien1.innerHTML = "<b> Inscription </b>";
			
			liste.appendChild(newlien1);
	
		}
	}
	
	/*Fonction  qui récupère le niveau d'abonnement qui nous interesse et qui ouvre la page : PagePayementW3.php (en AJAX), 
	en important le niveau d'abonnement dans celle-ci*/
	function souscrieAbonnement(bouton){
		var Niveau=bouton.getAttribute('id');
		var body=document.getElementById('BodyAbonnementW3'); 

        var xhr= new XMLHttpRequest();
   
        xhr.onreadystatechange = function() {
            if ((xhr.readyState==4) && (xhr.status==200)){
                var reponse=xhr.responseText;
                body.innerHTML = reponse;
            }
        }
       
        xhr.open("POST", "PagePayementW3.php", true);
   
        xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
   
        xhr.send("Niveau="+Niveau);
	}
	
	//vérifie si vous êtes déja abonné et execute la fonction : souscrieAbonnement 
	function AboVerif(bouton, Niveau){
		if (Niveau!=0){
			if ( confirm( "Vous avez déja un abonnenement! Etes vous sur de vouloir continuer?") ){
					souscrieAbonnement(bouton);
			}
		} else { souscrieAbonnement(bouton); }
	}
	
	/*fonction qui vérifie le niveau d'abonnement et la connection et
	qui execute toutes les fonctions à faire au chargement de la page */
	function choseAFaireAuChargementDeLaPage(connection, abonnement){
		if (connection==0){
			document.getElementById('NivActu').remove();
		}
		Onglet(connection,abonnement);
		Modal2.style.display = 'block';
	}	
  
</script>
</head>


<body id="BodyAbonnementW3" style="background-color: f1f1f1;" onload="choseAFaireAuChargementDeLaPage(<?php echo VerifCo();?>,<?php echo VerifAbo();?>);">
	
<!-- En-tête du site -->
<div class="header">
  <h1>A<span id="Love"><i>LOVE</i></span>GIE</i></h1>
  <p style="font-size:20px;"><b>Fini les allergies, rencontrez enfin l'amour de votre vie !</b></p>
</div>


<!-- Onglets -->
<div id='listeOnglet' class="navbar">
  <a href="RechercheW3.php" class="right"><b>Autres Profils</b></a>
  <a id="BoutonRemark" href="AccueilW3.php" class="right"><b>ACCUEIL</b></a>
</div>


 <!-- Afficher le niveau d'abonnement -->
<div  class="side" id="NivActu">       
<b>Votre niveau d'abonnement actuel : <?php echo ChercheBDD("Abonnement",$_SESSION["pseudo"]); ?></b>
</div>
        
        
<!-- zone profils autres utilisateurs -->
<div class="side">
    <h2>Abonnements disponibles</h2>
</div>
				 
				<div class="column">
					<div class="card">
					<center><img src="logo.jpg" alt="Logo" style="width:35%;"></center>
					<div class="container">
						<center>
							<div class="titleAbo">
						Abonnement niveau 1
					</div>
					</br>
						</br>
						<b>
							</br><u style="color: #FFA8A8;"> Nouvel Onglet <b>Messagerie</b></u> : Possibilité de communiquer avec un autre utilisateur par message </br>
							<u style="color: #FFA8A8;"> Filtres disponibles ! </u> : Dans la page "Autres Profils", vous pourrez desormais trier vos propositions de profil en fonction de l'age et du lieu</br>
							<u style="color: #FFA8A8;" >Les LIKES</u> Faites savoir à vos crushs que vous êtes interessés par eux grâce à la fonction <b>Like</b> en illimitée <br/>

						</b>
						</br>
						<b style="color: red;">Prix :</b> </br>
						Seulement 15,95€ </br>
						</br>
						<?php
						if ( isset($_SESSION["pseudo"]) ){
							$NivActuel=ChercheBDD("Abonnement",$_SESSION["pseudo"]);
							echo'<input type="button" class="Niveau" id="Niveau1" name="Niveau1" value="Je souscrie a un abonnement de niveau 1"  onclick=" AboVerif(this,'.$NivActuel.'   );"/>';
						
						}?>
						</br>
						<br/>
						</br>
					</center>
					</div>
				  </div>
				  </div>
				  
				  <div class="column">
					<div class="card">
					<center><img src="logo.jpg" alt="Logo" style="width:35%;"></center>
					<div class="container">
						<center>
						<div class="titleAbo">
						Abonnement niveau 2
					</div>
						</br>
						</br>
						<b></br> <u style="color: #FFA8A8;"> Plus de MESSAGES </u>: Vous pouvez maintenant entrer en commmunication avec 5 personnes au lieu d'une seule !</br>
							     <u style="color: #FFA8A8;"> Nouveaux Filtre </u>: Dans la page "Autres Profils", disposez du filtre "Allergie" qui permet de selectionner les profils en fonction de leur(s) allergie(s) </br></b>
								<u style="color: #FFA8A8;"><b>Les SUPERLIKES</b></u> <b>Votre superlike sera mis en évidence sur le profil de votre crush !</b>
						</br>
						</br>
						<b style="color: red;">Prix :</b> </br>
						Promotion <del>30€</del> => 29.99€
						</br>
						</br>
						<?php
						if ( isset($_SESSION["pseudo"]) ){
							$NivActuel=ChercheBDD("Abonnement",$_SESSION["pseudo"]);
							echo '<input type="button" class="Niveau" id="Niveau2" name="Niveau2" value="Je souscrie a un abonnement de niveau 2" onclick=" AboVerif(this,'.$NivActuel.' );"/>';
						
						}?>
						</br></br>
						</br>
					</center>
					</div>
				  </div>
				  </div>
				  <?php
				  if (isset($_SESSION["pseudo"])&&(ChercheBDD("Admin",$_SESSION["pseudo"])!=1)&&(VerifAbo()!=0)){
					  echo'
							<div class="column"> 
								<div class="card">
									<center><img src="logo.jpg" alt="Logo" style="width:35%;"></center>
									<div class="container">
									<center>
										<div class="titleAbo">
											Resiliation
										</div>
									</br></br>
									Voulez vous résilier votre abonnement ?<br/>
									<b>Attention vous ne serez pas remboursé.e !</b>
									</br>
									';
									?>
									<!-- bouton ouvrant un pop-up -->
									<button id="boutonResilier" onclick="Modal.style.display = 'block';"><b>Résilier mon abonnement</b></button>
									<?php
									// vérification du mot de passe avant de confirmer la résiliation 
									if(isset($_POST["confirm"])){	?>
										<div id="Modal2" class="modal" >
										<?php
										if($_POST["confirmMDP"]==ChercheBDD("MotDePasse",$_SESSION["pseudo"])){
											echo "<div class='modal-content'>";
											$_SESSION["abonne"]=ModifierProfil($_SESSION["pseudo"],"Abonnement",0);
											echo "<p> Votre abonnement a bien été résilié. Retourner à l' <a href='AccueilW3.php'> Accueil </a> </p><br/>";
											echo "</div>";
										}else{	echo "<div class='modal-content'>";?>
											<span class="close" onclick="Modal2.style.display = 'none';">&times;</span>
											<?php	echo "<p>Mot de passe incorrect</p><p>L'opération a été annulée</p>";
											echo "</div>";
										}
										echo "</div>";
									}?>
									<!-- pop-up demandant la confirmation du mot de passe -->
									<div id="Modal" class="modal">
										<div class="modal-content">
											<span class="close" onclick="Modal.style.display = 'none';">&times;</span>
											<p>Pour confirmer la résiliation de votre abonnement veuillez entrer votre mot de passe :</p><br/>
											<?php	echo "<form action='AbonnementW3.php' method='POST'><input type='password' name='confirmMDP' />   <input type='submit' name='confirm' value='Confirmer la résiliation'/> </form> ";
											?>
										</div>		  
									</div>
		  
								</div>
							</div>
					<?php  }?>


<!-- Pied de page -->   
<div class="footer">
  <p><i>ALOVEGIE</i>, create by CHEVRIER Chleo, GONTIE Margaux, JANELA CAMEIJO Alice, MARTIN Teo, CPI2 Groupe 5</p>
</div>        

</body>
</html>
