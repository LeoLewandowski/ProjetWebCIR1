<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');

    // Si l'utilisateur est déjà connecté, on le redirige vers la page de gestion de compte
    if (isset($userInfo)) header('location:./account');
    
    // Définit les messages d'erreur à utiliser plus tard
    $genderError = null;
    $nameError = null;
    $surnameError = null;
    $passwordError = null;
    $emailError = null;
    $dateError = null;
    $acceptError = null;

    // Définit les valeurs à utiliser pour auto-remplir la page (ou pour la vérification)
    $gender = null;
    $name = null;
    $surname = null;
    $password = null;
    $email = null;
    $date = null;
    $accept = null;

    // Si le form de création de compte a été envoyé
    if (isset($_POST['signup'])) {
        // Définit les données à vérifier
        if (array_key_exists('gender', $_POST))
            $gender = Gender::tryFrom($_POST['gender']);
        if (array_key_exists('name', $_POST))
            $name = cleanData($_POST['name']);
        if (array_key_exists('surname', $_POST))
            $surname = cleanData($_POST['surname']);
        if (array_key_exists('password', $_POST))
            $password = $_POST['password'];
        if (array_key_exists('date', $_POST))
            $date = $_POST['date'];
        if (array_key_exists('email', $_POST))
            $email = $_POST['email'];
        if (array_key_exists('accept', $_POST))
            $accept = $_POST['accept'];

        // ----------------------- Tests de validité des différentes valeurs données -----------------------
    
        // Si le genre n'est pas une des options dans l'enum (H, F, ou N), alors la variable $gender est unset
        // Permet d'éviter l'injection en cas de valeurs possibles modifiées côté client
        if (!isset($gender))
            $genderError = _('This option is invalid, please choose another one');

        if (!validateName($name))
            $nameError = _('This name is invalid. Names must only contain word characters or ideogras, hyphens and apostrophes, and be shorter than 64 characters');
        if (!validateName($surname))
            $surnameError = _('This name is invalid. Names must only contain word characters or ideogras, hyphens and apostrophes, and be shorter than 64 characters');

        if (!validatePassword($password))
            $passwordError = _('The password must be between 8 and 64 characters long and can only include the following characters, with at least one of each type :<ul><li>Lower or upper-case latin letters, without accents</li><li>Digits (between 0 and 9)</li><li>Special characters in this list : \*/+-_=#~&@$</li></ul>');
    
        if (!validateEmail($email))
            $emailError = _('The given email adress is invalid, or it is longer than 64 characters');

        if (!validateDate($date))
            $dateError = _('The given date must be between today and 1900/01/01');

        if (!isset($accept))
            $acceptError = _('You must accept the conditions to continue');

        // S'il n'y a aucune erreur, alors on crée le compte et on connecte l'utilisateur
        if (
            !isset($genderError)
            && !isset($nameError)
            && !isset($surnameError)
            && !isset($passwordError)
            && !isset($emailError)
            && !isset($dateError)
            && !isset($acceptError)
        ) {
            // La fonction password_hash s'occupe de hasher le MdP avec l'algo Argon2I, en créant un
            // salt random pour la sécurité. Ce salt est irrécupérabe par le client ou le serveur et le hash
            // est one-way, ce qui rend l'opération sécurisée car on ne peut pas décrypter le MdP post-hash
            $hashedPwd = password_hash($password, PASSWORD_ARGON2I);

            // On vérifie si un utilisateur avec le même email n'exste pas déjà
            $check = $connection->prepare("SELECT email FROM accounts WHERE email = ?");
            $check->execute([$email]);
            if (count($check->fetchAll()) > 0) $emailError = _("This email adress is already linked to an account");
            else {
                // On crée une photo de profil pour l'utilisateur, basée sur ses initiales. On met un nom unique à la photo
                $clientID = uniqid("", true);
                createPfp($clientID . '.png', $surname[0] . $name[0]);

                // On enregistre les infos de l'utilisateur dans la BDD
                $stmt = $connection->prepare("INSERT INTO accounts (`gender`, `name`, `surname`, `password`, `email`, `birth`, `pfp_extension`, `id`, `admin`) VALUES (?, ?, ?, ?, ?, DATE ?, ?, ?, 0)");
                $stmt->execute([$gender->value, $name, $surname, $hashedPwd, $email, $date, 'png', $clientID]);

                // On enregistre les informations de l'utilisateur dans des cookies. Le MdP est quant à lui
                // mis dans une session du côté serveur pour une sécurité supplémentaire
                setcookie('id', $clientID);
                $_SESSION['password'] = $hashedPwd;

                if(isset($_GET['redirect'])) header('location:/'.$_GET['redirect']);
                else header('location:/account');
            }
        }
    }

    // Si le form de connexion a été envoyé
    if (isset($_POST['login'])) {
        // Récupère les données dans le form
        if (isset($_POST['email']))
            $email = cleanData($_POST['email']);
        if (isset($_POST['password']))
            $password = $_POST['password'];

        // Vérifie si les données sont valables ou non
        if (!validateEmail($email))
            $emailError = _('The given email adress is invalid, or it is longer than 64 characters');
        if (!validatePassword($password))
            $passwordError = _('The password must be between 8 and 64 characters long and can only include the following characters, with at least one of each type :<ul><li>Lower or upper-case latin letters, without accents</li><li>Digits (between 0 and 9)</li><li>Special characters in this list : \*/+-_=#~&@$</li></ul>');

        // Si l'email et le MdP sont valides :
        if (!isset($emailError) && !isset($passwordError))
            try {
                // Cherche la ligne de données correspondant à l'utilisateur, et vérifie si le MdP est bien le même
                // du côté client et serveur. Le MdP côté serveur est préalablement hashé
                $stmt = $connection->prepare("SELECT `password`, `id` FROM accounts WHERE `email` = ?");
                $stmt->execute([$email]);
                $line = $stmt->fetch();
                if (isset($line[0]) && password_verify($password, $line[0])) {
                    setcookie('id', $line[1]);
                    $_SESSION['password'] = $line[0];
                    if(isset($_GET['redirect'])) header('location:/'.$_GET['redirect']);
                    else header('location:/account');
                } else if (empty($line[0]))
                    $emailError = _("This email adress is not linked to any account");
                else
                    $passwordError = _('Wrong password !');
            }
            // En cas d'erreur, on notifie l'utilisateur
            catch (Exception $e) {
                echo _("<span class='error'>An error occured</span>");
            }
    }

    getPageHead('Connexion', 'login');
    ?>
    <script>
        function onToggle(toggle) {
            document.getElementById('switch').classList[toggle ? 'add' : 'remove']('toggled');
            document.querySelector('.flip-card-inner').style.height = document.querySelector(`.flip-card-${toggle ? 'signup' : 'login'}`).clientHeight + 'px';
        }
        document.addEventListener('DOMContentLoaded', () => onToggle(<?= isset($_GET['signup']) ?>));
    </script>
