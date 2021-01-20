
<!--securiter du site : si tu as entre le lien de la page on te renvoi dans l'accueil-->
<script type="text/javascript"> 
	alert("vous n'avez rien à faire ici :/");
	window.location.href="AccueilW3.php";
</script>

<!-- En-tête du site -->
<div class="header">
  <h1>A<span id="Love"><i>LOVE</i></span>GIE</i></h1>
  <p style="font-size:20px;"><b>Fini les allergies, rencontrez enfin l'amour de votre vie !</b></p>
</div>


<!-- Onglets -->
<div id='listeOnglet' class="navbar"> 
  <a href="RechercheW3.php" class="right"><b>Autres Profils</b></a>
  <a href="DeconnexionW3.php" class="right"><b>Deconnexion</b></a>
  <a href="MonProfilW3.php" class="right"><b>Mon profil</b></a>  
  <a id="BoutonRemark" href="AccueilW3.php" class="right"><b>ACCUEIL</b></a>
</div>


<!-- Zone de souscription de l'abonnement -->
<?php

	if($_POST['Niveau']=='Niveau1'){
	
		echo"<table id='commandePP'>
				<thead>
					<tr> <th> Commercant : ILOVEGIE </th> </tr> 
					<tr> <th> Reférence : E0123456789 </th> </tr> 
					<tr> <th> Montant : 15.95 Euros </th> </tr> 
				</thead>
		
		</table>
		";		
	}

	if($_POST['Niveau']=='Niveau2'){
		
		echo"<table id='commandePP'>
				<thead>
					<tr> <th> Commercant : ALOVEGIE </th> </tr>
					<tr> <th> Reférence : E0123456789 </th> </tr>
					<tr> <th> Montant : 29.99 Euros </th> </tr>
				</thead>
		
		</table>
		";		
	}
?>	
<div class='containerPP'>
		<div style='text-align:center;'>
		<h2 style='color: #E6362E;'>Souscrivez un abonnement</h2>
		</div>

		<div class='rowPP'>
		<center>
			
			<div class='columnPP'>
			<b>Vous vous apprêtez à souscrire un abonnement de <span style="color:#E6263E;"> <?php echo $_POST['Niveau'];?> </span></b> 
			<br><img src='Paye.png' style='width:40%'>
			</div>
    
			
			<form id='formulairePP' method='POST' action='RetourAccueilW3.php' >
				<div class='columnPP'>	
					<br/>
					<fieldset>
					<br/>
					<label for='fname'><b>Moyen de paiement</b> : </label>
						<select required>
							<option>PayPal</option>
							<option>Visa</option>
							<option>Master Card</option>
						</select>
					</br></br>
					<label for='subject'><b>Numéro de la carte</b> :</label>
					<input type='number' name='numCard' id='numCardPP' min='1000000000000000' max='9999999999999999' placeholder='Your card number...' required/>
					</br></br>
					<?php 
					$date=date('Y-m-d');
					$datemin = explode('-',$date);
					 ?>
					<label for='subject'><b>Date d expiration</b> :</label>
					<?php echo "<input type='date' name='dateExpiration' id='dateExpirationPP' min='".$datemin[0]."-".$datemin[1]."-".$datemin[2]."' required/>"; ?>
					</br></br>
					<label for='subject'><b><b>Code de vérification (3 chiffres)</b> :</b></label>
					<input type='number' name='Secur' id='SecurPP' max='999' placeholder='Verification code...' required/>
					<abbr title="Voir au dos de la carte">?</abbr>
				
				</div> 
			
				<div class='columnPP'>
				<?php
					if($_POST['Niveau']=='Niveau1'){ echo"<input type='hidden' value='Niveau1' name='niv' id='nivPP'/>";} 
					if($_POST['Niveau']=='Niveau2'){ echo"<input type='hidden' value='Niveau2' name='niv' id='nivPP'/>";}
				?>	
				</div> 
			
				<br/><br/><br/><br/><b>Je valide mon choix : </b><br/><br/>
				<input type='submit' value='Payer' id='validPP' name='valid'/>
				</fieldset>
			</form>
		<center> 
		</div>
</div>
		
		
<!-- Pieds de page -->   
<div class="footer">
  <p><i>ALOVEGIE</i>, create by CHEVRIER Chleo, GONTIE Margaux, JANELA CAMEIJO Alice, MARTIN Teo, CPI2 Groupe 5</p>
</div>        




