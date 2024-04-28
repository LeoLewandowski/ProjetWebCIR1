<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');

// Si l'utilisateur n'est pas admin, on affiche la page 404 à la place
if (!$userInfo['admin']) {
    require ('../404.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');
    getPageHead('L\'équipe Octime', 'team')
        ?>
    <link rel="stylesheet" href="../../css/messages.css">
</head>
<body>
    <?php
    getPageHeader('contact', $userInfo);
    ?>

    <main>
    <div class="input-box">
            <input type="text" placeholder=" ">
            <label><?= _('Search for messages') ?></label>
        </div>
        <?php
        $req = "SELECT messages.subject, messages.content, messages.img_extension, messages.id, accounts.name, accounts.surname, accounts.email
        FROM messages 
        JOIN accounts ON messages.user_id = accounts.id";
        $stmt = $connection->prepare($req);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $res){ ?>
            <br>
            <div class='message'>
            <span><?= _('Name') ?> :</span> <?= $res['name'] ?>
            <br>
            <span><?= _('Surname') ?> :</span> <?= $res['surname'] ?>
            <br>
            <span><?= _('Email') ?> :</span> <?= $res['email'] ?>
            <br><br>
            <span><?= _('Subject') ?> :</span> <?= $res["subject"] ?>
            <br><br>
            <span><?= _('Message') ?> :</span>
            <br> <?= $res["content"] ?>
            <br>
            <?php
            if($res["img_extension"] != null){
                $img = '../../images/messages/'.$res["id"].'.'.$res["img_extension"];
                echo "<br>";
                echo "<img src='$img'/>";
            } ?>
            </div>
            <br><br>
        <?php } ?>
    </main>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>
</html>