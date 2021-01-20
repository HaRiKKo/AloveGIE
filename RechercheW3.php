<!DOCTYPE html>
<?php
session_start();
?>
<html lang="fr">
<head>
<title>AUTRES PROFILS</title>
<meta charset="UTF-8">
<link rel="icon" href="logo3.jpg" />
<link rel="stylesheet" href="RechercheW3.css" />
<?php include "BddInfoRecherche.php"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript">
    
    /*fonction qui permet de "changer" de page quand on clic sur le pseudo d'une personne
    la fonction va récuperer le pseudo de la personne que l'utilisateur à choisie,
    puis on va utiliser ajax pour envoyer son pseudo dans la page php 'ProfilAutreUtilisateurW3' et pour charger son code dans le body de cette page */    
     function enregistrerPseudoDansFichier(i,connection) {
		//alert('sousou');
		if(connection==1){
			var Elements=document.getElementsByClassName('PseudonymesAutresUtilisateursR');
			var Pseudo=Elements[i].value;
			var body=document.getElementById('BodyRechercheW3');   
			//var html=document.getElementsByTagName('html')[0];   
		
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
     function Onglet (connection, abonnement){
         
        var liste=document.getElementById('listeOnglet');
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
           
            newlien1.setAttribute("href","InscriptionW3.php");
 
            newlien1.setAttribute("class","right");
           
            newlien1.innerHTML = "<b> Inscription </b>";
           
            liste.appendChild(newlien1);
           
        }
    
    }

	/* Fonction qui récupère le pseudo de la personne qui nous interèsse et qui vas ouvrir la page massagerieW3.php */
	function VersMessagerie(i){
		var Pseudo=document.getElementsByClassName('PseudonymesAutresUtilisateursR')[i].value;
		//alert(Pseudo);//
		var body=document.getElementById('BodyRechercheW3');   
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
                
                bouton.setAttribute('type','button');
                bouton.setAttribute('class', 'button');
                bouton.setAttribute('value',"Message");
                bouton.setAttribute('onclick','VersMessagerie('+i+')');
                
                messagerie[i].appendChild(bouton);
                
            }
        }
        
    }
    
    /*fonction qui vérifie le niveau d'abonnement et la connection et
	qui execute toutes les fonctions à faire au chargement de la page */
    function choseAFaireAuChargementDeLaPage(connection, abonnement){
		
		if (connection==0){
			document.getElementById('BoutonFiltreR').remove();
			document.getElementById('afficheFiltres').remove();
		}
		
		if ((abonnement==0)&&(connection==1)){ document.getElementById('BoutonFiltreR').remove(); }
	
        messagerie (abonnement);
        Onglet (connection, abonnement);
    }
    
    
    /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
function openNav() {
  document.getElementById("mySidenav").style.width = "450px";
  document.getElementById("main").style.marginLeft = "250px";
}
 

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
}

