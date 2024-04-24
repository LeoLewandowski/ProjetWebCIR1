<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once ('../util/common.php');
    if(empty($userInfo)) header('location: ./login?redirect=contact');
    getPageHead('Contactez-nous', 'login');
    ?>
</head>

<body>
    <?php
    getPageHeader('contact');
    ?>

    <main>
        <form class="formLetter" method="post" action="#">
            <h6 class="title">Laisser un commentaire</h6>

            <div class="input-box">
                <input type="email" name="email" id="email" placeholder=" " required>
                <label for="email">Email</label>
            </div>

            <div class="input-box"> 
                <textarea rows="12" cols="50" id="message" placeholder=" " name="message" required></textarea>
                <label for="message">Votre message</label>
            </div>

            <input type="submit" class="signupbtn" value="Send">
        </form>
    </main>

    <?php
    getPageFooter();
    ?>
</body>

</html>