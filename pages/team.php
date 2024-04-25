<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');
    getPageHead('L\'équipe Octime', 'team')
        ?>
</head>

<body>
    <?php
    getPageHeader('team', $userInfo);
    ?>

    <main>
        <h1> Notre équipe </h1>
        <h4> Ce site vous est présenté et est rendu possible par notre fine équipe de programmeurs de l'ISEN.</h4>
        <div class="pfp">
            <div>
                <span class="rond"> Lead <br>
                    Création des pages accueil et produits <br>
                    Création du logo <br>
                    Aide globale </span>
                <img src="/images/pfp_leo.gif">
                <h5> Lewandowski Léo </h5>
            </div>
            <div>
                <span class="rond"> Ecriture du site <br>
                    Création des pages présentation et accueil</span>
                <img src="/images/pfp_mathis.png">
                <h5>Van Uytvanck Mathis</h5>
            </div>
            <div>
                <span class="rond">
                    Création des pages connexion et inscription<br>
                    Ecriture du rapport
                </span>
                <img src="/images/pfp_simon.gif">
                <h5>Leroy Simon</h5>
            </div>
            <div>
                <span class="rond">
                    Création de la page équipe <br>
                    Direction artistique
                </span>
                <img src="/images/pfp_adele.png">
                <h5>Lebrun Adèle</h5>
            </div>
            <div>
                <span class="rond">
                    Création de la page contact, concept et conditions
                </span>
                <img src="/images/pfp_sasha.png">
                <h5> Le Roux Zielinski Sasha </h5>
            </div>
        </div>

    </main>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>