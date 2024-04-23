<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once ('../util/common.php');
    require_once ('../util/connection.php');
    require_once ('../util/validate.php');

    // if (empty($userInfo)) header('location:./login');

    getPageHead('Compte - Paramètres', 'account');
    ?>
    <style src="/css/login.css"></style>
</head>

<body>
    <?php
    getPageHeader();
    ?>
    <h1><?php echo _(Localization::GREETING->value) . $userInfo['surname'] . ' ' . $userInfo['name'] ?></h1>
    <main>
        <menu>
            <a href="#account-info"><?php echo _(Localization::ACCOUNT_INFOS->value) ?></a>
        </menu>
        <form class="form-generic">
            <h3 id="account-info"><?php echo _(Localization::ACCOUNT_INFOS->value) ?></h3>
            <div class="input-box force-anim">
                <?php
                $gender = Gender::tryFrom($userInfo['gender']) ?? Gender::Unspecified;
                echo '<select name="gender" id="gender">
                        <option value="M"' . (($gender == Gender::Male) ? ' selected' : '') . '>Monsieur</option>
                        <option value="F"' . (($gender == Gender::Female) ? ' selected' : '') . '>Madame</option>
                        <option value="N"' . (($gender == Gender::Unspecified) ? ' selected' : '') . '>Autre / Ne veut pas préciser</option>
                    </select>';
                ?>
                <label for="gender">Civilité</label>
            </div>

            <div class="input-box">
                <input type="text" name="name" id="name" placeholder=" " <?php if (isset($userInfo['name']))
                    echo "value='$userInfo[name]'"; ?> required>
                <label for="name">Nom</label>
            </div>

            <div class="input-box">
                <input type="text" name="surname" id="surname" placeholder=" " <?php if (isset($userInfo['surname']))
                    echo "value='$userInfo[surname]'"; ?> required>
                <label for="surname">Prénom</label>
            </div>

            <div class="input-box">
                <input type="email" name="email" id="email" placeholder=" " <?php if (isset($userInfo['email']))
                    echo "value='$userInfo[email]'"; ?> required>
                <label for="email">Adresse email</label>
            </div>

            <div class="input-box force-anim">
                <input type="date" id="birth" name="date" min="1000-01-01" max="<?php echo date('Y-m-d') ?>" <?php if (isset($userInfo['birth'])) echo "value='$userInfo[birth]'"; ?> required>
                <label>Date de naissance</label>
            </div>

            <input type="submit" value="<?= _('Apply changes') ?>">
        </form>
    </main>

    <?php
    getPageFooter();
    ?>
</body>

</html>