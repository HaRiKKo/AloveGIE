<!DOCTYPE html>
<?php
session_start();
?>
<html lang="fr">
<head>
<title>MODIFIER MON PROFIL GENERAL</title>
<meta charset="UTF-8">
<link rel="icon" href="logo3.jpg" />
<link rel="stylesheet" href="ModifierProfilGeneral.css" />
<?php include "BddInfoRecherche.php"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 25%;
  top: 20%;
  width: 50%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(241, 241, 241); /* Fallback color */
  background-color: rgba(241, 241, 241, 0.4); /* Black w/ opacity */
  padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5px auto; /* 15% from the top and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}
/* Add Zoom Animation */
.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

/* Style the body */
body{
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
}

/*-------------------------------------------------------------------------------------------------------------------------------------*/

/* En tete, logo et titre */
.header {
  padding: 15px;
  text-align: center;
  color: #333;
  background-image : url("Champ.jpg");
  background-color : #FFE6E6;
  background-attachment : fixed;
  background-position : center top;
  background-size: 20%;
  background-repeat: repeat;
  
}

.header h1 {
  font-size: 45px;
}

#Love{
	color: #E6362E;
}

#logo{
	top: 30%;
	left:50%;	
}

/*-------------------------------------------------------------------------------------------------------------------------------------*/


/* Style barre de navigation */
.navbar {
  overflow: hidden;
  background-color: #FFA8A8;
}

.navbar a {
  float: left;
  display: block;
  color: white;
  text-align: center;
  padding: 14px 20px;
  text-decoration: none;
  border: solid 1px #E6362E;
}

.navbar a.right {
  float: right;
}

#BoutonRemark{
	background-color: #E6362E;
}

.navbar a:hover {
  //background-color: #ddd;
  background-color: #FFA8A8;
  color: black;
}

/*-------------------------------------------------------------------------------------------------------------------------------------*/

/* Bloc de modification du profil vu par l'administrateur*/
* {box-sizing: border-box}

/* Full-width input fields */
  input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for all buttons */
button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

button:hover {
  opacity:1;
}

/* Add padding to container elements */
.container {
  padding: 16px;
}

/* Clear floats */
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}

.BoutonFinal{
	color: #E6362E;
}

/*-------------------------------------------------------------------------------------------------------------------------------------*/

/* Pieds de page */
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   background-color: #E6362E;
   color: white;
   text-align: center;
}

/* Responsive layout - when the screen is less than 700px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 700px) {
  .row {   
    flex-direction: column;
  }
}

/* Responsive layout - when the screen is less than 400px wide, make the navigation links stack on top of each other instead of next to each other */
@media screen and (max-width: 400px) {
  .navbar a {
    float: none;
    width: 100%;
  }
}
</style>

<script type='text/javascript'>
	
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
	</script>
</head>


<body id="ModifierMonProfilGenW3" onload="choseAFaireAuChargementDeLaPageMPG(<?php if ( isset($_POST['Pseudo']) ){ echo ChercheBDD("Admin", $_SESSION['pseudo']); } else {echo "0";} ?>);" >


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
  <a href="MonProfilW3.php" class="right"><b>Mon Profil</b></a>
  <a href="DeconnexionW3.php" class="right"><b>Deconnexion</b></a>
  <a id="BoutonRemark" href="AccueilW3.php" class="right"><b>ACCUEIL</b></a>
</div>

<?php $utilisateur = $_POST['Pseudo'];
//mettre le post pseudo et refaire comme dans messagrerie apres envoie du formulaire
	?>

