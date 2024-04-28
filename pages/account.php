<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');

    // Si l'utilisateur n'est pas connecté, on le redirge vers la page de connexion
    if (empty($userInfo))
        header('location:./login');

    // Messages de confirmation
    $updateConfirm = null;
    $sessionConfirm = null;
    $langConfirm = null;
    $warning = null;

    // Définit les messages d'erreur à utiliser plus tard
    $genderError = null;
    $nameError = null;
    $surnameError = null;
    $emailError = null;
    $dateError = null;
    $pfpError = null;
    $langError = null;

    // Définit les valeurs à utiliser pour auto-remplir la page (ou pour la vérification)
    $gender = null;
    $name = null;
    $surname = null;
    $email = null;
    $date = null;
    $pfp = null;

    // Affiche le message de confirmation des changements
    if (isset($_SESSION['updateAccount'])) {
        $updateConfirm = _('Changes saved !');
        $_SESSION['updateAccount'] = null;
    }

    // Affiche le message de confirmation de modification de langue
    if (isset($_SESSION['langUpdated'])) {
        $langConfirm = _('Language updated !');
        $_SESSION['langUpdated'] = null;
    }

    // Si l'utilisateu a changé sa langue d'affichage
    if (isset($_POST['updateLang'])) {
        $tryLang = null;
        if (isset($_POST['language'])) {
            $tryLang = Language::tryFrom($_POST['language']);
        }
        if ($tryLang == null)
            $langError = _('The language you provided is not supported ! Please choose from the options above');
        else {
            $_SESSION['langUpdated'] = true;
            setcookie('lang', $tryLang->value, time() + 60 * 60 * 24 * 365);
            header('location:#session');
        }
    }

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

        // Vérifie si la photo de profil a été donnée parmi les infos
        if (array_key_exists('pfp', $_FILES) && $_FILES['pfp']['error'] != 4) {
            $pfp = $_FILES['pfp'];
            // On vérifie que le fichier soit d'une taille acceptable
            if ($pfp['error'] == 2 || $pfp['error'] == 1 || $pfp['size'] > 30_000_000) {
                $pfp = null;
                $pfpError = _('The picture\'s size must not exceed 30MB');
            } else {
                [$type, $extension] = explode('/', $pfp['type']);
                // On vérifie que le fichier soit bien une image
                if ($type != 'image') {
                    $pfp = null;
                    $pfpError = _('This file is not a valid image !');
                } else {
                    $invalid = true;
                    $pfpName = '../images/pfp/' . $userInfo['id'] . '.';

                    // Supprime la photo de profil précédente si elle existe
                    if (file_exists($pfpName . $userInfo['pfp_extension']))
                        $invalid = unlink($pfpName . $userInfo['pfp_extension']);

                    // Enregistre la nouvelle extension de photo de profil
                    $stmt = $connection->prepare("UPDATE accounts SET pfp_extension = ? WHERE id = ?");
                    $invalid = $invalid && $stmt->execute([$extension, $userInfo['id']]);

                    // Déplace l'image au bon endroit
                    $invalid = $invalid && move_uploaded_file($pfp['tmp_name'], $pfpName . $extension);

                    // Si une erreur est apparue
                    if (!$invalid)
                        $pfpError = _('Sorry, an unknown error occured');
                }
            }
        }

        // ----------------------- Tests de validité des différentes valeurs données -----------------------
    
        // Si le genre n'est pas une des options dans l'enum (H, F, ou N), alors la variable $gender est unset
        // Permet d'éviter l'injection en cas de valeurs possibles modifiées côté client
        if (!isset($gender))
            $genderError = _('This option is invalid, please choose another one');

        if (!validateName($name))
            $nameError = _('This name is invalid. Names must only contain word characters or ideogras, hyphens and apostrophes, and be shorter than 64 characters');
        if (!validateName($surname))
            $surnameError = _('This name is invalid. Names must only contain word characters or ideogras, hyphens and apostrophes, and be shorter than 64 characters');

        if (!validateEmail($email))
            $emailError = _('The given email adress is invalid, or it is longer than 64 characters');

        if (!validateDate($date))
            $dateError = _('The given date must be between today and 1900/01/01');

        // S'il n'y a aucune erreur, alors on modifie les paramètres du compte
        // Le compte existe forcément déjà, car userInfo est défini
        if (
            !isset($genderError)
            && !isset($nameError)
            && !isset($surnameError)
            && !isset($emailError)
            && !isset($dateError)
            && !isset($pfpError)
        ) {
            // On enregistre les infos de l'utilisateur dans la BDD
            $stmt = $connection->prepare("UPDATE accounts SET `gender` = ?, `name` = ?, `surname` = ?, `password` = ?, `email` = ?, `birth` = ?, `admin` = ? WHERE id = ?");
            $res = $stmt->execute([$gender->value, $name, $surname, $userInfo['password'], $email, $date, $userInfo['admin'], $userInfo['id']]);
            $_SESSION['updateAccount'] = true;
            header('location:#account-info');
        }
    }

    // Si l'utilisateur désire se déconnecter
    if (isset($_POST['disconnect']))
        disconnect();

    // Si l'utilisateur désire supprimer son panier
    if (isset($_POST['emptyCart'])) {
        $stmt = $connection->prepare("DELETE FROM shopping_carts WHERE client_id = ?");
        $stmt->execute([$userInfo['id']]);
        $sessionConfirm = _('Your cart was successfully emptied !');
    }

    // Si l'utilisateur désire supprimer son compte
    if (isset($_POST['deleteAccount']))
        $warning = _('Are you sure you want to delete your account ? This operation cannot be undone.');

    // Si l'utilisateur a confirmé la suppression de son compte
    if (isset($_POST['deleteAccountConfirm'])) {
        // Tout d'abord on supprime le panier
        $stmt = $connection->prepare("DELETE FROM shopping_carts WHERE client_id = ?");
        $stmt->execute([$userInfo['id']]);

        // Puis la photo de profil
        unlink(realpath('../images/pfp/' . $userInfo['id'] . '.' . $userInfo['pfp_extension']));

        // Les messages envoyés dans la section `contact`
        $stmt = $connection->prepare("DELETE FROM messages WHERE user_id = ?");
        $stmt->execute([$userInfo['id']]);

        // Et enfin, les données utilisateur
        $stmt = $connection->prepare("DELETE FROM accounts WHERE id = ?");
        $stmt->execute([$userInfo['id']]);
        disconnect();
        header('location:/login');
    }

    getPageHead(_('Account - Parameters'), 'account');
    ?>
    <script src="/util/imageChange.js"></script>
