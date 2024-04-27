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
        <?php
        $req = "SELECT messages.subject, messages.content, messages.img_extension, messages.id, accounts.name, accounts.surname, accounts.email
        FROM messages 
        JOIN accounts ON messages.user_id = accounts.id";
        $stmt = $connection->prepare($req);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($result as $res){
            echo "<br>";
            echo "<div class='message'>";
            echo "<span>Nom :</span>" . " " . $res['name'];
            echo "<br>";
            echo "<span>Prénom :</span>" . " " . $res['surname'];
            echo "<br>";
            echo "<span>Email :</span>" . " " . $res['email'];
            echo "<br><br>";
            echo "<span>Sujet :</span>" . " " . $res["subject"];
            echo "<br><br>";
            echo "<span>Message :</span>";
            echo "<br>";
            echo $res["content"];
            echo "<br>";
            if($res["img_extension"] != null){
                $img = '../../images/messages/'.$res["id"].'.'.$res["img_extension"];
                echo "<br>";
                echo "<img src='$img'/>";
            }
            echo "</div>";
            echo "<br><br>";
        }
        ?>
    </main>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>
</html>