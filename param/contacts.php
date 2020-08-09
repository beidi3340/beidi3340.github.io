<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css" />
    <link rel="stylesheet" href="contact.css" />
    <style>
        .titre {
            color: aliceblue;
            font-weight: bold;
            font-size: 2.3rem;
            margin-bottom: 0.6rem;
        }
    </style>

    <title>Contacts</title>
</head>

<body>
    <div class="container">

        <!-- On se connecte à la BD -->
        <?php include("connexionBD/connexion.php"); ?>

        <!-- On vérifie s'il y a déjà des contacts enregistrer -->
        <?php

        //On vérifie s'il y a déjà des contacts enregistrer
        $query = $conn->query("SELECT * FROM Contact");

        $contacts = $query->fetchAll(PDO::FETCH_OBJ);
        $query->closeCursor();
        //Si il n'y a aucun contact on passe à l'enregistrement

        if (count($contacts) === 0) :

        ?>

            <form class="form" method="POST" action="enregistrer.php">
                <legend class="form__title">
                    Aucun contact sauvegarder
                    <p> enregistrer un nouveau contact ?</p>
                </legend>

                <div class="choix">

                    <p>
                        <input type="submit" class="btn" name="oui" value="Accepter" title="Sauvegarder un nouveau contact" />
                    </p>

                    <p>
                        <input type="submit" class="btn" name="non" value="Refuser" title="Retour au login" />
                    </p>

                </div>

            </form>


        <?php else : ?>

            <form class="form" method="POST" action="enregistrer.php">
                <legend class="form__title">
                    Ajoutez un contact 
                </legend>

                <div class="choix">

                    <p>
                        <input type="submit" class="btn" name="oui" value="Add" title="Sauvegarder un nouveau contact" />
                    </p>

                </div>

            </form>

            <div class="liste__contact">
                <h1 class="titre">Liste des contacts</h1>
                <?php //On recupère la liste des contacts
                include("connexionBD/connexion.php");
                $query = $conn->query("SELECT * FROM Contact");

                //On récupère les résultats sous forme d'un tableau d'objet : l'indice 0 correspond à notre premier objet
                $tabContacts = ($query->fetchAll(PDO::FETCH_OBJ));
                $query->closeCursor();

                //On récupère les numéros stocké sous forme d'un tableau d'objet
                $query = $conn->query("SELECT * FROM Telephone ");
                $tabNumeros = $query->fetchAll(PDO::FETCH_OBJ);

                foreach ($tabContacts as $contact) :
                ?>

                    <div class="contact">
                        <header class="contact__titre">
                            <div class="avatar">
                                <?= (!empty($contact->photo)) ? '<img src="avatars/' . $contact->photo . '" alt="profil" /> ' : '<img src="avatars/defaut.png" alt="profil" />' ?>
                            </div>
                            <div class="contact__nom">
                                <h2>Nom :
                                    <?= $contact->nom ?>
                                </h2>
                                <h2>Prenom :
                                    <?= $contact->prenom ?>
                                </h2>
                                <h3>
                                    Mail : <?= $contact->mail ?>
                                </h3>
                                <h3>
                                    Relation : <?= $contact->relation ?>
                                </h3>
                            </div>
                        </header>

                        <ul class="contact__numeros">

                            <?php
                            //On boucle pour afficher ses numéros
                            $id = $contact->id;

                            foreach ($tabNumeros as $numero) :
                            ?>

                                <?php if ($numero->idContact == $id) : ?>
                                    <li class="number">
                                        <?= $numero->operateur ?> : <?= $numero->number ?>
                                    </li>
                                <?php endif ?>

                            <?php endforeach ?>

                            <div class="choix">
                                <form method="POST" action="gestionContact.php">
                                    <input type="hidden" name="id" value="<?= $id ?>" />
                                    <input type="submit" class="btn" name="modifier" value="Modifier" />
                                </form>

                                <form method="POST" action="gestionContact.php">
                                    <input type="hidden" name="id" value="<?= $id ?>" />
                                    <input type="submit" class="btn" name="supprimer" value="Supprimer" />
                                </form>
                            </div>

                        </ul>
                    </div>


                <?php endforeach ?>

            </div>
        <?php endif ?>

    </div>

</body>

</html>