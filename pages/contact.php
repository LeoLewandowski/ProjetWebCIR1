<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once('../util/common.php');
    getPageHead('Contactez-nous', 'login');
    ?>
</head>

<body>
    <?php
    getPageHeader('contact');
    ?>

    <main>
        <form class="formLetter" method="post" action="#">
            <fieldset> <!-- la balise fieldset peut être utilisé pour regrouper un ensemble de champs -->
                <legend>Laisser un commentaire</legend>

                <div class="input-box">
                    <input type="email" name="email" id="email" placeholder=" " required>
                    <label for="email">Email</label>
                </div>

                <div class="input-box">
                    <textarea rows="12" cols="50" id="message" placeholder=" " name="message" required></textarea>
                    <label for="message">Votre message</label>
                </div>

                <div class="btn">
                    <button type="submit" class="signupbtn">Envoyer votre commentaire</button>
                </div>
            </fieldset>
        </form>
    </main>

    <?php
    getPageFooter();
    ?>
</body>

</html>