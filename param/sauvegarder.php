<?php

if(isset($_POST['submit'])) {

    //Pour les erreurs
    $msg = "";

    //contact
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $relation = htmlspecialchars($_POST['relation']);
    $mail = (htmlspecialchars($_POST['mail']));
    
    //Numero
    $MTN = htmlspecialchars($_POST['MTN']);
    $Orange = htmlspecialchars($_POST['Orange']);
    $Nextell = htmlspecialchars($_POST['Nextell']);
    $Camtel = htmlspecialchars($_POST['Camtel']);

    $numeros = [$MTN,$Orange,$Nextell,$Camtel];
    $operateurs = ['MTN','Orange','Nextell','Camtel'];
    //On vérifie que les numéros ne sont pas tous vide
    $sontVide = (empty($MTN) and empty($Orange) and empty($Nextell) and empty($Camtel));
    if($sontVide){
        $msg = 'Veuillez entrer au moins un numéros !';
        header("Location:enregistrer.php?error=".$msg);
    }
    //Opérateur principale
    $principale = ($_POST['principale']);

    //On détermine qui sera mis à true
    $principaleIsMTN = ('MTN' == $principale);
    $principaleIsOrange = ('Orange' == $principale);
    $principaleIsNextell = ('Nextell' == $principale);
    $principaleIsCamtel = ('Camtel' == $principale);

    //Tableau permettant de connaitre le numéro principale
    $estNumeroPrincipale = [$principaleIsMTN, $principaleIsOrange, $principaleIsNextell, $principaleIsCamtel];

    //On sauvegarde les informations d'abord
    include("connexionBD/connexion.php");

    $query = $conn->prepare("INSERT INTO Contact(nom,prenom,relation,mail) VALUES (:nom,:prenom,:relation,:mail) ");
    $query->bindValue(":nom",$nom,PDO::PARAM_STR);
    $query->bindValue(":prenom",$prenom,PDO::PARAM_STR);
    $query->bindValue(":relation",$relation,PDO::PARAM_STR);
    $query->bindValue(":mail",$mail,PDO::PARAM_STR);

    if ( !$query->execute() ){
        $msg = "Impossible d'enregistrer le contact";
        header("Location:enregistrer.php?error=".$msg);
    }

    $query->closeCursor();

    //On récupère son id sous forme de INT
    $query = $conn->query("SELECT id FROM Contact");
    
    $data = $query->fetchAll(PDO::FETCH_COLUMN); 
    
    foreach( $data as $dId  ){
        $id = +$dId;
    }

    $query->closeCursor();

    if( empty($id) ){
        $msg = "Le contact n'a été enregistrer ! ";
        header("Location:enregistrer.php?error=".$msg);
    }

    //On sauvegarde ses numéros
    $i = 0;
    foreach($numeros as $numb ){
        
        if(!empty($numb))
        {
            $query = $conn->prepare("INSERT INTO Telephone VALUES (:id,:numero,:operateur,:principale)");
            $query->bindValue(":id",$id);
            $query->bindValue(":numero",$numb);
            $query->bindValue(":operateur",($operateurs[$i]));
            $query->bindValue(":principale",($estNumeroPrincipale[$i]));
            $query->execute();

            $query->closeCursor();
        }

        $i++;
    }

    //On ajoute|modifie une photo de profil 

    if(isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) {
        
        $tailleMax = 2097152; //2Mo
        $extensionsValides = ['jpg','png','gif','jpeg'];
    
        //On vérifie la taille
        if($_FILES['avatar']['size'] <= $tailleMax ) {
    
            //On récupère l'extension du fichier
            $ext = strtolower( substr( strrchr($_FILES['avatar']['name'] , '.'), 1 ) );
    
            //On vérifie que l'extension est valide
            if( in_array($ext, $extensionsValides) ) {
    
                //On deplace le fichier vers le dossier avatar

                //Chemin où l'on veut mettre le fichier
                $chemin = "avatars/".$id.".".$ext;
                $deplacer = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin );

                if($deplacer) {

                    //Ajout de la photo dans la BD
                    $updateAvatar = $conn->prepare("UPDATE Contact SET photo = :avatar WHERE id = :id");
                    $updateAvatar->bindValue(":avatar", ($id.".".$ext) );
                    $updateAvatar->bindValue(":id",$id);
                    
                    $updateAvatar->execute();
                    $updateAvatar->closeCursor();

                }else{
                    $msg = "Erreur de déplacement de la photo";
                    header("Location:enregistrer.php?error=".$msg);
                }
    
            }else {
                $msg = "Votre photo de profil doit être au format JPG , JPEG, GIF ou PNG";
                header("Location:enregistrer.php?error=".$msg);
            }
        }
        else {
            $msg = "Votre photo de profil de doit pas dépasser 2Mo ";
            header("Location:enregistrer.php?error=".$msg);
        }
    }
    

}else {
    $msg = "Erreur lors de l'envoie du formulaire ";
    header("Location:enregistrer.php?error=".$msg);
}

//Une fois l'enregistrement éffectuer on retourne à l'affichage des contacts
header("Location:contacts.php");

?>
