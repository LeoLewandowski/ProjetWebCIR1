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
        <form class="newsletter" method="post" action="#">
            <fieldset> <!-- la balise fieldset peut être utilisé pour regrouper un ensemble de champs -->
                <legend>Laisser un commentaire</legend>
                <label for="courriel">Email :</label>
                <input type="email" name="courriel" id="courriel" placeholder="Votre mail" required="required">
                <br><br>
                <label for="mdp">Votre commentaire :</label>
                <textarea rows="12" cols="50" id="commentaire" name="commentaire" required="required"></textarea>
                <br><br>
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