<!-- Bloc de modifications -->        
    <table id="BlocParametres" style="border: 1px solid #E6362E; width: 500px; height: 500px; margin: 0; position: absolute; left: 33%; background-color : white;">
        <thead>
                <tr>
                <th>
                    <b><span id="Modifier">MODIFIER LE PROFIL DE <span style="color:#E6263E;"><?php echo $utilisateur; ?></span> <img width="35" src="ParamProfil.png"/></span></b>
                    <br/>
                    <br/>
                    <br/>
                <?php    

                    If(isset($_POST['retour'])){    //si formulaire envoyé; on enregistre les modifications

                        if(isset($_FILES['photo']['name'][0])){
                        ModifierProfil($utilisateur,"Photo1",$_FILES['photo']['name'][0]);
                        }
                        if(isset($_FILES['photo']['name'][1])){
                        ModifierProfil($utilisateur,"Photo2",$_FILES['photo']['name'][1]);
                        }
                        if(isset($_FILES['photo']['name'][2])){
                        ModifierProfil($utilisateur,"Photo3",$_FILES['photo']['name'][2]);
                        }

                        
                        if((isset($_POST["attirancef"]))&&(!isset($_POST["attiranceh"]))){
                           ModifierProfil($utilisateur,"orientation",2);
                        }else if((isset($_POST["attiranceh"]))&&(!isset($_POST["attirancef"]))){
                             ModifierProfil($utilisateur,"orientation",1);
                            }else{ ModifierProfil($utilisateur,"orientation",0);}                                                    
			echo"Modifications effectuées avec succes :) <p><a href='./PageAdminW3.php' style='color:#E6263E;'>Retourner à la page administrateur</a></p> ";   
   
			if($_POST["lieu"]!=ChercheBDD("Lieu",$utilisateur)){     //Si on a modifier la valeur on change dans BDD       
            ModifierProfil($utilisateur,"Lieu",$_POST["Lieu"]);
            }  
            if($_POST["prenom"]!=ChercheBDD("Prenom",$utilisateur)){            
            ModifierProfil($utilisateur,"Prenom",$_POST["prenom"]);
            }   
            if($_POST["nom"]!=ChercheBDD("Nom",$utilisateur)){            
            ModifierProfil($utilisateur,"Nom",$_POST["nom"]);
            }   
            if($_POST["abonne"]!=ChercheBDD("Abonnement",$utilisateur)){            
            ModifierProfil($utilisateur,"Abonnement",$_POST["abonne"]);
            }    
            if($_POST["mail"]!=ChercheBDD("Email",$utilisateur)){            
            ModifierProfil($utilisateur,"Email",$_POST["mail"]);
            }   
            if($_POST["description"]!=ChercheBDD("Description",$utilisateur)){            
            ModifierProfil($utilisateur,"Description",$_POST["description"]);
            }   
            if($_POST["defauts"]!=ChercheBDD("QualitesDefauts",$utilisateur)){            
            ModifierProfil($utilisateur,"QualitesDefauts",$_POST["defauts"]);
            }   
            if($_POST["passions"]!=ChercheBDD("Passions",$utilisateur)){            
            ModifierProfil($utilisateur,"Passions",$_POST["passions"]);
            }   
            if($_POST["phobies"]!=ChercheBDD("Phobies",$utilisateur)){            
            ModifierProfil($utilisateur,"Phobies",$_POST["phobies"]);
            }   
            if($_POST["piredate"]!=ChercheBDD("PireDate",$utilisateur)){            
            ModifierProfil($utilisateur,"PireDate",$_POST["piredate"]);
            }   
            if($_POST["typeAllergie"][0]!=ChercheBDD("Allergie1",$utilisateur)){            
            ModifierProfil($utilisateur,"Allergie1",$_POST["typeAllergie"][0]);
            }   
            if($_POST["typeAllergie"][1]!=ChercheBDD("Allergie2",$utilisateur)){            
            ModifierProfil($utilisateur,"Allergie2",$_POST["typeAllergie"][1]);
            }   
            if($_POST["typeAllergie"][2]!=ChercheBDD("Allergie3",$utilisateur)){            
            ModifierProfil($utilisateur,"Allergie3",$_POST["typeAllergie"][2]);
            }
            if($_POST["niveauAllergie"][0]!=ChercheBDD("NiveauAllergie1",$utilisateur)){            
            ModifierProfil($utilisateur,"NiveauAllergie1",$_POST["niveauAllergie"][0]);
            }   
            if($_POST["niveauAllergie"][1]!=ChercheBDD("NiveauAllergie2",$utilisateur)){            
            ModifierProfil($utilisateur,"NiveauAllergie2",$_POST["niveauAllergie"][1]);
            }   
            if($_POST["niveauAllergie"][2]!=ChercheBDD("NiveauAllergie3",$utilisateur)){            
            ModifierProfil($utilisateur,"NiveauAllergie3",$_POST["niveauAllergie"][2]);
            }    
           
            CalculNbAllergies(ChercheBDD("Allergie1",$utilisateur),ChercheBDD("Allergie2",$utilisateur));
            
             }else{            //On affiche le formulaire de modification
                   
                        echo "<form action='ModifierProfilGeneral.php' method='POST' enctype='multipart/form-data'>";                                            
                           
                           $valeur=ChercheBDD("Prenom",$utilisateur);
                           echo"Prenom : <input type='text' name='prenom' value='$valeur' /> <br/>";
                           $valeur=ChercheBDD("Nom",$utilisateur);
                           echo"Nom : <input type='text' name='nom' value='$valeur' /> <br/>";
                           $valeur=ChercheBDD("Abonnement",$utilisateur);
                           echo"Abonnement : <input type='number' name='abonne' value='$valeur' /> <br/><br/>";
                            $valeur=ChercheBDD("Email",$utilisateur);
                            echo"Adresse e-mail : <input type='email' name='mail' value='$valeur' /> <br/><br/>";
                            echo"Attirance :";
                            if(ChercheBDD("orientation",$utilisateur)==2){
                            echo" <input name='attirancef' type='checkbox' checked value='2'/> Femmes ";
                            echo" <input name='attiranceh' type='checkbox'  value='1'/> Hommes ";
                            }else if(ChercheBDD("orientation",$utilisateur)==1){
                            echo" <input name='attirancef' type='checkbox'  value='2'/> Femmes ";
                            echo" <input name='attiranceh' type='checkbox' checked value='1'/> Hommes ";
                            }else if(ChercheBDD("orientation",$utilisateur)==0){
                            echo" <input name='attirancef' type='checkbox' checked value='2'/> Femmes ";
                            echo" <input name='attiranceh' type='checkbox' checked value='1'/> Hommes ";}
                            else{echo" <input name='attirancef' type='checkbox'  value='2'/> Femmes ";
                            echo" <input name='attiranceh' type='checkbox'  value='1'/> Hommes ";}
                            for($i=0;$i<107;$i++){
                                if($i==intval(ChercheBDD("Lieu",$utilisateur),10)){
                                    $selection[$i]="selected";
                                }else{$selection[$i]="";}
                            }
                            
                            echo'<br/> <br/><br/>   Département : <select name="lieu">
                           
      <option value="01"',$selection[1],'>01 - Ain</option>
      <option value="02"',$selection[2],'>02 - Aisne</option>
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
      <option value="105"',$selection[105],'>987 - Polynesie-fraçeaise</option>
      <option value="106"',$selection[106],'>988 - Nouvelle-Caledonie</option>
     </select> <br/>';
     
       $valeur=ChercheBDD("Description",$utilisateur);
                            echo"<br/><br/>Description : <input type='text' size='40' name='description' value='$valeur' /> <br/>";
                            $valeur=ChercheBDD("QualitesDefauts",$utilisateur);
                            echo"Défauts : <input type='text' size='40' name='defauts' value='$valeur' /> <br/>";           
                            $valeur=ChercheBDD("Passions",$utilisateur);
                            echo"Passions : <input type='text' size='40' name='passions' value='$valeur' /> <br/>";                           
                            $valeur=ChercheBDD("Phobies",$utilisateur);
                            echo"Phobies : <input type='text' size='40' name='phobies' value='$valeur' /> <br/>";                       
                            $valeur=ChercheBDD("PireDate",$utilisateur);
                            echo"Pire date : <input type='text' size='40' name='piredate' value='$valeur' /> <br/> <br/>";   
                           
                           
                            for($i=1;$i<21;$i++){
                                if($i==intval(ChercheBDD("Allergie1",$utilisateur),10)){
                                    $selection[$i]="selected";
                                }else{$selection[$i]="";}
                            }
                           
                            echo"Allergie 1 :
                                <select size='1' name='typeAllergie[0]'>
                                <option value='1'",$selection[1],">Acariens</option>
                                <option value='2'",$selection[2],">Arachides</option>
                                <option value='3'",$selection[3],">Celeri</option>
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
                                $valeur=ChercheBDD("NiveauAllergie1",$utilisateur);   
                                echo "<input name='niveauAllergie[0]' type='range' min='1' max='5' value='$valeur'>";       
                                echo "<br/> <br/>";
                                
                                  
                                
                                for($k=0;$k<21;$k++){
                                if($k==intval(ChercheBDD("Allergie2",$utilisateur),10)){
                                    $selection[$k]="selected";
                                }else{$selection[$k]="";}
                                }
                                echo"Allergie 2 :
                                <select size='1' name='typeAllergie[1]'>
                                <option value=''0",$selection[0],"></option>
                                <option value='1'",$selection[1],">Acariens</option>
                                <option value='2'",$selection[2],">Arachides</option>
                                <option value='3'",$selection[3],">Celeri</option>
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
                                $valeur=ChercheBDD("NiveauAllergie2",$utilisateur);   
                                echo "<input name='niveauAllergie[1]' type='range' min='0' max='5' value='$valeur'>";
                                echo "<br/> <br/>";
                           
                          for($k=0;$k<21;$k++){
                                if($k==intval(ChercheBDD("Allergie3",$utilisateur),10)){
                                    $selection[$k]="selected";
                                }else{$selection[$k]="";}
                                }
                                echo"Allergie 3 :
                                <select size='1' name='typeAllergie[2]'>
                                <option value=''0",$selection[0],"></option>
                                <option value='1'",$selection[1],">Acariens</option>
                                <option value='2'",$selection[2],">Arachides</option>
                                <option value='3'",$selection[3],">Celeri</option>
                                <option value='4'",$selection[4],">Chats</option>
                                <option value='5'",$selection[5],">Crustacés</option>
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
                                $valeur=ChercheBDD("NiveauAllergie3",$utilisateur);   
                                echo "<input name='niveauAllergie[2]' type='range' min='0' max='5' value='$valeur'>";
                                echo "<br/> <br/>"; 
                           
                            echo" <br/>";               
                            echo "Ajouter une photo de profil : <input type='file' name='photo[]' multiple accept='image/*'  />";           
                            echo "<input type='hidden' name='retour' value='1'/>
                            <center><br/><br/><input type='hidden' name='retour' value='1'/> <input type='hidden' name='Pseudo' value='".$_POST["Pseudo"]."'/><input type='submit' class='BoutonFinal' value='Enregistrer mes modifications' /></center> <br/>";
                        }
                        ?>
                            </form>
                    <br/>
                    <br/>
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
