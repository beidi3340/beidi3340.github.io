<?php

if (isset($_POST['submit'])) {

    //Identifiant attendu
    $nom = "SterDevs";
    $password = "ster1402";

    if ($nom != $_POST['nom'] || $password != $_POST['password']) {
        $msg = 'La combinaison du nom et du mot de passe est invalide';
        header('Location:../index.php?erreurLogin=' . $msg);
    } else
        header('Location:contacts.php');
}
