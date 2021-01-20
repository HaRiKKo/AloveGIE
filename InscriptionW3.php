<!DOCTYPE html>
<?php
session_start();
?>
<html lang="fr">
<head>
<title>INSCRIPTION</title>
<meta charset="UTF-8">
<link rel="icon" href="logo3.jpg" />
<link rel="stylesheet" href="InscriptionW3.css" />
<?php include "BddInfoRecherche.php"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript">
	
//fonction qui verifie si tu es connecté si OUI te renvoie dans l'accueil
function Securite(connection){
	if (connection!=0){
		alert("vous n'avez rien à faire ici :/");
		window.location.href="AccueilW3.php";
	}
}
</script>
</head>


<body id="InscriptionW3" style="background-color: #FFC7C7;" onload="Securite(<?php echo VerifCo();?>);">


<!-- En-tête du site -->
<div class="header">
  <h1>A<span id="Love"><i>LOVE</i></span>GIE</i></h1>
  <p style="font-size:20px;"><b>Fini les allergies, rencontrez enfin l'amour de votre vie !</b></p>
</div>


<!-- Onglet -->
<div class="navbar">
  <a id="BoutonRemark" href="AccueilW3.php" class="right"><b>ACCUEIL</b></a>
</div>


<!-- Bloc d'inscription -->  
    <table id="BlocInscription" style="border: 1px solid #E6362E;  margin: 0; position: absolute; left: 38%; width: 485px; background-color : white;">
        <thead>
              <tr>
                <th>
                    <b><h2><span id="Inscrivez">Inscrivez-vous</span></h2></b>
                    <br/>
                    <br/>
                    <br/>
<?php
$boule = 0;    
$message = "";
    If(isset($_POST['retour'])){        //si formulaire envoyé    
    
    $test = ChercheBDD("Pseudo",$_POST["pseudo"]);
        if($test==""){        //si le pseudo unique
            if(isset($_POST["sexe"])){    //si tu as entré ton sexe
                if(strlen($_POST['mdp'])>=8){ //si mdp assez long
                    if($_POST['mdp']==$_POST['remdp']){    //si mdp identiques
                        echo"<span style='color:#E6263E;'>Incription terminée !</span><br/><br/>Complétez votre profil <a href='./ModifierMonProfilW3.php' style='color : gold;'>ici</a><br/><br/>";                            
                                if($_POST["sexe"]=="homme"){
                                $sexe = 1;    
                                }else if($_POST["sexe"]=="femme"){
                                $sexe = 2;
                                }else {
                                $sexe = 0;
                                }    
                                NouveauProfil($_POST["prenom"],$_POST["nom"],$_POST["pseudo"],$_POST["mdp"],$_POST["DateNaissance"],$sexe,0);	//Crée le profil dans la BDD
                                InitSession($_POST["pseudo"]);    //Initialise les variables de session == Connecte l'utilisateur        
            
                        }else{    //si mdp pas identiques
                                $message = "<p style='color : red;'>Les mots de passe ne sont pas identiques <br/> </p>";
                                $boule=1;
                        }    
                    }else{  //si mdp trop court
                            $message = "<p style='color : red;'>Le mot de passe est trop court <br/></p>".$message;
                            $boule=1;
                    }
            }else{//si sexe non choisi
                $message = "<p style='color : red;'>Merci d'indiquer votre sexe <br/></p>".$message;
                $boule=1;
            }
            
        }else{//Si pseudo pas unique
            $message = "<p style='color : red;'>Ce pseudo existe déjà ! Vous devez en choisir un autre. <br/></p>".$message;
            $boule=1;
        }
    }else{//si le formulaire n'a pas encore été envoyé
        
        echo"<form action='InscriptionW3.php' method='POST'>";    
        echo"Prénom : <input type='text' id='Prenom' name='prenom' required /> <br/>";
        echo"Nom : <input type='text' id='Nom' name='nom' required /> <br/>";
        echo'Sexe :';
                    echo'<input name="sexe" type="radio" value="femme"/> Femme'; 
                    echo'<input name="sexe" type="radio" value="homme"/> Homme'; 
        $date=date('Y-m-d');
        $datemax = explode('-',$date);
        $datemax[0]=date('Y')-18;    
        echo '<br/><br/><br/> Date de naissance <input name="DateNaissance" type="date" max="'.$datemax[0].'-'.$datemax[1].'-'.$datemax[2].'" required/>';        
            echo"<br/><br/><br/> Pseudo : <input type='text' id='Pseudo' name='pseudo' required/> <br/>";
            echo'Mot de passe (8 caractères) : <input type="password" id="Mot_de_passe" name="mdp" required /> <br/>';
            echo'Confirmer le mot de passe : <input type="password" name="remdp" required/>';
            echo'<input type="hidden" name="retour" value="1"/> <input type="submit" id="BoutonFinal" value="S inscrire" /> <br/> <br/> <br/> <br/> <br/>';
            echo'</form>';
    }    
    
    If($boule==1){    //si une condition n'est pas respectée
    //affiche message d'erreur + formulaire     
    echo $message;
    echo"<form action='InscriptionW3.php' method='POST'>";    
        $valeur=$_POST["prenom"];
        echo"Prénom : <input type='text' id='Prenom' name='prenom' value='$valeur' /> <br/>";
        
        $valeur=$_POST["nom"];
        echo"Nom : <input type='text' id='Nom' name='nom' value='$valeur'/> <br/>";
        
        echo'Sexe :';
                    if((isset($_POST["sexe"]))&&($_POST["sexe"]=="femme")){
                    echo'<input name="sexe" type="radio" value="femme" checked/> Femme'; 
                    }else{
                    echo'<input name="sexe" type="radio" value="femme"/> Femme'; 
                    }
                    if((isset($_POST["sexe"]))&&($_POST["sexe"]=="homme")){
                    echo'<input name="sexe" type="radio" value="homme" checked/> Homme'; 
                    }else{
                    echo'<input name="sexe" type="radio" value="homme"/> Homme'; 
                    }
        $date=date('Y-m-d');
        $datemax = explode('-',$date);
        $datemax[0]=date('Y')-18;    
        echo '<br/><br/><br/> Date de naissance <input required name="DateNaissance" type="date" max="'.$datemax[0].'-'.$datemax[1].'-'.$datemax[2].'"/>';                    
            $valeur=$_POST["pseudo"];
            echo"<br/><br/>Pseudo : <input type='text' id='Pseudo' name='pseudo' value='$valeur'/> <br/>";
            echo'Mot de passe (8 caractères) : <input type="password" id="Mot_de_passe" name="mdp" /> <br/>';
            echo'Confirmer le mot de passe : <input type="password" name="remdp" />';
            echo'<input type="hidden" name="retour" value="1"/> <input type="submit" id="BoutonFinal" value="S inscrire" />  <br/> <br/> <br/> <br/> <br/>';
            echo'</form>';
    }
 ?>        
                    </th>  
              </tr>
            </thead>
    </table>
    


<!-- Pieds de page -->   
<div class="footer">
  <p><i>ALOVEGIE</i>, create by CHEVRIER Chleo, GONTIE Margaux, JANELA CAMEIJO Alice, MARTIN Teo, CPI2 Groupe 5</p>
</div>        

</body>
</html>








