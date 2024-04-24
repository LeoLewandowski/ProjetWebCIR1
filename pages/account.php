<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once ('../util/connection.php');
    require_once ('../util/common.php');
    require_once ('../util/validate.php');

    // Si l'utilisateur n'est pas connecté, on le redirge vers la page de connexion
    if (empty($userInfo)) header('location:./login');

    // Définit les messages d'erreur à utiliser plus tard
    $genderError = null;
    $nameError = null;
    $surnameError = null;
    $emailError = null;
    $dateError = null;
    $pfpError = null;

    // Définit les valeurs à utiliser pour auto-remplir la page (ou pour la vérification)
    $gender = null;
    $name = null;
    $surname = null;
    $email = null;
    $date = null;
    $pfp = null;

    // Si l'utilisateur a rempli le form pour modifier son compte :
    if (isset($_POST['updateAccount'])) {
        // Définit les données à vérifier
        if (array_key_exists('gender', $_POST))
            $gender = Gender::tryFrom($_POST['gender']);
        if (array_key_exists('name', $_POST))
            $name = cleanData($_POST['name']);
        if (array_key_exists('surname', $_POST))
            $surname = cleanData($_POST['surname']);
        if (array_key_exists('date', $_POST))
            $date = $_POST['date'];
        if (array_key_exists('email', $_POST))
            $email = $_POST['email'];
        if (array_key_exists('pfp', $_FILES))
            $pfp = $_FILES['pfp'];

        // ----------------------- Tests de validité des différentes valeurs données -----------------------
    
        // Si le genre n'est pas une des options dans l'enum (H, F, ou N), alors la variable $gender est unset
        // Permet d'éviter l'injection en cas de valeurs possibles modifiées côté client
        if (!isset($gender))
            $genderError = _(Localization::VALUE_INVALID->value);

        if (!validateName($name))
            $nameError = _(Localization::NAME_INVALID->value);
        if (!validateName($surname))
            $surnameError = _(Localization::NAME_INVALID->value);

        if (!validateEmail($email))
            $emailError = _(Localization::EMAIL_INVALID->value);

        if (!validateDate($date))
            $dateError = _(Localization::DATE_INVALID->value);

        // S'il n'y a aucune erreur, alors on modifie les paramètres du compte
        if (
            !isset($genderError)
            && !isset($nameError)
            && !isset($surnameError)
            && !isset($emailError)
            && !isset($dateError)
        ) {
            // On vérifie si un utilisateur avec le même email n'exste pas déjà
            $check = $connection->prepare("SELECT email FROM accounts WHERE email = ?");
            $check->execute([$email]);
            if (count($check->fetchAll()) > 0)
                $emailError = _(Localization::EMAIL_USED->value);
            else {
                // On enregistre les infos de l'utilisateur dans la BDD
                $stmt = $connection->prepare("UPDATE accounts SET `gender` = ?, `name` = ?, `surname` = ?, `password` = ?, `email` = ?, `birth` = ?, `admin` = ?, `pfp` = ? WHERE email =?");
                $stmt->execute([$gender->value, $name, $surname, $userInfo['password'], $email, $date, $userInfo['admin'], $pfpName, $email]);

                // On enregistre l'email de l'utilisateur dans des cookies
                setcookie('email', $email);

                header('location:/');
            }
        }
    }

    getPageHead('Compte - Paramètres', 'account');
    ?>
    <style src="/css/login.css"></style>
    <script>
        function updateImage(files) {
            const [f] = files;
            if (f) document.getElementById('pfp-preview').src = URL.createObjectURL(f);
        }
    </script>
</head>

<body>
    <?php
    getPageHeader();
    ?>
    <h1><?php echo _(Localization::GREETING->value) . $userInfo['surname'] . ' ' . $userInfo['name'] ?></h1>
    <main>
        <menu class="form-generic formLetter">
            <a href="#account-info"><?php echo _(Localization::ACCOUNT_INFOS->value) ?></a>
            <a href="#danger-zone"><?php echo _(Localization::DANGER_ZONE->value) ?></a>
        </menu>
        <div id="main-object">
            <form class="form-generic" action="#account-info" method="post">
                <span class="scroll-anchor" id="account-info"></span>
                <h3><?php echo _(Localization::ACCOUNT_INFOS->value) ?></h3>
                <div class="error-wrapper">
                    <div id="pfp-container">
                        <img id="pfp-preview" src="/images/pfp/<?= $userInfo['id'] . '.' . $userInfo['pfp_extension']?>">
                        <div id="pfp-overlay" onclick="document.getElementById('pfp-input').click()">
                            <input id="pfp-input" type="file" hidden onchange="updateImage(this.files)" accept="image/jpg, image/jpeg, image/png, image/webp, image/gif">
                            <label><?= _('Change profile picture') ?></label>
                        </div>
                    </div>
                </div>
                <div class="error-wrapper">
                    <div class="input-box force-anim">
                        <?php
                        $gender = Gender::tryFrom($userInfo['gender']) ?? Gender::Unspecified;
                        ?>
                        <select name="gender" id="gender">
                            <option value="N" <?= ($gender == Gender::Unspecified || isset($genderError)) ? ' selected' : '' ?>> <?= _(Localization::GENDER_NEUTRAL->value) ?></option>
                            <option value="M" <?= ($gender == Gender::Male && !isset($genderError)) ? ' selected' : '' ?>>
                                <?= _(Localization::GENDER_MALE->value) ?> </option>
                            <option value="F" <?= ($gender == Gender::Female && !isset($genderError)) ? ' selected' : '' ?>> <?= _(Localization::GENDER_FEMALE->value) ?></option>
                        </select>
                        <label for="gender"><?= _(Localization::GENDER_CIVILITY->value) ?></label>
                    </div><?php if ($genderError)
                        echo "<span class='error'>$genderError</span>"; ?>
                </div>

                <div class="error-wrapper">
                    <div class="input-box">
                        <input type="text" name="name" id="name" placeholder=" " <?php if (isset($userInfo['name']))
                            echo "value='$userInfo[name]'"; ?> required>
                        <label for="name">Nom</label>
                    </div><?php if ($nameError)
                        echo "<span class='error'>$nameError</span>"; ?>
                </div>

                <div class="error-wrapper">
                    <div class="input-box">
                        <input type="text" name="surname" id="surname" placeholder=" " <?php if (isset($userInfo['surname']))
                            echo "value='$userInfo[surname]'"; ?> required>
                        <label for="surname">Prénom</label>
                    </div><?php if ($surnameError)
                        echo "<span class='error'>$surnameError</span>"; ?>
                </div>

                <div class="error-wrapper">
                    <div class="input-box">
                        <input type="email" name="email" id="email" placeholder=" " <?php if (isset($userInfo['email']))
                            echo "value='$userInfo[email]'"; ?> required>
                        <label for="email">Adresse email</label>
                    </div><?php if ($emailError && isset($_POST['signup']))
                        echo "<span class='error'>$emailError</span>"; ?>
                </div>

                <div class="error-wrapper">
                    <div class="input-box force-anim">
                        <input type="date" id="birth" name="date" min="1000-01-01" max="<?= date('Y-m-d') ?>" <?php if (isset($userInfo['birth']))
                              echo "value='$userInfo[birth]'"; ?> required>
                        <label>Date de naissance</label>
                    </div><?php if ($dateError)
                        echo "<span class='error'>$dateError</span>"; ?>
                </div>

                <input type="submit" name="updateAccount" value="<?= _('Apply changes') ?>">
            </form>

            <hr>

            <h3>Test</h3>
        </div>
    </main>

    <?php
    getPageFooter();
    ?>
</body>

</html>