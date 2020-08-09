<?php

include('connexionBD/connexion.php');

if( isset($_POST['supprimer'])){

    $id = +$_POST['id'];
    $q = $conn->query("DELETE FROM Contact WHERE id=$id ");
    $q->execute();
    $q->closeCursor();
    header('Location:contacts.php');

}

if( isset($_POST['modifier']) ) :

?>

<?php
    $id = +$_POST['id'];
    //On récupère le contact
    $query = $conn->query("SELECT * FROM Contact WHERE id=$id  ");
    $contact = $query->fetch(PDO::FETCH_OBJ);
     
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css" />
    <title>Modifier Contact</title>
    <style>
        .titre-champ,p {
            font-size: 1.3rem;
            font-weight: 800;
            color: antiquewhite;
        }
        input.titre-champ {
            cursor: pointer;
        }
    </style>

</head>

<body>

    <div class="container">
        <form class="form" method="POST" enctype="multipart/form-data" action="update.php">
            <legend class="form__title">
                Contact
            </legend>

            <fieldset>
                <legend class="titre-champ">
                    Information
                </legend>

                <p>
                    <input type="hidden" name="id" value=<?=$id?> />
                    <input require class="zone__text" placeholder="<?=!empty($contact->nom) ? $contact->nom : "Nom" ?>" name="nom" type="text" />
                </p>

                <p>
                    <input class="zone__text" placeholder="<?=!empty($contact->prenom) ? $contact->prenom : "Prenom" ?>" name="prenom" type="text" />
                </p>

                <p>
                    <input class="zone__text" placeholder="<?=!empty($contact->relation) ? $contact->relation : "Relation" ?>" name="relation" type="text" />
                </p>

                <p>
                    <input class="zone__text"   placeholder="<?=!empty($contact->mail) ? $contact->mail : "Mail" ?>" name="mail" type="email" />
                </p>
            </fieldset>

            <fieldset>
                <legend class="titre-champ">
                    Numéros
                </legend>

                <p>
                    <input class="zone__text" placeholder="MTN" name="MTN" type="tel" />
                </p>

                <p>
                    <input class="zone__text" placeholder="Orange" name="Orange" type="tel" />
                </p>

                <p>
                    <input class="zone__text" placeholder="Nextell" name="Nextell" type="tel" />
                </p>

                <p>
                    <input class="zone__text" placeholder="Camtel" name="Camtel" type="tel" />
                </p>

                <p>
                    Quel est votre opérateur principale ?
                </p>

                <p>

                    <select name="principale" class="zone__text">
                        <option value="MTN" class="zone__text">MTN</option>
                        <option value="Orange" class="zone__text">Orange</option>
                        <option value="Nextell" class="zone__text">Nextell</option>
                        <option value="Camtel" class="zone__text">Camtel</option>
                    </select>
                </p>

            </fieldset>

            <fieldset>
                <legend class="titre-champ">
                    Photo de profil
                </legend>

                <p>
                    <input class="titre-champ" type="file" name="avatar" />
                </p>
            </fieldset>

            <?php
            if (isset($_GET['error'])) {
                echo '<p class="erreur">' . $_GET['error'] . '</p>';
            }
            ?>

            <p>
                <input class="btn" type="submit" name="submit" value="Enregistrer" />
            </p>
        </form>
    </div>
    </div>

</body>

</html>

<?php endif?>

