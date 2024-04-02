<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once('../util/common.php');
    require_once('../util/connection.php');

    // Définit la langue à utiliser dans la page
    $lang = LANGUAGE->value;

    // Si l'utilisateur est déjà connecté, on le redirige vers la page de gestion de compte
    if(isset($userInfo)) header('location:./account');

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

    if(isset($_POST['register'])){
        // Définit les données à vérifier
        if(array_key_exists('gender',$_POST)) $gender = Gender::tryFrom($_POST['gender']);
        if(array_key_exists('name',$_POST)) $name = cleanData($_POST['name']);
        if(array_key_exists('surname',$_POST)) $surname = cleanData($_POST['surname']);
        if(array_key_exists('password',$_POST)) $password = $_POST['password'];
        if(array_key_exists('date',$_POST)) $date = $_POST['date'];
        if(array_key_exists('email',$_POST)) $email = $_POST['email'];
        if(array_key_exists('accept',$_POST)) $accept = $_POST['accept'];

        // ----------------------- Tests de validité des différentes valeurs données -----------------------

        // Si le genre n'est pas une des options dans l'enum (H, F, ou N), alors la variable $gender est unset
        // Permet d'éviter l'injection en cas de valeurs possibles modifiées côté client
        if(!isset($gender)) $genderError = _(Localization::INVALID_VALUE->value);

        if(!validateName($name)) $nameError = _(Localization::INVALID_NAME->value);
        if(!validateName($surname)) $surnameError = _(Localization::INVALID_NAME->value);

        if(!validatePassword($password)) $passwordError = _(Localization::INVALID_PASSWORD->value);
        // Version FR : "Le mot de passe doit faire entre 8 et 64 caractères et ne peut contenir que les caractères suivants, dont au moins 1 de chaque type :<ul><li>Lettres latines minuscules ou majuscules non accentuées</li><li>Chiffres (entre 0 et 9)</li><li>Caractères spéciaux parmi : \\*/+-_=#~&@$</li></ul>"

        if(!validateEmail($email)) $emailError = _(Localization::INVALID_EMAIL->value);
        
        if(!validateDate($date)) $dateError = _(Localization::INVALID_DATE->value);

        if(!isset($accept)) $acceptError = _(Localization::UNACCEPTED_CONDITIONS->value);

        // S'il n'y a aucune erreur, alors on crée le compte et on connecte l'utilisateur
        if(!isset($genderError)
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

            // On enregistre les infos de l'utilisateur dans la BDD
            $stmt = $connection->prepare("INSERT INTO accounts (`gender`, `name`, `surname`, `password`, `email`, `birth`, `admin`) VALUES (?, ?, ?, ?, ?, DATE ?, 0)");
            $stmt->execute([$gender->value, $name, $surname, $hashedPwd, $email, $date]);

            // On enregistre les informations de l'utilisateur dans des cookies. Le MdP hashé est aussi celui
            // mis dans le cookie, ainsi même si un tiers récupère le cookie contenant le MdP hashé, il ne
            // pourra rien en faire car le hash est indécryptable, et le MdP originel (non hashé) est nécessaire
            // pour la connexion au compte.
            setcookie('email', $email);
            setcookie('password', $hashedPwd);

            header('location:/');
        }
    }

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
                    <?php
                    echo '<select name="gender" id="gender">
                        <option value="M"'.(($gender == Gender::Male && !isset($genderError)) ? ' selected' : '').'>Monsieur</option>
                        <option value="F"'.(($gender == Gender::Female  && !isset($genderError)) ? ' selected' : '').'>Madame</option>
                        <option value="N"'.(($gender == Gender::Unspecified || isset($genderError)) ? ' selected' : '').'>Autre / Ne veut pas préciser</option>
                    </select>';
                    ?>
                    <label for="gender">Civilité</label>
                    <br>
                    <?php if($genderError) echo "<span class='error'>$genderError</span>"; ?>
                </div>

                <div class="input-box">
                    <input type="text" name="name" id="name" placeholder=" " <?php if(isset($name)) echo "value='$name'";?> required>
                    <label for="name">Nom</label>
                    <?php if($nameError) echo "<span class='error'>$nameError</span>"; ?>
                </div>

                <div class="input-box">
                    <input type="text" name="surname" id="surname" placeholder=" " <?php if(isset($surname)) echo "value='$surname'";?> required>
                    <label for="surname">Prénom</label>
                    <?php if($surnameError) echo "<span class='error'>$surnameError</span>"; ?>
                </div>

                <div class="input-box">
                    <input type="email" name="email" id="email" placeholder=" " <?php if(isset($email)) echo "value='$email'";?> required>
                    <label for="email">Adresse email</label>
                    <?php if($emailError) echo "<span class='error'>$emailError</span>"; ?>
                </div>

                <div class="input-box">
                    <input type="password" id="password" name="password" placeholder=" " required>
                    <label for="password">Mot de passe</label>
                    <?php if($passwordError) echo "<span class='error'>$passwordError</span>"; ?>
                </div>

                <div class="input-box force-anim">
                    <input type="date" id="birth" name="date" min="1000-01-01" max="9999-12-31" <?php if(isset($date)) echo "value='$date'";?> required>
                    <label>Date de naissance</label>
                    <?php if($dateError) echo "<span class='error'>$dateError</span>"; ?>
                </div>

                <div class="conditions-accept">
                    <label class="check-box">
                        <input type="checkbox" name="accept">
                        <svg viewBox="0 -5 64 64">
                            <path d="M 0 16 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 16 L 32 48 L 64 16 V 8 A 8 8 90 0 0 56 0 H 8 A 8 8 90 0 0 0 8 V 56 A 8 8 90 0 0 8 64 H 56 A 8 8 90 0 0 64 56 V 16" pathLength="575.0541381835938" class="path"></path>
                        </svg>
                    </label>
                    <p>
                        J'accepte les <a href="/conditions">conditions générales</a> d'inscription
                    </p>
                </div>
                <?php if($acceptError) echo "<span class='error'>$acceptError</span>"; ?>

                <div class="btn">
                    <button type="submit" name="register" class="signupbtn" value="register">S'inscrire</button>
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