<?php 
		function Connect(){
			return mysqli_connect("localhost", "root", "", "bddfinale");
		}
	
		function Executer($conn, $requete){
			return mysqli_query($conn, $requete);
		}
		
		function ChercheBDD($champ,$pseudonyme){ 	//recherche la valeur d'un champ à partir d'un pseudo dans la BDD
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "SELECT $champ FROM allinformations WHERE Pseudo='$pseudonyme'";
		$ligne= mysqli_query($conn, $requete);	
		$TabLigne = mysqli_fetch_array($ligne);
		return ($TabLigne[0]);
		mysqli_close($conn);
		}
		
		function TrouveLigne($lvlabo){ 	//recherche un profil aléatoirement dans la BDD selon son niveau d'abonnement
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "SELECT Pseudo FROM allinformations WHERE Abonnement='$lvlabo'";
		$ligne= mysqli_query($conn, $requete);
		$n = mysqli_num_rows($ligne);		
		$Tab = array();
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) { 
				$Tab[] = $TabLigne["Pseudo"];
			}  
		} else {
			echo "Résultat vide... <br/>";
		}
		$li = rand(0, $n-1);
		return($Tab[$li]);
		mysqli_close($conn);
		}
		
		function TrouveProfilFiltres($lvlabo,$lieu,$allergie){	//Recherche des profils en fonction de leur abonnement, leur lieu et leurs allergies
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		if($lieu!=""){
			if($allergie!=""){
				$requete = "SELECT Pseudo FROM allinformations WHERE Abonnement='$lvlabo' AND (Allergie1='$allergie' OR Allergie2='$allergie' OR Allergie3='$allergie') AND Lieu='$lieu' ";
			}else{
				$requete = "SELECT Pseudo FROM allinformations WHERE Abonnement='$lvlabo' AND Lieu='$lieu'";
			}
		}else{
			if($allergie!=""){
				$requete = "SELECT Pseudo FROM allinformations WHERE Abonnement='$lvlabo' AND (Allergie1='$allergie' OR Allergie2='$allergie' OR Allergie3='$allergie')";
			}else{
				$requete = "SELECT Pseudo FROM allinformations WHERE Abonnement='$lvlabo'";
			}
		}
		$ligne= mysqli_query($conn, $requete);
		$n = mysqli_num_rows($ligne);	
		$Tab = array();
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) { 		
				$Tab[] = $TabLigne["Pseudo"];
			}  
		}
		return($Tab);				//retourne un tableau de pseudos
		mysqli_close($conn);
		}
		
		function TrouveProfilBarreR($maRecherche){// recherche un profil en fonction de son pseudo
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "SELECT Pseudo FROM allinformations WHERE Pseudo='$maRecherche'";
		$ligne= mysqli_query($conn, $requete);
		$n = mysqli_num_rows($ligne);	
		$Tab = array();
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) { 
				$Tab[] = $TabLigne["Pseudo"];
			}  
		}
		return($Tab);	//ne ressort normalement qu'un seul pseudo (car unique dans la bdd)
		mysqli_close($conn);
		}
		
		function ValideProfilFiltres($tabGens,$i,$boule,$AgeMin,$AgeMax){	// Vérifie si les profils trouvés correspondent aux critères d'âge et de d'orientation + affiche le profil 
					while($i<sizeof($tabGens)){	//tant qu'il y a des profils dans le tableau
					 $_SESSION["Profil"] = $tabGens[$i];
					if($_SESSION["Profil"]!=$_SESSION["pseudo"]){ // vérifier que le profil ne soit pas moi
						if(((ChercheBDD("orientation",$_SESSION["Profil"])==$_SESSION["sexe"])||(ChercheBDD("orientation",$_SESSION["Profil"])==0))&&((ChercheBDD("sexe",$_SESSION["Profil"])==$_SESSION["orientation"])||($_SESSION["orientation"]==0))){			
							if(!isset($AgeMin)||(($AgeMin=="")||(CalculAge(ChercheBDD("DateNaissance",$_SESSION["Profil"]))>=$AgeMin))){
								if(!isset($AgeMax)||(($AgeMax=="")||(CalculAge(ChercheBDD("DateNaissance",$_SESSION["Profil"]))<=$AgeMax))){
					//Affichage du profil
                 echo "<div class='column'>";
					echo "<div class='card'>";
					echo "<center><img src='".ChercheBDD("Photo1",$_SESSION['Profil'])."' alt='Logo' style='width:35%;'></center>";
					echo "<div class='container'>";
						echo "<center>";
						$co = VerifCo();
						echo '<br/><b><input type="button" class="PseudonymesAutresUtilisateursR" onclick="enregistrerPseudoDansFichier('.$boule.','.$co.');" value="'.ChercheBDD("Pseudo",$_SESSION["Profil"]).'" /></b> <br/><br/>';
						echo "<p class='title'><b>"; 
						echo CalculAge(ChercheBDD("DateNaissance", $_SESSION['Profil'])); echo "ans,"; AfficheDepartement(ChercheBDD("lieu",$_SESSION["Profil"])); echo"</b></p>";
						echo"<p><b>";AfficheSexe(ChercheBDD("sexe",$_SESSION["Profil"])); echo ",";  AfficheOrientation(ChercheBDD("orientation",$_SESSION["Profil"])); echo"</b></p>";
						echo "<p><b>";
						
						echo"<b> Allergie(s) : <div style='color : #E6362E;'>";
						AfficheAllergie(ChercheBDD("Allergie1", $_SESSION['Profil']));
						AfficheAllergie(ChercheBDD("Allergie2", $_SESSION['Profil']));
						AfficheAllergie(ChercheBDD("Allergie3", $_SESSION['Profil']));
						echo "</div></b></p>";						
						if ( (VerifCo()==1) && (VerifAbo()>=1)  && (VerifAboPAU($_SESSION["Profil"])>=1) ) { //si tu es connecté ET abonné ET que l'autre utilisateur a un abonnement alors on autorise les messages
							echo "<p class='Messagerie' ></p> "; 
						}
						echo "</div>
						<br/><br/> 
						<br/>
					</center>
					</div>
				  </div>
				  </div>";
				  $boule=$boule+1;
								}
							}
						}
					}
			$i=$i+1;	
				}
		return $boule;	
	}
		
		
		function InitSession($pseudonyme){	//Initialise toutes les variables de la session d'un utilisateur à partir des valeurs de la BDD 
		$_SESSION["pseudo"] =$pseudonyme; 
		$_SESSION["mdp"] = ChercheBDD("MotDePasse",$pseudonyme);
		$_SESSION["nom"] = ChercheBDD("Nom",$pseudonyme);
		$_SESSION["prenom"] = ChercheBDD("Prenom",$pseudonyme);
		$_SESSION["DateNaissance"] = ChercheBDD("DateNaissance",$pseudonyme);
		$_SESSION["mail"]= ChercheBDD("Email",$pseudonyme);
		$_SESSION["lieu"]=ChercheBDD("Lieu",$pseudonyme);
		$_SESSION["sexe"]=ChercheBDD("Sexe",$pseudonyme);
		$_SESSION["orientation"]=ChercheBDD("orientation",$pseudonyme);
		$_SESSION["allergie"][0]=ChercheBDD("Allergie1",$pseudonyme); 
		$_SESSION["allergie"][1]=ChercheBDD("Allergie2",$pseudonyme);
		$_SESSION["allergie"][2]=ChercheBDD("Allergie3",$pseudonyme);
		$_SESSION["NivAllergie"][0]=ChercheBDD("NiveauAllergie1",$pseudonyme);
		$_SESSION["NivAllergie"][1]=ChercheBDD("NiveauAllergie2",$pseudonyme);;
		$_SESSION["NivAllergie"][2]=ChercheBDD("NiveauAllergie3",$pseudonyme);;
		$_SESSION["passions"]=ChercheBDD("Passions",$pseudonyme);
		$_SESSION["defauts"]=ChercheBDD("QualitesDefauts",$pseudonyme);
		$_SESSION["description"]=ChercheBDD("Description",$pseudonyme);
		$_SESSION["piredate"]=ChercheBDD("PireDate",$pseudonyme);
		$_SESSION["phobies"]=ChercheBDD("Phobies",$pseudonyme);
		$_SESSION["photo1"]=ChercheBDD("Photo1",$pseudonyme);
		$_SESSION["photo2"]=ChercheBDD("Photo2",$pseudonyme);
		$_SESSION["photo3"]=ChercheBDD("Photo3",$pseudonyme);
		$_SESSION["abonne"]=ChercheBDD("Abonnement",$pseudonyme); 
		$_SESSION["connexion"] = ModifierProfil($pseudonyme,"Connexion",1);	//Passe la connexion de l'utilisateur à 1
		$_SESSION["admin"]=ChercheBDD("Admin",$pseudonyme);
		SupprimerMessages7Jours();	//Supprime les messages ayant plus d'une semaine
		SupprimerAbonnement1Mois();	//Réinitialise les abonnements de plus d'un mois à 0
		}
		
		function NouveauProfil($prenom,$nom,$pseudonyme,$mdp,$date,$sexe,$orientation){	//Enregistre un nouveau profil (nouvelle ligne) dans la BDD table allinformations
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "INSERT INTO allinformations VALUES ('$pseudonyme','$mdp','$nom','$prenom', '$date', '', '01', '$sexe', '$orientation', '1', '1', '0', '0', '0', '0', '', '', '', '', '', 'logo.jpg','logo2.png','logo3.jpg','0','1','0', NULL)";
		//Les champs obligatoires sont remplis par défaut mais l'utilisateur peut directement les modifier dans ModifierMonProfil
		$ligne= mysqli_query($conn, $requete);
		mysqli_close($conn);
		}
		
		function ModifierProfil($pseudonyme,$champ,$nvValeur){	//Modifie une valeur dans une ligne de la BDD
			$conn = mysqli_connect("localhost", "root", "", "bddfinale");
			$requete2 = "UPDATE allinformations SET $champ='$nvValeur' WHERE Pseudo='$pseudonyme'";
			$ligne2= mysqli_query($conn, $requete2);
			mysqli_close($conn);
			return($nvValeur);
		}
		
		function Disconnect($conn){
			mysqli_close($conn);
		}
		
		function AfficheSexe($nb){ //Affiche le sexe 
			if($nb==1){
				echo"Homme";
			}else if($nb==2){
				echo"Femme";
			}
		}
		
		function AfficheOrientation($nb){ // Affiche l'orientation sexuelle
			if($nb==1){
				echo"Hommes";
			}else if($nb==2){
				echo"Femmes";
			}else if($nb==0){
				echo"Hommes et Femmes";
			}
		}

		function AfficheDepartement($var){// Affiche le nom du département à partir de son numéro
			$ouverture = fopen("departements.txt","r");
			for($i=0;$i<$var;$i++){
				fgets($ouverture);
			}
			echo fgets($ouverture)."<br/>";		
			fclose($ouverture);
		}
		
		function AfficheAllergie($var){	//Affiche la nom de l'allergie à partir de son numéro
			$ouverture = fopen("allergies.txt","r");
			for($i=0;$i<$var;$i++){
				fgets($ouverture);
			}
			echo fgets($ouverture)."<br/>";		
			fclose($ouverture);
		}
		
		function CalculAge($naissance){ //Calcul l'âge à partir de la date de naissance au format ANNEE-mois-jour
			$date = date('Y');

			$string = explode("-",$naissance);

			$jour=(int)$string[2];
			$moi=(int)$string[1];
			$annee=(int)$string[0];
     
			if(($moi < date('m'))||(($moi==date('m'))&&($jour<=date('d')))){
					return	$date-$annee;
			}else{
			return $date - $annee-1 ;
			}
		}
	
		function CalculNbAllergies(){	//Calcul le nombre d'allergie de l'utilisateur et supprime les allergies si le nom ou le niveau n'est pas complété 
			//si niveau 0
		if(!isset($_SESSION["pseudo"])){	//si l'utilisateur n'est pas connecté alors le nombre d'allergie est 0.
		return 0;
		}else{	
			if($_SESSION["NivAllergie"][1]==0){	//si niveau d'allergie2 == 0 alors on supprime les allergies 2 et 3
				$_SESSION["allergie"][1]="0";
				$_SESSION["allergie"][2]="0";
				$_SESSION["NivAllergie"][2]=0;
			}
			if($_SESSION["NivAllergie"][2]==0){
				$_SESSION["allergie"][2]="0";
			}
			//si 2 fois la même allergie on supprime la deuxieme
			if($_SESSION["allergie"][0]==$_SESSION["allergie"][1]){
				$_SESSION["allergie"][1]="0";
				$_SESSION["NivAllergie"][1]=0;
			}
			if(($_SESSION["allergie"][0]==$_SESSION["allergie"][2])||(($_SESSION["allergie"][1]==$_SESSION["allergie"][2])&&($_SESSION["allergie"][1]!="0"))){
				$_SESSION["allergie"][2]="0";
				$_SESSION["NivAllergie"][2]=0;
			}
			//si pas allergie selectionnée mais un niveau choisi alors on réinitialise le niveau d'allergie
			if($_SESSION["allergie"][1]!="0"){
				if($_SESSION["allergie"][2]!="0"){
					return 3;
				}else{
					$_SESSION["NivAllergie"][2]=0;
					return 2;
				}
			}else{ 
				$_SESSION["NivAllergie"][2]=0;
				$_SESSION["NivAllergie"][1]=0;
				return 1;
				}
			}
		} 
		
		function CalculNbAllergiesPAU($pseudonyme){ //Calcul le nombre d'allergie d'un utilisateur (!= de celui connecté)
			$al1= ChercheBDD("Allergie1",$pseudonyme);
			$al2= ChercheBDD("Allergie2",$pseudonyme);
			$al3= ChercheBDD("Allergie3",$pseudonyme);
			if($al2!="0"){
				if($al3!="0"){
					return 3;
				}else{
					return 2;
				}
			}else{ 
				return 1;
				}
		}

		function SupprimerProfil($pseudonyme){ //Supprime le profil d'un utilisateur dans la BDD
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "DELETE FROM allinformations WHERE Pseudo='$pseudonyme'";
		$ligne= mysqli_query($conn, $requete);	
		mysqli_close($conn);		
		}

		function VerifCo(){ // Regarde si un utilisateur est connecté
		if(isset($_SESSION["pseudo"])){//si connecté
			return 1;
		}else{//si pas connecté
			return 0;
		}
		}
		
		function VerifAbo(){ //Verifie le niveau d'abonnement d'un utilisateur s'il est connecté
		if(isset($_SESSION["pseudo"])){//si connecté
			return ChercheBDD("Abonnement",$_SESSION["pseudo"]);
		}else{//si pas connecté
			return 0;
		}
		}
		
		function VerifAboPAU($pseudonyme){ // Vérifie le niveau d'abonnement d'un utilisateur (autre que celui connecté)
			return ChercheBDD("Abonnement",$pseudonyme);
		}
		
		function NouveauMessage($de,$a,$msg,$heure){	// Enregistre un nouveau message dans la BDD table Messages
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$date = date('Y-m-d');
		$heure = date('H:i:s');
		$requete = "INSERT INTO messages VALUES(NULL,'$de','$a','$msg','$date','$heure') ";
		$ligne= mysqli_query($conn, $requete);
		mysqli_close($conn);
		}
		
		function Signaler($signaleur,$signale,$motif){	// Enregistre un nouveau signalement dans la BDD table signalement
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "INSERT INTO signalement VALUES(NULL,'$signaleur','$signale','$motif')";
		$ligne= mysqli_query($conn, $requete);
		mysqli_close($conn);
		}
		
		function Bloquer($bloqueur,$bloque){	//Enregistre un nouveau blocage dans la BDD table blocage
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "INSERT INTO blocage VALUES(NULL,'$bloqueur','$bloque')";
		$ligne= mysqli_query($conn, $requete);
		mysqli_close($conn);
		}
		
		function Liker($likeur,$like){//Enregistre un nouveau like dans la BDD table jaime
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "INSERT INTO jaime VALUES(NULL,'$likeur','$like')";
		$ligne= mysqli_query($conn, $requete);
		mysqli_close($conn);
		}
		
		function SuperLiker($likeur,$like){//Enregistre un nouveau Superlike dans la BDD table Superjaime
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "INSERT INTO superjaime VALUES(NULL,'$likeur','$like')";
		$ligne= mysqli_query($conn, $requete);
		mysqli_close($conn);
		}
		
		function TrouveNbMessagesTotal(){	//Compare tous les id des messages de la bdd pour déterminer l'id maximum
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "SELECT mp_id FROM Messages";
		$ligne= mysqli_query($conn, $requete);
		$n = mysqli_num_rows($ligne);
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) {
				$Tabid[] = $TabLigne["mp_id"];
			}  
		$maxi =max($Tabid); 
		}
		mysqli_close($conn);
		return $maxi;
		}
		
		function TrouveAfficheMessages($Utilisateur1,$Utilisateur2){	//Trouve tous les messages échangés entre deux utilisateurs (Utilisateur2 == utilisateur connecté) 
		echo"<br/><br/><br/>";
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "SELECT mp_id,mp_text,mp_receveur,mp_expediteur,mp_date,mp_time FROM Messages WHERE ((mp_receveur='$Utilisateur1')||(mp_expediteur='$Utilisateur1'))&&((mp_receveur='$Utilisateur2')||(mp_expediteur='$Utilisateur2'))";
		$ligne= mysqli_query($conn, $requete);
		$n = mysqli_num_rows($ligne);	
		$TabText=array();
		$TabExp=array();
		$TabRec=array();
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) { 		
				$TabID[] = $TabLigne["mp_id"];
				$TabText[] = $TabLigne["mp_text"];
				$TabRec[] = $TabLigne["mp_receveur"];
				$TabExp[] = $TabLigne["mp_expediteur"];
				$TabDate[] = $TabLigne["mp_date"];
				$TabHeure[] = $TabLigne["mp_time"];
			}  
		
		$idmax = TrouveNbMessagesTotal();
		for($j=0; $j<=$idmax;$j++){//on parcourt tous les ID
			for($i=0; $i<sizeof($TabID);$i++){//on parcourt la table des ID des messages a afficher
		if($TabID[$i]==$j){
			// affichage du message	
		if($TabExp[$i]==$Utilisateur2){     // si j'ai envoyé le message
            echo "<div style='background-color: pink;'>".$TabText[$i]." | ".$TabDate[$i]." , ".$TabHeure[$i]."</div><br/>";
        }else{									// si j'ai reçu le message
            echo "<div style='background-color: #f1f1f1; border 1px solid #333;'>".$TabText[$i]." | ".$TabDate[$i]." , ".$TabHeure[$i]."</div><br/>";
        }
		}
		}
		}
		} else {
			echo "Vous n'avez pas encore de conversation avec cette personne. Envoyer le premier message ;)</b> <br/> <span style='color:#E6263E;'> Attention ! Ne mettez pas d'apostrophes dans vos messages </span>";
		}
		mysqli_close($conn);	
		}
		
		
		function TrouveDernierMessage($Utilisateur1,$Utilisateur2){	// Retournele dernier message échangé entre deux utilisateurs 
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "SELECT mp_id FROM Messages WHERE ((mp_receveur='$Utilisateur1')||(mp_expediteur='$Utilisateur1'))&&((mp_receveur='$Utilisateur2')||(mp_expediteur='$Utilisateur2'))";
		$ligne= mysqli_query($conn, $requete);
		$n = mysqli_num_rows($ligne);	
		$TabID=array();
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) { 	
				$TabID[] = $TabLigne["mp_id"];
			}  
		$dernier = max($TabID);	
		$requete = "SELECT mp_text FROM Messages WHERE mp_id='$dernier' ";
		$ligne = mysqli_query($conn, $requete);
		$resultat = mysqli_fetch_array($ligne) ;
		$requete = "SELECT mp_time FROM Messages WHERE mp_id='$dernier' ";
		$ligne = mysqli_query($conn, $requete);
		$heure = mysqli_fetch_array($ligne) ;
		return array($resultat[0],$heure[0]); //renvoie le texte et l'heure
		}
		mysqli_close($conn);	
		}
		
		
		function TrouveNbConversations($utilisateur){ 	//trouve et retourne les profils ayant une discussion avec utilisateur
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "SELECT mp_expediteur,mp_receveur FROM messages WHERE ((mp_expediteur='$utilisateur')||(mp_receveur='$utilisateur'))";
		$ligne= mysqli_query($conn, $requete); 
		$n = mysqli_num_rows($ligne);
		$Tab = array();		//Tableau de tous les profils qui ont une conversation avec l'utilisateur
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) { 
				if($TabLigne["mp_expediteur"]!=$utilisateur){
				$Tab[] = $TabLigne["mp_expediteur"];
				}
				if($TabLigne["mp_receveur"]!=$utilisateur){
				$Tab[] = $TabLigne["mp_receveur"];
				}
			}  
		}
		mysqli_close($conn);
		
		$TabConv=array();		//tableau definitif des gens ayant une conversation avec l'utilisateur == sans doublons
		for($i=0;$i<$n;$i++){ 	//on parcourt le tab de resultats
			$boule=0;
			for($j=0;$j<sizeof($TabConv);$j++){	//on verifie que le profil n'est pas déjà dans le tableau  
				if($Tab[$i]==$TabConv[$j]){
				$boule=1;
				}
			}
			if($boule==0){	//si "nouveau" profil on l'ajoute au tableau des conversations
			$TabConv[] = $Tab[$i];
			}
		}
		return $TabConv;			
		}

		function SupprimerMessage($Utilisateur1,$Utilisateur2){	// Supprime une conversation entre deux utilisateurs 
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "DELETE FROM Messages WHERE ((mp_receveur='$Utilisateur1')||(mp_expediteur='$Utilisateur1'))&&((mp_receveur='$Utilisateur2')||(mp_expediteur='$Utilisateur2'))";
		$ligne= mysqli_query($conn, $requete);	
		mysqli_close($conn);
		}

		function SupprimerMessages7Jours(){ //Supprime tous les messages ayant été envoyé il y a plus d'une semaine
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete="SELECT mp_id FROM Messages WHERE mp_date + INTERVAL 7 DAY <= NOW()";
		$ligne= mysqli_query($conn, $requete);
		$n = mysqli_num_rows($ligne);
		$Tab =array();	
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) { 
				$Tab[] = $TabLigne["mp_id"];			//Tableau des messages à supprimer
			}  
		}		
		for($i=0;$i<sizeof($Tab);$i++){
			$requete = "DELETE FROM Messages WHERE mp_id='$Tab[$i]'";		//suppression du message dans la BDD
			$ligne= mysqli_query($conn, $requete);
		}
		mysqli_close($conn);
		}
		
		function SupprimerAbonnement1Mois(){	// Réinitialise au niveau 0 tous les abonnements datant de plus de 30 jours
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete="SELECT Pseudo FROM allinformations WHERE DateAbonnement + INTERVAL 30 DAY <= NOW()";
		$ligne= mysqli_query($conn, $requete);
		$n = mysqli_num_rows($ligne);
		$Tab =array();	
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) { 
				$Tab[] = $TabLigne["Pseudo"];
			}  
		}		
		for($i=0;$i<sizeof($Tab);$i++){
			$requete = "UPDATE allinformations SET Abonnement='0',DateAbonnement='NULL' WHERE Pseudo='$Tab[$i]'";
			$ligne= mysqli_query($conn, $requete);
		}
		mysqli_close($conn);
		}
		
		function ListeUtilisateurs(){	// Tableau de tous les utilisateurs du site 
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete="SELECT Pseudo FROM allinformations";
		$ligne= mysqli_query($conn, $requete);
		$n = mysqli_num_rows($ligne);
		$Tab =array();	
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) { 
				$Tab[] = $TabLigne["Pseudo"];
			}  
		}		
		return $Tab;
		mysqli_close($conn);
		}

		function TrouveSignalement($utilisateur){ //Trouve les profils qui ont signalé utilisateur 
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "SELECT Id_Signalement,Signaleur,Motif FROM signalement WHERE Signale='$utilisateur' ";
		$ligne= mysqli_query($conn, $requete);
		$n = mysqli_num_rows($ligne);	
		$TabID=array();
		$TabSign=array();
		$TabMotif=array();
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) { 	
				$TabID[] = $TabLigne["Id_Signalement"];
				$TabSign[] = $TabLigne["Signaleur"];
				$TabMotif[] = $TabLigne["Motif"];
			}  
			// affcihe les pseudos des "signaleurs" et leur motif de signalement
		echo "<center>";
		echo "Est signalé.e ";
		for($j=0;$j<sizeof($TabSign);$j++){
			echo 'par <span style="color:#E6263E;">'.$TabSign[$j].'</span> pour <span style="color:#FFA8A8;">'.$TabMotif[$j].'</span><br/>';
		}
		echo "</center>";
		}
		mysqli_close($conn);	
		}

		function TrouveBlocage($utilisateur){ //Trouve les gens qui ont bloqué cette personne
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "SELECT Id_blocage,Bloqueur FROM blocage WHERE Bloque='$utilisateur' ";
		$ligne= mysqli_query($conn, $requete);
		$n = mysqli_num_rows($ligne);	
		$TabID=array();
		$TabBloc=array();
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) { 	
				$TabID[] = $TabLigne["Id_blocage"];
				$TabBloc[] = $TabLigne["Bloqueur"];
			}  
			//affiche les pseudos des "bloqueurs"
		echo "<center>";
		echo "Est bloqué.e ";
		for($j=0;$j<sizeof($TabBloc);$j++){
			echo 'par <span style="color:#E6263E;">'.$TabBloc[$j].'</span><br/>';
		}
		echo "</center>";
		}
		mysqli_close($conn);	
		}

		function TrouveBloquesPar($utilisateur){ //Trouve les gens qui sont bloqués par cet utilisateur
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "SELECT Id_blocage,Bloque FROM blocage WHERE Bloqueur='$utilisateur' ";
		$ligne= mysqli_query($conn, $requete);
		$n = mysqli_num_rows($ligne);	
		$TabID=array();
		$TabBloc=array();
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) { 	
				$TabID[] = $TabLigne["Id_blocage"];
				$TabBloc[] = $TabLigne["Bloque"];
			}  
		return $TabBloc;
		}
		mysqli_close($conn);	
		}

		function Debloquer($utilisateur1,$utilisateur2){    //debloque l'utilisateur2 pour l'utilisateur 1
        $conn = mysqli_connect("localhost", "root", "", "bddfinale");
        $requete = "SELECT Id_blocage FROM blocage WHERE (Bloqueur='$utilisateur1' AND Bloque='$utilisateur2')";
        $ligne= mysqli_query($conn, $requete);
        $n = mysqli_num_rows($ligne);
        if ($n > 0) {
        //supprime la ligne correspondant à ce blocage dans le BDD   
        $requete = "DELETE FROM blocage WHERE (Bloqueur='$utilisateur1' AND Bloque='$utilisateur2')";
        $ligne= mysqli_query($conn, $requete);
        }       
        mysqli_close($conn);
        }

		function TrouveLike($utilisateur){ 	//Trouve et Affiche toutes les personnes qui ont aimé le profil de utilisateur
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "SELECT Id_Jaime,Aimeur FROM jaime WHERE Aime='$utilisateur' ";
		$ligne= mysqli_query($conn, $requete);
		$n = mysqli_num_rows($ligne);	
		$Tab=array();
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) { 	
				$Tab[] = $TabLigne["Aimeur"];
			}  
		return $Tab;
		}
		mysqli_close($conn);
		}

		function TrouveSuperLike($utilisateur){ 	//Trouve et Affiche toutes les personnes qui ont "superaimé" le profil de utilisateur
		$conn = mysqli_connect("localhost", "root", "", "bddfinale");
		$requete = "SELECT Superaimeur FROM superjaime WHERE Superaime='$utilisateur' ";
		$ligne= mysqli_query($conn, $requete);
		$n = mysqli_num_rows($ligne);	
		$Tab=array();
		if ($n > 0) {
			while ($TabLigne = mysqli_fetch_assoc($ligne)) { 	
				$Tab[] = $TabLigne["Superaimeur"];
			}  
		return $Tab;
		}
		mysqli_close($conn);
		}
		
		function SupprimerSignalement($utilisateur){    // supprime les signalements où utilisateur est impliqué
        $conn = mysqli_connect("localhost", "root", "", "bddfinale");
        $requete = "SELECT Id_Signalement FROM signalement WHERE (Signaleur='$utilisateur' OR Signale='$utilisateur')";
        $ligne= mysqli_query($conn, $requete);
        $n = mysqli_num_rows($ligne);
        if ($n > 0) {
            while ($TabLigne = mysqli_fetch_assoc($ligne)) {    
                $Tab[] = $TabLigne["Id_Signalement"];
            }
            for($i=0;$i<sizeof($Tab);$i++){
            $requete = "DELETE FROM signalement WHERE Id_Signalement = $Tab[$i] ";
            $ligne= mysqli_query($conn, $requete);
            }
        }
        mysqli_close($conn);
        }
        
        function SupprimerLike($utilisateur){    // supprime les like où utilisateur est impliqué
        $conn = mysqli_connect("localhost", "root", "", "bddfinale");
        $requete = "SELECT Id_jaime FROM jaime WHERE (Aimeur='$utilisateur' OR Aime='$utilisateur')";
        $ligne= mysqli_query($conn, $requete);
        $n = mysqli_num_rows($ligne);
        if ($n > 0) {
            while ($TabLigne = mysqli_fetch_assoc($ligne)) {    
                $Tab[] = $TabLigne["Id_jaime"];
            }
            for($i=0;$i<sizeof($Tab);$i++){
            $requete = "DELETE FROM jaime WHERE Id_jaime = $Tab[$i] ";
            $ligne= mysqli_query($conn, $requete);
            }
        }
        mysqli_close($conn);
        }
        
        function SupprimerSuperLike($utilisateur){    // supprime les superlike où utilisateur est impliqué
        $conn = mysqli_connect("localhost", "root", "", "bddfinale");
        $requete = "SELECT Id_Superjaime FROM superjaime WHERE (Superaimeur='$utilisateur' OR Superaime='$utilisateur')";
        $ligne= mysqli_query($conn, $requete);
        $n = mysqli_num_rows($ligne);
        if ($n > 0) {
            while ($TabLigne = mysqli_fetch_assoc($ligne)) {    
                $Tab[] = $TabLigne["Id_Superjaime"];
            }
            for($i=0;$i<sizeof($Tab);$i++){
            $requete = "DELETE FROM superjaime WHERE Id_Superjaime = $Tab[$i] ";
            $ligne= mysqli_query($conn, $requete);
            }
        }
        mysqli_close($conn);
        }
        
        function SupprimerBlocage($utilisateur){    // supprime les blocages où utilisateur est impliqué
        $conn = mysqli_connect("localhost", "root", "", "bddfinale");
        $requete = "SELECT Id_blocage FROM blocage WHERE (Bloqueur='$utilisateur' OR Bloque='$utilisateur')";
        $ligne= mysqli_query($conn, $requete);
        $n = mysqli_num_rows($ligne);
        if ($n > 0) {
            while ($TabLigne = mysqli_fetch_assoc($ligne)) {    
                $Tab[] = $TabLigne["Id_blocage"];
            }
            for($i=0;$i<sizeof($Tab);$i++){
            $requete = "DELETE FROM blocage WHERE Id_blocage = $Tab[$i] ";
            $ligne= mysqli_query($conn, $requete);
            }
        }
        mysqli_close($conn);
        }

?>
