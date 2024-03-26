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
            <fieldset> <!-- la balise fieldset peut être utilisé pour regrouper un ensemble de champs -->
                <legend>Connexion</legend>

                <div class="input-box">
                    <input type="email" name="courriel" id="courriel" placeholder=" " required="required">
                    <label for="courriel">Adresse email</label>
                </div>
                <div class="input-box">
                    <input type="password" id="mdp" name="mdp" placeholder=" " required="required">
                    <label for="mdp">Mot de passe</label>
                </div>
                <div class="btn">
                    <button type="submit" class="signupbtn">Connexion</button>
                    <a href="/register" class="connexion">S'inscrire</a>
                </div>
            </fieldset>
        </form>
    </main>

    <?php
    getPageFooter();
    ?>
</body>

</html>