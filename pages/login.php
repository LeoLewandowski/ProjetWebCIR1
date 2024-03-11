<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require_once('../util/common.php');
    getPageHead('Connexion', 'login');
    ?>
</head>
<body>
    <?php
    getPageHeader();
    ?>
    <main>
        <form class="formLetter" method="post" action="#">
            <fieldset>  <!-- la balise fieldset peut être utilisé pour regrouper un ensemble de champs -->
                <legend>Connexion</legend>
                <label for="courriel">Email :</label>
                <input type="email" name="courriel" id="courriel" placeholder="nom.prenom@student.junia.com" required="required">
                <br><br>
                <label for="mdp">Mot de passe :</label>
                <input type="password" id="mdp" name="mdp" placeholder="Votre mot de passe" required="required">
                <br><br>
                <div class="btn">
                    <button type="submit" class="signupbtn">Connexion</button>
                    <a href="/inscription" class="Connexion">S'inscrire</a>
                </div>
            </fieldset>
        </form>
    </main>

    <?php
    getPageFooter();
    ?>
</body>
</html>