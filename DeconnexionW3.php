<!DOCTYPE html>
<?php
session_start();
?>
<html lang="fr">
<head>
<title>DECONNEXION</title>
<meta charset="UTF-8">
<link rel="icon" href="logo3.jpg" />
<link rel="stylesheet" href="DeconnexionW3.css" />
<?php include "BddInfoRecherche.php"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript">
	
//fonction qui verifie si tu es connecté si NON te renvoie dans  l'accueil	
function Sercurite(connection){
	if (connection==0){
		alert("vous n'avez rien à faire ici :/");
		window.location.href="AccueilW3.php";
	}
	
}
</script>
</head>


<body id="DeconnexionW3" style="background-color: #FFC7C7;" onload="Securite(<?php echo VerifCo();?>);">


<!-- En-tête du site -->
<div class="header">
  <h1>A<span id="Love"><i>LOVE</i></span>GIE</i></h1>
  <p style="font-size:20px;"><b>Fini les allergies, rencontrez enfin l'amour de votre vie !</b></p>
</div>


<!-- Onglet -->
<div class="navbar">
  <a id="BoutonRemark" href="AccueilW3.php" class="right"><b>ACCUEIL</b></a>
</div>

<!-- Bloc de déconexion -->  
   <table id="BlocDeconnexion" style="border: 1px solid #E6362E; margin: 0; position: absolute; left: 41%; top: 47%; width: 380px; height: 250px; background-color : white;">
		<thead>
              <tr>
                <th>
					<br/>
					<b><span id="Deconnecte">Vous avez bien été déconnecté</span></b>
					<br/>
					<br/>
					<?php
						ModifierProfil($_SESSION["pseudo"],"co",0);
						session_destroy();	 		
					?>
					Nous espérons vous revoir très vite sur <span id="A">A<span id="Love"><i>LOVE</i></span>GIE</span></b> !
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








