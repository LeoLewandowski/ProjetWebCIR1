<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once('../util/common.php');
    require_once('../util/connection.php');
    require_once('../util/validate.php');

    // Définit la langue à utiliser dans la page
    $lang = LANGUAGE->value;

    // Si l'utilisateur est déjà connecté, on le redirige vers la page de gestion de compte
    if(isset($userInfo)) header('location:./account');

    // Définit les messages d'erreur à utiliser plus tard
    $passwordError = null;
    $emailError = null;

    // Définit les valeurs à utiliser pour auto-remplir la page (ou pour la vérification)
    $password = null;
    $email = null;

    // Si le form de connexion a été envoyé
    if(isset($_POST['login'])) {
        // Récupère les données dans le form
        if(isset($_POST['email'])) $email = cleanData($_POST['email']);
        if(isset($_POST['password'])) $password = $_POST['password'];

        // Vérifie si les données sont valables ou non
        if(!validateEmail($email)) $emailError = fetchTranslation($connection, 'emailInvalid');
        if(!validatePassword($password)) $passwordError = fetchTranslation($connection, 'passwordInvalid');

        // Si l'email et le MdP sont valides :
        if(!isset($emailError) && !isset($passwordError)) try {
            // Cherche la ligne de données correspondant à l'utilisateur, et vérifie si le MdP est bien le même
            // du côté client et serveur. Le MdP côté serveur est préalablement hashé
            $stmt = $connection->prepare("SELECT `password` FROM accounts WHERE `email` = ?");
            $stmt->execute([$email]);
            $hashedPwd = $stmt->fetch()[0];
            if(password_verify($password, $hashedPwd)) echo "Connection successful !";
        }
        // En cas d'erreur, on notifie l'utilisateur
        catch(Exception $e) {

        }
    }

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
                    <input type="email" name="email" id="courriel" placeholder=" " required="required">
                    <label for="courriel">Adresse email</label>
                </div>
                <div class="input-box">
                    <input type="password" id="mdp" name="password" placeholder=" " required="required">
                    <label for="mdp">Mot de passe</label>
                </div>
                <div class="btn">
                    <button type="submit" name="login" class="signupbtn">Connexion</button>
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