</head>

<body>
    <?php
    getPageHeader($userInfo);
    ?>
    <h1><?php echo _('Welcome, ') . $userInfo['surname'] . ' ' . $userInfo['name'] ?></h1>
    <main>
        <menu class="form-generic formLetter">
            <a href="#account-info"><?= _('Account informations') ?></a>
            <a href="#session"><?= _('Session parameters') ?></a>
            <a href="#danger-zone"><?= _('Danger zone') ?></a>
        </menu>
        <div id="main-object">
            <form class="form-generic" enctype="multipart/form-data" action="#account-info" method="post">
                <h3 id="account-info"><?php echo _('Account informations') ?></h3>
                <?php if (isset($updateConfirm))
                    echo '<span class="confirm">' . $updateConfirm . '</span>'; ?>
                <div class="error-wrapper">
                    <div id="pfp-container">
                        <img id="pfp-preview"
                            src="/images/pfp/<?= $userInfo['id'] . '.' . $userInfo['pfp_extension'] ?>">
                        <div id="pfp-overlay" onclick="document.getElementById('pfp-input').click()">
                            <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
                            <input id="pfp-input" type="file" name="pfp" hidden
                                onchange="updateImage(this.files, 'pfp-preview')"
                                accept="image/jpg, image/jpeg, image/png, image/webp, image/gif">
                            <label><?= _('Change profile picture') ?></label>
                        </div>
                    </div>
                    <?php if ($pfpError)
                        echo "<span class='error'>$pfpError</span>" ?>
                    </div>
                    <div class="error-wrapper">
                        <div class="input-box force-anim">
                            <?php
                    $gender = Gender::tryFrom($userInfo['gender']) ?? Gender::Unspecified;
                    ?>
                        <select name="gender" id="gender">
                            <option value="N" <?= ($gender == Gender::Unspecified || isset($genderError)) ? ' selected' : '' ?>> <?= _('Unspecified') ?></option>
                            <option value="M" <?= ($gender == Gender::Male && !isset($genderError)) ? ' selected' : '' ?>>
                                <?= _('Male') ?>
                            </option>
                            <option value="F" <?= ($gender == Gender::Female && !isset($genderError)) ? ' selected' : '' ?>> <?= _('Female') ?></option>
                        </select>
                        <label for="gender"><?= _('Gender') ?></label>
                    </div><?php if ($genderError)
                        echo "<span class='error'>$genderError</span>"; ?>
                </div>

                <div class="error-wrapper">
                    <div class="input-box">
                        <input type="text" name="name" id="name" placeholder=" " <?php if (isset($userInfo['name']))
                            echo "value='$userInfo[name]'"; ?> required>
                        <label for="name"><?= _('Name') ?></label>
                    </div><?php if ($nameError)
                        echo "<span class='error'>$nameError</span>"; ?>
                </div>

                <div class="error-wrapper">
                    <div class="input-box">
                        <input type="text" name="surname" id="surname" placeholder=" " <?php if (isset($userInfo['surname']))
                            echo "value='$userInfo[surname]'"; ?> required>
                        <label for="surname"><?= _('Surname') ?></label>
                    </div><?php if ($surnameError)
                        echo "<span class='error'>$surnameError</span>"; ?>
                </div>

                <div class="error-wrapper">
                    <div class="input-box">
                        <input type="email" name="email" id="email" placeholder=" " <?php if (isset($userInfo['email']))
                            echo "value='$userInfo[email]'"; ?> required>
                        <label for="email"><?= _('Email') ?></label>
                    </div><?php if ($emailError)
                        echo "<span class='error'>$emailError</span>"; ?>
                </div>

                <div class="error-wrapper">
                    <div class="input-box force-anim">
                        <input type="date" id="birth" name="date" min="1000-01-01" max="<?= date('Y-m-d') ?>" <?php if (isset($userInfo['birth']))
                              echo "value='$userInfo[birth]'"; ?> required>
                        <label><?= _('Birth date') ?></label>
                    </div><?php if ($dateError)
                        echo "<span class='error'>$dateError</span>"; ?>
                </div>

                <input type="submit" name="updateAccount" value="<?= _('Apply changes') ?>">
            </form>

            <hr>

            <h3 id="session"><?= _('Session parameters') ?></h3>

            <form class="form-generic" action="#session" method="post">
                <?php if (isset($sessionConfirm))
                    echo '<span class="confirm">' . $sessionConfirm . '</span>'; ?>
                <div class="error-wrapper">
                    <div class="input-box force-anim">
                        <select name="language">
                            <option value="en" <?= (LANGUAGE == Language::English) ? ' selected' : '' ?>> English </option>
                            <option value="fr" <?= (LANGUAGE == Language::French) ? ' selected' : '' ?>> Français </option>
                        </select>
                        <label><?= _('Language') ?></label>
                        <input type="submit" name="updateLang" value="<?= _('Update language') ?>">
                    </div><?php if ($langError)
                        echo "<span class='error'>$langError</span>";
                    if ($langConfirm)
                        echo "<span class='confirm'>$langConfirm</span>"; ?>

                </div>
                <input type="submit" name="emptyCart" value="<?= _('Empty shopping cart') ?>">
                <input type="submit" name="disconnect" value="<?= _('Disconnect') ?>">
                <?= $userInfo['admin'] ? '<a id="admin" href="./admin"><input type="button" name="admin" value="' . _('Access admin page') . '"></a>' : '' ?>
            </form>

            <hr>

            <h3 id="danger-zone"><?= _('Danger zone') ?></h3>

            <form class="form-generic" action="#danger-zone" method="post">
                <?php
                if (isset($warning)) { ?>
                    <span class="warn"> <?= $warning ?></span>
                    <input id="deleteAccount" type="submit" name="deleteAccountConfirm"
                        value="<?= _('Confirm deletion') ?>">
                <?php } else { ?>
                    <input id="deleteAccount" type="submit" name="deleteAccount" value="<?= _('Delete account') ?>">
                <?php } ?>
            </form>
        </div>
    </main>

    <?php
    getPageFooter();
    ?>
</body>

</html>