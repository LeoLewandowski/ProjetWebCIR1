<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once('../util/common.php');
    require_once('../util/connection.php');
    getPageHead('Inscription', 'login');
    ?>
</head>

<body>
    <?php
    getPageHeader();
    ?>
    <main>
        <form class="formLetter" method="post" action="#">
            <fieldset> <!-- la balise fieldset peut être utilisé pour regrouper un ensemble de champs -->
                <legend>Créer Votre Compte</legend>
                <div class="input-box force-anim">
                    <select name="gender" id="gender">
                        <option value="M">Monsieur</option>
                        <option value="F">Madame</option>
                        <option value="N">Autre / Ne veut pas préciser</option>
                    </select>
                    <label for="gender">Civilité</label>
                </div>

                <div class="input-box">
                    <input type="text" name="nom" id="name" placeholder=" " required="required">
                    <label for="nom">Nom</label>
                </div>

                <div class="input-box">
                    <input type="text" name="prenom" id="suranme" placeholder=" " required="required">
                    <label for="prenom">Prénom</label>
                </div>

                <div class="input-box">
                    <input type="email" name="courriel" id="email" placeholder=" " required="required">
                    <label for="courriel">Adresse email</label>
                </div>

                <div class="input-box">
                    <input type="password" id="password" name="mdp" placeholder=" " required="required">
                    <label for="mdp">Mot de passe</label>
                </div>

                <div class="input-box force-anim">
                    <input type="date" id="birth" name="birthdate" min="1910-01-01" max="2004-12-31" required="required">
                    <label>Date de naissance</label>
                </div>

                <div class="conditions-accept">
                    <label class="check-box">
                        <input type="checkbox" name="..." required>
                        <svg viewBox="0 -5 64 64">
                            <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" pathLength="575.0541381835938" class="path"></path>
                        </svg>
                    </label>
                    <p>
                        J'accepte les <a href="/conditions">conditions générales</a> d'inscription
                    </p>
                </div>

                <div class="btn">
                    <button type="submit" class="signupbtn">S'inscrire</button>
                    <a href="/login" class="connexion">Connexion</a>
                </div>
            </fieldset>
        </form>
    </main>

    <?php
    getPageFooter();
    ?>
</body>

</html>