<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css" />
    <link rel="icon" href="images/favicon.ico" />
    <title>Login</title>
</head>
<body>

    <div class="container">

        <form class="form" method="POST" action="param/login.php"  >

            <legend class="form__title">
                Ster Account
            </legend>

            <fieldset>
                <input class="zone__text" name="nom" placeholder="Nom" type="text" /> 
            </fieldset>

            <fieldset>
                <input class="zone__text" name="password" placeholder="Mot de passe" type="text" /> 
            </fieldset>

            <p class="zone__btn">
                <input class="btn" type="submit" name="submit" value="Sign in" />
            </p>

            <?php
                if(isset($_GET['erreurLogin'])) {
                    echo '<p class="erreur" >'. $_GET['erreurLogin'] . '</p>';
                }
            ?>

        </form>

    </div>
    
</body>
</html>