//fonction qui vérifie si l'age min et l'age max entrer dans le filtre et cohérent 
function VerifAge(){
	var ageMin=document.getElementById('ageMin').value;
	var ageMax=document.getElementById('ageMax').value;
	if((ageMin!="")&&(ageMax!="")&&(ageMin>ageMax)){
		alert('Vos critères d\'âge sont inversés ! Merci de faire attention la prochaine fois !');
	}
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




//Change la couleur des carré et la photo de profil 		
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
		
	//si l'utilisateur n'a pas mis toute les photo alors il vas mettre automatiquement le logo du site sur les photos manquantes 
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
			case 1 : allergie[2].remove();
			case 2 : allergie[1].remove();
			break;
			
		}
	}
	
	
	function Profil_RecomandationPAU(connection){
		var profil=getElementById();
		profil.remove();		
	}
	
	/*fonction qui verifie le niveau d'abonnement et la connection et
	qui execute toutes les fonctions à faire au chargement de la page dans la page ProfilAutreUtilisateur*/
	function choseAFaireAuChargementDeLaPagePAU (connection, abonnement, nbAllergie, aboAutre, administration){
		if (connection==0){
			alert("vous n'avez rien à faire ici :/");
			window.location.href="AccueilW3.php";
		}
	
		if ( (abonnement==0) || (aboAutre==0) ){ document.getElementById('messagePAU').remove(); }
		
		AllergiePAU(nbAllergie);
		OngletPAU(connection, abonnement);
	}
	
	
	function VersMessageriePAU(Pseudo){
		//alert(Pseudo);
		
		var body=document.getElementById('BodyRechercheW3');   
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


<body id="BodyRechercheW3" style="background-color: f1f1f1;" onload="choseAFaireAuChargementDeLaPage(<?php echo VerifCo();?>,<?php echo VerifAbo();?>);">
	
<!-- E
n-tête du site -->
<div class="header">
  <h1>A<span id="Love"><i>LOVE</i></span>GIE</i></h1>
  <p style="font-size:20px;"><b>Fini les allergies, rencontrez enfin l'amour de votre vie !</b></p>
</div>


<!-- Onglets -->
<div id='listeOnglet' class="navbar">
  <a href="AbonnementW3.php" class="right"><b>Abonnement</b></a>
  <a id="BoutonRemark" href="AccueilW3.php" class="right"><b>ACCUEIL</b></a>
</div>


<!-- zone des filtres et de la barre de recherche --> <!-- FILTRES RESERVES AUX ABONNES DE NIVEAU 1 ET 2 -->
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <?php if(VerifAbo()!=0){	?>
 <table id="FiltresR" style="border: 1px solid #333; width: 320px; height: 400px; margin-left: 47px; background-color : #FFE6E6;"> 
		<thead>
              <tr>
                <th>
					<span id="TitreFiltresR">JE RECHERCHE : </span><br/><br/><br/>
					
                <?php	//Affichage des filtres
					echo '<form id="FormFiltresR" method="POST" action="RechercheW3.php">';
					if(isset($_POST["ageMin"])){		
						echo 'Age mini : <input min="18" max="99" type="number" id="ageMin" name="ageMin" value="',$_POST["ageMin"],'"> <br><br/>';
					}else{echo 'Age mini : <input min="18" max="99" type="number" id="ageMin" name="ageMin"> <br><br/>';
					}
					if(isset($_POST["ageMax"])){
						echo 'Age max : <input min="18" max="100" type="number" id="ageMax" name="ageMax" value="',$_POST["ageMax"],'"> <br><br/>';
					}else{
						echo 'Age max : <input min="18" max="100"  type="number" id="ageMax" name="ageMax"> <br><br/>';
						}		
					for($i=0;$i<107;$i++){
						if((isset($_POST["lieu"]))&&($i==intval($_POST["lieu"],10))){
							$selection[$i]="selected";
						}else{$selection[$i]="";}
					}	
		echo'	Votre département : <select name="lieu">
							
      <option ></option>
      <option value="01" ',$selection[1],'>01 - Ain</option>
      <option value="02" ',$selection[2],'>02 - Aisne</option>
      <option value="03"',$selection[3],'>03 - Allier</option>
      <option value="04"',$selection[4],'>04 - Alpes-de-Haute-Provence</option>
      <option value="05"',$selection[5],'>05 - Hautes-Alpes</option>
      <option value="06"',$selection[6],'>06 - Alpes-Maritimes</option>
      <option value="07"',$selection[7],'>07 - Ardeche</option>
      <option value="08"',$selection[8],'>08 - Ardennes</option>
      <option value="09"',$selection[9],'>09 - Ariege</option>
      <option value="10"',$selection[10],'>10 - Aube</option>
      <option value="11"',$selection[11],'>11 - Aude</option>
      <option value="12"',$selection[12],'>12 - Aveyron</option>
      <option value="13"',$selection[13],'>13 - Bouches-du-Rhone</option>
      <option value="14"',$selection[14],'>14 - Calvados</option>
      <option value="15"',$selection[15],'>15 - Cantal</option>
      <option value="16"',$selection[16],'>16 - Charente</option>
      <option value="17"',$selection[17],'>17 - Charente-Maritime</option>
      <option value="18"',$selection[18],'>18 - Cher</option>
      <option value="19"',$selection[19],'>19 - Correze</option>
      <option value="20"',$selection[20],'>2A - Corse-du-Sud</option>
      <option value="21"',$selection[21],'>2B - Haute-Corse</option>
      <option value="22"',$selection[22],'>21 - Cote-d\'Or</option>
      <option value="23"',$selection[23],'>22 - Cotes-d\'Armor</option>
      <option value="24"',$selection[24],'>23 - Creuse</option>
      <option value="25"',$selection[25],'>24 - Dordogne</option>
      <option value="26"',$selection[26],'>25 - Doubs</option>
      <option value="27"',$selection[27],'>26 - Drome</option>
      <option value="28"',$selection[28],'>27 - Eure</option>
      <option value="29"',$selection[29],'>28 - Eure-et-Loir</option>
      <option value="30"',$selection[30],'>29 - Finistere</option>
      <option value="31"',$selection[31],'>30 - Gard</option>
      <option value="32"',$selection[32],'>31 - Haute-Garonne</option>
      <option value="33"',$selection[33],'>32 - Gers</option>
      <option value="34"',$selection[34],'>33 - Gironde</option>
      <option value="35"',$selection[35],'>34 - Herault</option>
      <option value="36"',$selection[36],'>35 - Ille-et-Vilaine</option>
      <option value="37"',$selection[37],'>36 - Indre</option>
      <option value="38"',$selection[38],'>37 - Indre-et-Loire</option>
      <option value="39"',$selection[39],'>38 - Isere</option>
      <option value="40"',$selection[40],'>39 - Jura</option>
      <option value="41"',$selection[41],'>40 - Landes</option>
      <option value="42"',$selection[42],'>41 - Loir-et-Cher</option>
      <option value="43"',$selection[43],'>42 - Loire</option>
      <option value="44"',$selection[44],'>43 - Haute-Loire</option>
      <option value="45"',$selection[45],'>44 - Loire-Atlantique</option>
      <option value="46"',$selection[46],'>45 - Loiret</option>
      <option value="47"',$selection[47],'>46 - Lot</option>
      <option value="48"',$selection[48],'>47 - Lot-et-Garonne</option>
      <option value="49"',$selection[49],'>48 - Lozere</option>
      <option value="50"',$selection[50],'>49 - Maine-et-Loire</option>
      <option value="51"',$selection[51],'>50 - Manche</option>
      <option value="52"',$selection[52],'>51 - Marne</option>
      <option value="53"',$selection[53],'>52 - Haute-Marne</option>
      <option value="54"',$selection[54],'>53 - Mayenne</option>
      <option value="55"',$selection[55],'>54 - Meurthe-et-Moselle</option>
      <option value="56"',$selection[56],'>55 - Meuse</option>
      <option value="57"',$selection[57],'>56 - Morbihan</option>
      <option value="58"',$selection[58],'>57 - Moselle</option>
      <option value="59"',$selection[59],'>58 - Nievre</option>
      <option value="60"',$selection[60],'>59 - Nord</option>
      <option value="61"',$selection[61],'>60 - Oise</option>
      <option value="62"',$selection[62],'>61 - Orne</option>
      <option value="63"',$selection[63],'>62 - Pas-de-Calais</option>
      <option value="64"',$selection[64],'>63 - Puy-de-Dome</option>
      <option value="65"',$selection[65],'>64 - Pyrenees-Atlantiques</option>
      <option value="66"',$selection[66],'>65 - Hautes-Pyrenees</option>
      <option value="67"',$selection[67],'>66 - Pyrenees-Orientales</option>
      <option value="68"',$selection[68],'>67 - Bas-Rhin</option>
      <option value="69"',$selection[69],'>68 - Haut-Rhin</option>
      <option value="70"',$selection[70],'>69 - Rhone</option>
      <option value="71"',$selection[71],'>70 - Haute-Saone</option>
      <option value="72"',$selection[72],'>71 - Saone-et-Loire</option>
      <option value="73"',$selection[73],'>72 - Sarthe</option>
      <option value="74"',$selection[74],'>73 - Savoie</option>
      <option value="75"',$selection[75],'>74 - Haute-Savoie</option>
      <option value="76"',$selection[76],'>75 - Paris</option>
      <option value="77"',$selection[77],'>76 - Seine-Maritime</option>
      <option value="78"',$selection[78],'>77 - Seine-et-Marne</option>
      <option value="79"',$selection[79],'>78 - Yvelines</option>
      <option value="80"',$selection[80],'>79 - Deux-Sevres</option>
      <option value="81"',$selection[81],'>80 - Somme</option>
      <option value="82"',$selection[82],'>81 - Tarn</option>
      <option value="83"',$selection[83],'>82 - Tarn-et-Garonne</option>
      <option value="84"',$selection[84],'>83 - Var</option>
      <option value="85"',$selection[85],'>84 - Vaucluse</option>
      <option value="86"',$selection[86],'>85 - Vendee</option>
      <option value="87"',$selection[87],'>86 - Vienne</option>
      <option value="88"',$selection[88],'>87 - Haute-Vienne</option>
      <option value="89"',$selection[89],'>88 - Vosges</option>
      <option value="90"',$selection[90],'>89 - Yonne</option>
      <option value="91"',$selection[91],'>90 - Territoire de Belfort</option>
      <option value="92"',$selection[92],'>91 - Essonne</option>
      <option value="93"',$selection[93],'>92 - Hauts-de-Seine</option>
      <option value="94"',$selection[94],'>93 - Seine-Saint-Denis</option>
      <option value="95"',$selection[95],'>94 - Val-de-Marne</option>
      <option value="96"',$selection[96],'>95 - Val-d\'Oise</option>
      <option value="97"',$selection[97],'>971 - Guadeloupe</option>
      <option value="98"',$selection[98],'>972 - Martinique</option>
      <option value="99"',$selection[99],'>973 - Guyane</option>
      <option value="100"',$selection[100],'>974 - Reunion</option>
      <option value="101"',$selection[101],'>975 - Saint-Pierre-et-Miquelon</option>
      <option value="102"',$selection[102],'>984 - Terres-australes-et-antarctiques-françaises</option>
       <option value="103"',$selection[103],'>985 - Mayotte</option>
      <option value="104"',$selection[104],'>986 - Wallis-et-Futuna</option>
      <option value="105"',$selection[105],'>987 - Polynesie-française</option>
      <option value="106"',$selection[106],'>988 - Nouvelle-Caledonie</option>
     </select> <br/> <br/>';
  }
      
  //    <!--LE FILTRE ALLERGIE EST RESERVE AUX ABONNES DE NIVEAU 2 -->
  if(VerifAbo()==2){
      for($i=1;$i<21;$i++){
		if((isset($_POST["allergie"]))&&($i==intval($_POST["allergie"],10))){
			$selection[$i]="selected";
		}else{$selection[$i]="";}
	}
      echo"Allergies : 
								<select size='1' name='allergie'>
								<option></option>
								<option value='1'",$selection[1],">Acariens</option>
								<option value='2'",$selection[2],">Arachides</option>
								<option value='3'",$selection[3],">Céleri</option>
								<option value='4'",$selection[4],">Chats</option>
								<option value='5'",$selection[5],">Crustaces</option>
								<option value='6'",$selection[6],">Fruits a coque</option>
								<option value='7'",$selection[7],">Gluten</option>
								<option value='8'",$selection[8],">Hymenopteres</option>
								<option value='9'",$selection[9],">Lactose</option>
								<option value='10'",$selection[10],">Latex</option>
								<option value='11'",$selection[11],">Lupin</option>
								<option value='12'",$selection[12],">Mollusques</option>
								<option value='13'",$selection[13],">Moutarde</option>
								<option value='14'",$selection[14],">Nickel</option>
								<option value='15'",$selection[15],">Oeufs</option>
								<option value='16'",$selection[16],">Pollen</option>
								<option value='17'",$selection[17],">Poisson</option>
								<option value='18'",$selection[18],">Sesame</option>
								<option value='19'",$selection[19],">Soja</option>
								<option value='20'",$selection[20],">Sulfites</option>								
								</select> <br/> ";	
	}	?>
						   <br><br/><br/>	
				    <input id="Valider" value="Valider mes filtres" type="submit" onclick="VerifAge()"> <br>
				 </form>
                </th>  
              </tr>
            </thead>
	</table> 
 
</div>
<div id="afficheFiltres" class="side">
    <span onclick="openNav()" id="BoutonFiltreR"><b>Voir les filtres de recherche</b></span>
  
<?php    
				//Barre de recherche pour tous les utilisateurs
				echo'<form method="POST" action="RechercheW3.php">';
                echo "<br/><div class='topnav'><input type='text' name='BarreR' placeholder='Entrez un pseudo'><button type='submit' ><img  height='25' src='loupe.png'/></button></div>";
                echo'</form>';
?>
</div>


<!-- zone profils autres utilisateurs -->
<div class="side">
    <h2>PROFILS</h2>
</div>
<!-- Affichage des 12 profils par défaut  -->
				  <?php if((!isset($_POST["ageMin"]))&&(!isset($_POST["ageMax"]))&&(!isset($_POST["lieu"]))&&(!isset($_POST["allergie"]))&&(!isset($_POST["BarreR"]))){  ?>
				  <?php
				  // selection des profils de niveau 2
				 for($i=0;$i<5;$i++){
					$boule=1;
				while($boule!=0){
					 $boule=0;
					 
					 $_SESSION["Profil"] = TrouveLigne(2); 
					for($k=0;$k<$i;$k++){
						if($_SESSION["Profil"]==$Verification[$k]){
							 $boule=$boule+1;				
						}
					}
					if(VerifCo()==1){
					if(((ChercheBDD("orientation",$_SESSION["Profil"])!=$_SESSION["sexe"])&&(ChercheBDD("orientation",$_SESSION["Profil"])!=0))||((ChercheBDD("sexe",$_SESSION["Profil"])!=$_SESSION["orientation"])&&($_SESSION["orientation"]!=0))){
							 $boule=$boule+1;				
					}
					}
				 }
				 $Verification[$i] = $_SESSION["Profil"];
				 
				 // affichage des cartes profil
				 echo "<div class='column'>";
					echo "<div class='card'>";
					echo "<center><img src='".ChercheBDD("Photo1",$_SESSION['Profil'])."' alt='Logo' style='width:35%;'></center>";
					echo "<div class='container'>";
						echo "<center>";
						$co = VerifCo();
						echo '<br/><b><input type="button" class="PseudonymesAutresUtilisateursR" onclick="enregistrerPseudoDansFichier('.$i.','.$co.');" value="'.ChercheBDD("Pseudo",$_SESSION["Profil"]).'" /></b> <br/><br/>';
						echo "<p class='title'><b>"; 
						echo CalculAge(ChercheBDD("DateNaissance", $_SESSION['Profil'])); echo " ans, "; AfficheDepartement(ChercheBDD("lieu",$_SESSION["Profil"])); echo"</b></p>";
						echo"<p><b>";AfficheSexe(ChercheBDD("sexe",$_SESSION["Profil"])); echo", ";  AfficheOrientation(ChercheBDD("orientation",$_SESSION["Profil"])); echo"</b></p>";
						echo "<p><b>";
						echo"<b> Allergie(s) : <div style='color : #E6362E;'>";
						AfficheAllergie(ChercheBDD("Allergie1", $_SESSION['Profil']));
						AfficheAllergie(ChercheBDD("Allergie2", $_SESSION['Profil']));
						AfficheAllergie(ChercheBDD("Allergie3", $_SESSION['Profil']));
						echo "</div></b></p>";
						echo "<p class='Messagerie' ></p> "; 						
						echo "</div>
						<br/>  
						<br/> 
						<br/>
					</center>
					</div>
				  </div>
				  </div>";
				}
				
				 ?>
				  <?php
				  // selection des profils de niveau 1
				 for($i=0;$i<4;$i++){
				$boule=1;
					while($boule!=0){
					 $boule=0;
					 $_SESSION["Profil"] = TrouveLigne(1); 
					for($k=0;$k<$i;$k++){
						if($_SESSION["Profil"]==$Verification[$k]){
							 $boule=$boule+1;				
						}
					}
					if(VerifCo()==1){
					if(((ChercheBDD("orientation",$_SESSION["Profil"])!=$_SESSION["sexe"])&&(ChercheBDD("orientation",$_SESSION["Profil"])!=0))||((ChercheBDD("sexe",$_SESSION["Profil"])!=$_SESSION["orientation"])&&($_SESSION["orientation"]!=0))){
							 $boule=$boule+1;				
					}
					}
				 }
				 $Verification[$i] = $_SESSION["Profil"];
					
				 $j=$i+5;
				 // affichage 
				  echo "<div class='column'>";
					echo "<div class='card'>";
					echo "<center><img src='".ChercheBDD("Photo1",$_SESSION['Profil'])."' alt='Logo' style='width:35%;'></center>";
					echo "<div class='container'>";
						echo "<center>";
						$co = VerifCo();
						echo '<br/><b><input type="button" class="PseudonymesAutresUtilisateursR" onclick="enregistrerPseudoDansFichier('.$j.','.$co.');" value="'.ChercheBDD("Pseudo",$_SESSION["Profil"]).'" /></b> <br/><br/>';///echo dans echo !!!!
						echo "<p class='title'><b>"; 
						echo CalculAge(ChercheBDD("DateNaissance", $_SESSION['Profil'])); echo " ans, "; AfficheDepartement(ChercheBDD("lieu",$_SESSION["Profil"])); echo"</b></p>";
						echo"<p><b>";AfficheSexe(ChercheBDD("sexe",$_SESSION["Profil"])); echo", ";  AfficheOrientation(ChercheBDD("orientation",$_SESSION["Profil"])); echo"</b></p>";
						echo "<p><b>";
						echo"<b> Allergie(s) : <div style='color : #E6362E;'>";
						AfficheAllergie(ChercheBDD("Allergie1", $_SESSION['Profil']));
						AfficheAllergie(ChercheBDD("Allergie2", $_SESSION['Profil']));
						AfficheAllergie(ChercheBDD("Allergie3", $_SESSION['Profil']));
						echo "</div></b></p>";
						echo "<p class='Messagerie' ></p> "; 
						echo "</div>
						<br/>  
						<br/> 
						<br/>
					</center>
					</div>
				  </div>
				  </div>";
				}
					//selection des profils de niveau 0
				 for($i=4;$i<7;$i++){
				$boule=1;
					while($boule!=0){
					 $boule=0;
					 $_SESSION["Profil"] = TrouveLigne(0); 
					for($k=3;$k<$i;$k++){
						if($_SESSION["Profil"]==$Verification[$k]){
							 $boule=$boule+1;				
						}
					}
					if(VerifCo()==1){
					  if(((ChercheBDD("orientation",$_SESSION["Profil"])!=$_SESSION["sexe"])&&(ChercheBDD("orientation",$_SESSION["Profil"])!=0))||((ChercheBDD("sexe",$_SESSION["Profil"])!=$_SESSION["orientation"])&&($_SESSION["orientation"]!=0))){
							 $boule=$boule+1;				
					  }
					}
				 }
				 $Verification[$i] = $_SESSION["Profil"];
					
				 $j=$i+5;
				 //affichage
				  echo "<div class='column'>";
					echo "<div class='card'>";
					echo "<center><img src='".ChercheBDD("Photo1",$_SESSION['Profil'])."' alt='Logo' style='width:35%;'></center>";
					echo "<div class='container'>";
						echo "<center>";
						$co = VerifCo();
						echo '<br/><b><input type="button" class="PseudonymesAutresUtilisateursR" onclick="enregistrerPseudoDansFichier('.$j.','.$co.');" value="'.ChercheBDD("Pseudo",$_SESSION["Profil"]).'" /></b> <br/><br/>';
						echo "<p class='title'><b>"; 
						echo CalculAge(ChercheBDD("DateNaissance", $_SESSION['Profil'])); echo " ans, "; AfficheDepartement(ChercheBDD("lieu",$_SESSION["Profil"])); echo"</b></p>";
						echo"<p><b>";AfficheSexe(ChercheBDD("sexe",$_SESSION["Profil"])); echo", ";  AfficheOrientation(ChercheBDD("orientation",$_SESSION["Profil"])); echo"</b></p>";
						echo "<p><b>";
						echo"<b> Allergie(s) : <div style='color : #E6362E;'>";
						AfficheAllergie(ChercheBDD("Allergie1", $_SESSION['Profil']));
						AfficheAllergie(ChercheBDD("Allergie2", $_SESSION['Profil']));
						AfficheAllergie(ChercheBDD("Allergie3", $_SESSION['Profil']));
						echo "</div></b></p>";
						echo "</div>
						<br/>  
						<br/> 
						<br/>
					</center>
					</div>
				  </div>
				  </div>";
				}
				 }else if(isset($_POST["BarreR"])){   //recherche du profil à partir de la barre de recherche
   
    $TabProf = TrouveProfilBarreR($_POST["BarreR"]);
    for($i=0;$i<sizeof($TabProf);$i++){
           echo "<div class='column'>";
                    echo "<div class='card'>";
                    echo "<center><img src='".ChercheBDD("Photo1",$TabProf[$i])."' alt='Logo' style='width:35%;'></center>";
                    echo "<div class='container'>";
                        echo "<center>";
                        $co = VerifCo();
                        echo '<br/><b><input type="button" class="PseudonymesAutresUtilisateursR" onclick="enregistrerPseudoDansFichier('.$i.','.$co.');" value="'.ChercheBDD("Pseudo",$TabProf[$i]).'" /></b> <br/><br/>';
                        echo "<p class='title'><b>";
                        echo CalculAge(ChercheBDD("DateNaissance", $TabProf[$i])); echo " ans,"; AfficheDepartement(ChercheBDD("lieu",$TabProf[$i])); echo"</b></p>";
                        echo"<p><b>";AfficheSexe(ChercheBDD("sexe",$TabProf[$i])); echo",";  AfficheOrientation(ChercheBDD("orientation",$TabProf[$i])); echo"</b></p>";
                        echo "<p><b>";
                        echo"<b> Allergie(s) : <div style='color : #E6362E;'>";
						AfficheAllergie(ChercheBDD("Allergie1", $TabProf[$i]));
						AfficheAllergie(ChercheBDD("Allergie2", $TabProf[$i]));
						AfficheAllergie(ChercheBDD("Allergie3", $TabProf[$i]));
						echo "</div></b></p>";
                        
                        if ( VerifAboPAU($TabProf[$i])>=1 ){
							echo "<p class='Messagerie' ></p> "; 
						}	
                        echo "</div>
                        <br/>
                        <br/>
                        <br/>
                    </center>
                    </div>
                  </div>
                  </div>";
    }
    if(sizeof($TabProf)==0){
        echo "<div id='NivActu'><br/><b><center>Désolé, aucun profil ne correspond à votre recherche !</center></b><br/></div>";
    }
}else{
		//Sécurité Age min < Age max
		if((isset($_POST["ageMin"]))&&(isset($_POST["ageMax"]))){
			if(($_POST["ageMin"]!="")&&($_POST["ageMax"]!="")){
				if($_POST["ageMin"]>$_POST["ageMax"]){ //inversion des valeurs
			$tmp = $_POST["ageMin"];
			$_POST["ageMin"] = $_POST["ageMax"];
			$_POST["ageMax"]=$tmp;
				}
			}
		}
		// Recherche des profils suivant les filtres 
				 $colette = 0; 
				 $i=0;
				 if(isset($_POST["allergie"])){
				 $tabGens = TrouveProfilFiltres(2,$_POST["lieu"],$_POST["allergie"]);		//tableau de pseudos.
				}else{
				 $tabGens = TrouveProfilFiltres(2,$_POST["lieu"],"");		//tableau de pseudos.
				}
				 $colette = ValideProfilFiltres($tabGens,$i,$colette,$_POST["ageMin"],$_POST["ageMax"]);
				
		$i=0;
		 if(isset($_POST["allergie"])){
				 $tabGens = TrouveProfilFiltres(1,$_POST["lieu"],$_POST["allergie"]);		//tableau de pseudos.
			}else{
				 $tabGens = TrouveProfilFiltres(1,$_POST["lieu"],"");		//tableau de pseudos.
			}
		$colette = ValideProfilFiltres($tabGens,$i,$colette,$_POST["ageMin"],$_POST["ageMax"]);
		
		$i=0;
		 if(isset($_POST["allergie"])){
				 $tabGens = TrouveProfilFiltres(0,$_POST["lieu"],$_POST["allergie"]);		//tableau de pseudos.
				}else{
				 $tabGens = TrouveProfilFiltres(0,$_POST["lieu"],"");		//tableau de pseudos.
				}
		$colette = ValideProfilFiltres($tabGens,$i,$colette,$_POST["ageMin"],$_POST["ageMax"]);
			
if($colette==0){
				echo "<div id='NivActu'><br/><b><center>Désolé, aucun profil ne correspond à votre recherche !</center></b><br/></div>"; 
}			
 } ?>	


<!-- Pied de page -->   
<div class="footer">
  <p><i>ALOVEGIE</i>, create by CHEVRIER Chleo, GONTIE Margaux, JANELA CAMEIJO Alice, MARTIN Teo, CPI2 Groupe 5</p>
</div>        

</body>
</html>



