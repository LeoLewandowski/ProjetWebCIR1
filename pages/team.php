<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once('../util/common.php');
    getPageHead('L\'équipe Octime', 'team')
    ?>
</head>

<body>
    <?php
    getPageHeader('team');
    ?>
    
    <main>
        <h1> Notre équipe </h1>
        <div class="pfp">
            <div>
                <span class="rond">Blablablabl ablablab lablablabl ablablablablabla blablablab lablablablablabl
                    ablablabl ablabla blabla</span>
                <img src="/images/pfp_leo.gif">
                <h5> Lewandowski Léo </h5>
            </div>
            <div>
                <span class="rond">Qqch d'écrit ici</span>
                <img src="/images/pfp_mathis.png">
                <h5>Van Uytvanck Mathis</h5>
            </div>
            <div>
                <span class="rond">
                    Normalement c'est
                    <br>
                    multiline
                </span>
                <img src="/images/pfp_simon.gif">
                <h5>Leroy Simon</h5>
            </div>
            <div>
                <span class="rond">
                    On pourra changer le style si vous préférez
                </span>
                <img src="/images/pfp_adele.png">
                <h5>Lebrun Adèle</h5>
            </div>
            <div>
                <span class="rond">
                    Mais au moins l'anim est faite
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