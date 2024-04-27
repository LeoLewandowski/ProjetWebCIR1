<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');

// Si l'utilisateur n'est pas connecté on lui demande de se connecter, puis on le redirige
// Sur la page contact une fois qu'il est connecté
if (empty($userInfo))
    header('location: ./login?redirect=contact');

// Si l'utilisateur est un admin, on le redirige vers la page de visualisation des messages
if($userInfo['admin'])
    header('location: /admin/messages');

// Erreurs
$subjectError = $contentError = $imgError = null;

$subject = $content = $img = null;

if (isset($_POST['send'])) {
    if (isset($_POST['subject']))
        $subject = cleanData($_POST['subject']);
    else
        $subjectError = _('Please write the subject of your message');

    if (isset($_POST['content']))
        $content = cleanData($_POST['content']);
    else
        $contentError = _('Please write the content of your message');

    $postId = uniqid('', true);
    $extension = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] != 4) {
        $img = $_FILES['image'];
        // On vérifie que le fichier soit d'une taille acceptable
        if ($img['error'] == 2 || $img['error'] == 1 || $img['size'] > 30_000_000) {
            $img = null;
            $imgError = _('The picture\'s size must not exceed 30MB');
        } else {
            [$type, $extension] = explode('/', $img['type']);
            // On vérifie que le fichier soit bien une image
            if ($type != 'image') {
                $img = null;
                $imgError = _('This file is not a valid image !');
            } else {
                // Déplace l'image au bon endroit
                $valid = move_uploaded_file($img['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/images/messages/' . $postId . '.' . $extension);

                // Si une erreur est apparue
                if (!$valid)
                    $imgError = _('Sorry, an unknown error occured');
            }
        }
    }

    if(empty($subjectError) && empty($contentError) && empty($imgError)) {
        $stmt = $connection->prepare("INSERT INTO messages (subject, content, img_extension, id, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$subject, $content, $extension, $postId, $userInfo['id']]);
        $_SESSION['message_sent'] = true;
        header('location:./contact');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    getPageHead(_('Contact us'), 'login');
    ?>
    <script src="/util/imageChange.js"></script>
</head>

<body>
    <?php
    getPageHeader('contact', $userInfo);
    ?>

    <main>
        <form class="formLetter" enctype="multipart/form-data" method="post" action="#">
            <h6 class="title"> <?= _('Leave a comment') ?></h6>
            <?php
            if(isset($_SESSION['message_sent'])){
                echo '<span class="confirm">' . _("Message sent to the admins !") . '</span>';
                $_SESSION['message_sent'] = null;
            }
            ?>
            <div class="error-wrapper">
                <div class="input-box">
                    <input type="text" name="subject" placeholder=" " value="<?php if (isset($subject))
                        echo $subject; ?>" required>
                    <label><?= _('Subject') ?></label>
                </div>
                <?php if (isset($subjectError))
                    echo $subjectError; ?>
            </div>

            <div class="error-wrapper">
                <div class="input-box">
                    <textarea rows="12" cols="50" id="message" placeholder=" " name="content" required><?php if (isset($content))
                        echo $content; ?></textarea>
                    <label for="message"><?= _('Your message') ?></label>
                </div>
                <?php if (isset($contentError))
                    echo $contentError; ?>
            </div>

            <div class="error-wrapper">
                <div id="imgDisplay" class="display-box">
                    <img id="image" src='/images/placeholder.svg'>
                    <div id="imgOverlay" onclick="document.getElementById('imgInput').click()">
                        <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
                        <input id="imgInput" type="file" name="image" hidden onchange="updateImage(this.files, 'image')"
                            accept="image/png, image/jpg, images/jpeg, image/gif, image/webp">
                        <p>Change image</p>
                    </div>
                </div>
                <?php if (isset($imgError))
                    echo $imgError; ?>
            </div>

            <input type="submit" name="send" class="signupbtn" value="<?= _('Send') ?>">
        </form>
    </main>

    <?php
    getPageFooter();
    ?>
</body>

</html>