</head>

<body>
    <?php
    getPageHeader($userInfo);
    ?>
    <main>
        <div class="wrapper formLetter">
            <div class="card-switch">
                <label id="switch">
                    <input type="checkbox" class="toggle" onchange="onToggle(this.checked)" <?= isset($_GET['signup']) ? 'checked' : '' ?>>
                    <span class="slider"></span>
                    <span class="card-side" style="--text-before: <?= _('Log in') ?>; --text-after: <?= _('Sign up') ?>;"></span>
                </label>
                <div class="flip-card-inner">
                    <div class="flip-card-login">
                        <h6 class="title"><?= _('Log in') ?></h6>
                        <form class="form-generic center" action="#" method="post">
                            <div class="error-wrapper">
                                <div class="input-box">
                                    <input type="email" name="email" class="email" placeholder=" " <?php if (isset($email))
                                        echo "value='$email'"; ?>>
                                    <label><?= _('Email') ?></label>
                                </div><?php if ($emailError && isset($_POST['login']))
                                    echo "<span class='error'>$emailError</span>"; ?>
                            </div>

                            <div class="error-wrapper">
                                <div class="input-box">
                                    <input type="password" class="password" name="password" placeholder=" ">
                                    <label><?= _('Password') ?></label>
                                </div><?php if ($passwordError && isset($_POST['login']))
                                    echo "<span class='error'>$passwordError</span>"; ?>
                            </div>
                            <input type="submit" name="login" value="<?= _('Log in') ?> "
                                class="signupbtn">
                        </form>
                    </div>
                    <div class="flip-card-signup">
                        <h6 class="title"><?= _('Sign up') ?></h6>
                        <form class="form-generic center" action="?signup#" method="post">
                            <div class="error-wrapper">
                                <div class="input-box force-anim">
                                    <select name="gender" id="gender">
                                        <option value="N" <?= ($gender == Gender::Unspecified || isset($genderError)) ? ' selected' : '' ?>> <?= _(Gender::Unspecified->name) ?></option>
                                        <option value="M" <?= ($gender == Gender::Male && !isset($genderError)) ? ' selected' : '' ?>> <?= _(Gender::Male->name) ?></option>
                                        <option value="F" <?= ($gender == Gender::Female && !isset($genderError)) ? ' selected' : '' ?>> <?= _(Gender::Female->name) ?></option>
                                    </select>
                                    <label><?= _('Gender') ?></label>
                                </div><?php if ($genderError)
                                    echo "<span class='error'>$genderError</span>"; ?>
                            </div>

                            <div class="error-wrapper">
                                <div class="input-box">
                                    <input type="text" name="name" class="name" placeholder=" " <?php if (isset($name))
                                        echo "value='$name'"; ?> required>
                                    <label><?= _('Name') ?></label>
                                </div><?php if ($nameError)
                                    echo "<span class='error'>$nameError</span>"; ?>
                            </div>

                            <div class="error-wrapper">
                                <div class="input-box">
                                    <input type="text" name="surname" class="name" placeholder=" " <?php if (isset($surname))
                                        echo "value='$surname'"; ?> required>
                                    <label><?= _('Surname') ?></label>
                                </div><?php if ($surnameError)
                                    echo "<span class='error'>$surnameError</span>"; ?>
                            </div>

                            <div class="error-wrapper">
                                <div class="input-box">
                                    <input type="email" name="email" class="email" placeholder=" " <?php if (isset($email))
                                        echo "value='$email'"; ?> required>
                                    <label><?= _('Email') ?></label>
                                </div><?php if ($emailError && isset($_POST['signup']))
                                    echo "<span class='error'>$emailError</span>"; ?>
                            </div>

                            <div class="error-wrapper">
                                <div class="input-box">
                                    <input type="password" class="password" name="password" placeholder=" " required>
                                    <label><?= _('Password') ?></label>
                                </div><?php if ($passwordError && isset($_POST['signup']))
                                    echo "<span class='error'>$passwordError</span>"; ?>
                            </div>

                            <div class="error-wrapper">
                                <div class="input-box force-anim">
                                    <input type="date" class="birth" name="date" min="1000-01-01"
                                        max="<?php echo date('Y-m-d') ?>" <?php if (isset($date))
                                               echo "value='$date'"; ?> required>
                                    <label><?= _('Birth date') ?></label>
                                </div><?php if ($dateError)
                                    echo "<span class='error'>$dateError</span>"; ?>
                            </div>

                            <div class="conditions-accept">
                                <label class="check-box">
                                    <input type="checkbox" name="accept">
                                    <svg viewBox="0 -5 64 64">
                                        <path
                                            d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16"
                                            pathLength="575.0541381835938" class="path"></path>
                                    </svg>
                                </label>
                                <p> <?= _('I agree to the <a href="/conditions">terms and conditions</a> of this website') ?> </p>
                            </div>
                            <?php if ($acceptError)
                                echo "<span class='error'>$acceptError</span>"; ?>
                            <input type="submit" name="signup" value="<?= _('Sign up') ?>" class="signupbtn">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    getPageFooter();
    ?>
</body>

</html>