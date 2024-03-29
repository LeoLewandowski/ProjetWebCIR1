<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once('../util/common.php');
    getPageHead('Concept', 'concept');
    ?>
</head>

<body>
    <section class="banner parallax" style="--src:url(/images/mechanism.jpg)">
        <h1>Une toute nouvelle façon de voir le temps</h1>
        <a href="#nav"></a>
    </section>
    
    <?php
    getPageHeader('concept');
    ?>

    <div class="concept">
        <h2 class="titre"> Le concept d'Octime </h2>
        <p class="p1 elt">Au tout début de son existence, Octime avait déjà pour but de changer la vision des gens sur
            le passage du temps.
            Ses cinq créateurs ont donc décidé de créer une montre qui permettrait de voir le temps passer de manière
            différente, comment ? Venez, on vous montre !
        </p>

        <p class="p2 elt">
            Tout est parti d'un concept simple: Si on peut diviser la journée en 2 périodes de 12 heures, pourquoi ne
            pas pouvoir faire des périodes de 8 heures ?
            C'est ainsi que furent imaginées respectivement les heures Midenalles (entre 0 et 8h en hexal),
            Octales(8h-16h) et Hexales (16h-00h).
            Mais une question s'est posée, comment faire rentrer 60 minutes dans un cadran adapté à 8 heures ?
            Car voilà, dans le système classique, on peut diviser le cadran en petites périodes de 5 minutes, mais dans
            le système Octime, il faut diviser le cadran en périodes de 7,5 minutes.
            C'est comme cela que se posa le premier problème de la création de la montre Octime : Comment faire quelque
            chose d'esthétique ET pratique ?
        </p>
        <p class="p1 elt">
            Ce fut l'ami de l'un d'entre nous, qui trouva la solution : si 12 fois 5 est égal à 60, alors 8 fois 5 est
            égal à 40, pourquoi ne pas faire des trinutes ? des petites périodes de 90 secondes, il y en aurait 40 par
            heure et cela permettrait d'avoir une forme "classique" de cadran.
            Les trois périodes
            Vous êtes perdu ? Pas de panique, on vous montre !
        </p>
        <p class="p2 elt">
            Prenons un exemple : Il est 18h30, soit 6 heures et 30 minutes de l'après-midi. En octal, cela ferait 2h20 H
            (pour "hexale")
            En voici un autre : 15h45 deviendrait 7h30 O (pour "octale")
            Prenez une pause et réflechissez, vous verrez, ce n'est pas si dur !
        </p>
    </div>
    <h2>Exemple</h2>
    <section id="time">
        <div>
            <h3>Format d'heure octal</h3>
            <p>
                22: 21: 78
                <br>&emsp;ou<br>
                06: 21: 78 H (Hexale)
            </p>
            <div id="clock-1" class="clock">
                <div class="hand hour" id="hourHand" style="transform: rotate(1014.6deg);"></div>
                <div class="hand minute" id="minuteHand" style="transform: rotate(196.8deg);"></div>
                <div class="hand second" id="secondHand" style="transform: rotate(312deg);"></div>
                <span class="number" style="--angle:-90deg;">8</span>
                <span class="line big" style="--angle:-90deg;"></span>
                <span class="line " style="--angle:-81deg;"></span>
                <span class="line " style="--angle:-72deg;"></span>
                <span class="line " style="--angle:-63deg;"></span>
                <span class="line " style="--angle:-54deg;"></span>
                <span class="number" style="--angle:-45deg;">1</span>
                <span class="line big" style="--angle:-45deg;"></span>
                <span class="line " style="--angle:-36deg;"></span>
                <span class="line " style="--angle:-27deg;"></span>
                <span class="line " style="--angle:-18deg;"></span>
                <span class="line " style="--angle:-9deg;"></span>
                <span class="number" style="--angle:0deg;">2</span>
                <span class="line big" style="--angle:0deg;"></span>
                <span class="line " style="--angle:9deg;"></span>
                <span class="line " style="--angle:18deg;"></span>
                <span class="line " style="--angle:27deg;"></span>
                <span class="line " style="--angle:36deg;"></span>
                <span class="number" style="--angle:45deg;">3</span>
                <span class="line big" style="--angle:45deg;"></span>
                <span class="line " style="--angle:54deg;"></span>
                <span class="line " style="--angle:63deg;"></span>
                <span class="line " style="--angle:72deg;"></span>
                <span class="line " style="--angle:81deg;"></span>
                <span class="number" style="--angle:90deg;">4</span>
                <span class="line big" style="--angle:90deg;"></span>
                <span class="line " style="--angle:99deg;"></span>
                <span class="line " style="--angle:108deg;"></span>
                <span class="line " style="--angle:117deg;"></span>
                <span class="line " style="--angle:126deg;"></span>
                <span class="number" style="--angle:135deg;">5</span>
                <span class="line big" style="--angle:135deg;"></span>
                <span class="line " style="--angle:144deg;"></span>
                <span class="line " style="--angle:153deg;"></span>
                <span class="line " style="--angle:162deg;"></span>
                <span class="line " style="--angle:171deg;"></span>
                <span class="number" style="--angle:180deg;">6</span>
                <span class="line big" style="--angle:180deg;"></span>
                <span class="line " style="--angle:189deg;"></span>
                <span class="line " style="--angle:198deg;"></span>
                <span class="line " style="--angle:207deg;"></span>
                <span class="line " style="--angle:216deg;"></span>
                <span class="number" style="--angle:225deg;">7</span>
                <span class="line big" style="--angle:225deg;"></span>
                <span class="line " style="--angle:234deg;"></span>
                <span class="line " style="--angle:243deg;"></span>
                <span class="line " style="--angle:252deg;"></span>
                <span class="line " style="--angle:261deg;"></span>
            </div>
        </div>
        <div>
            <h3>Format d'heure classique</h3>
            <p>
                22: 32: 48
                <br>&emsp;ou<br>
                10: 32: 48 de l'après-midi
            </p>

            <div id="clock-2" class="clock">
                <div class="hand hour" id="hourHand2" style="transform: rotate(676.4deg);"></div>
                <div class="hand minute" id="minuteHand2" style="transform: rotate(196.8deg);"></div>
                <div class="hand second" id="secondHand2" style="transform: rotate(288deg);"></div>
                <span class="number" style="--angle:-90deg;">12</span>
                <span class="line big" style="--angle:-90deg;"></span>
                <span class="line " style="--angle:-84deg;"></span>
                <span class="line " style="--angle:-78deg;"></span>
                <span class="line " style="--angle:-72deg;"></span>
                <span class="line " style="--angle:-66deg;"></span>
                <span class="number" style="--angle:-60deg;">1</span>
                <span class="line big" style="--angle:-60deg;"></span>
                <span class="line " style="--angle:-54deg;"></span>
                <span class="line " style="--angle:-48deg;"></span>
                <span class="line " style="--angle:-42deg;"></span>
                <span class="line " style="--angle:-36deg;"></span>
                <span class="number" style="--angle:-30deg;">2</span>
                <span class="line big" style="--angle:-30deg;"></span>
                <span class="line " style="--angle:-24deg;"></span>
                <span class="line " style="--angle:-18deg;"></span>
                <span class="line " style="--angle:-12deg;"></span>
                <span class="line " style="--angle:-6deg;"></span>
                <span class="number" style="--angle:0deg;">3</span>
                <span class="line big" style="--angle:0deg;"></span>
                <span class="line " style="--angle:6deg;"></span>
                <span class="line " style="--angle:12deg;"></span>
                <span class="line " style="--angle:18deg;"></span>
                <span class="line " style="--angle:24deg;"></span>
                <span class="number" style="--angle:30deg;">4</span>
                <span class="line big" style="--angle:30deg;"></span>
                <span class="line " style="--angle:36deg;"></span>
                <span class="line " style="--angle:42deg;"></span>
                <span class="line " style="--angle:48deg;"></span>
                <span class="line " style="--angle:54deg;"></span>
                <span class="number" style="--angle:60deg;">5</span>
                <span class="line big" style="--angle:60deg;"></span>
                <span class="line " style="--angle:66deg;"></span>
                <span class="line " style="--angle:72deg;"></span>
                <span class="line " style="--angle:78deg;"></span>
                <span class="line " style="--angle:84deg;"></span>
                <span class="number" style="--angle:90deg;">6</span>
                <span class="line big" style="--angle:90deg;"></span>
                <span class="line " style="--angle:96deg;"></span>
                <span class="line " style="--angle:102deg;"></span>
                <span class="line " style="--angle:108deg;"></span>
                <span class="line " style="--angle:114deg;"></span>
                <span class="number" style="--angle:120deg;">7</span>
                <span class="line big" style="--angle:120deg;"></span>
                <span class="line " style="--angle:126deg;"></span>
                <span class="line " style="--angle:132deg;"></span>
                <span class="line " style="--angle:138deg;"></span>
                <span class="line " style="--angle:144deg;"></span>
                <span class="number" style="--angle:150deg;">8</span>
                <span class="line big" style="--angle:150deg;"></span>
                <span class="line " style="--angle:156deg;"></span>
                <span class="line " style="--angle:162deg;"></span>
                <span class="line " style="--angle:168deg;"></span>
                <span class="line " style="--angle:174deg;"></span>
                <span class="number" style="--angle:180deg;">9</span>
                <span class="line big" style="--angle:180deg;"></span>
                <span class="line " style="--angle:186deg;"></span>
                <span class="line " style="--angle:192deg;"></span>
                <span class="line " style="--angle:198deg;"></span>
                <span class="line " style="--angle:204deg;"></span>
                <span class="number" style="--angle:210deg;">10</span>
                <span class="line big" style="--angle:210deg;"></span>
                <span class="line " style="--angle:216deg;"></span>
                <span class="line " style="--angle:222deg;"></span>
                <span class="line " style="--angle:228deg;"></span>
                <span class="line " style="--angle:234deg;"></span>
                <span class="number" style="--angle:240deg;">11</span>
                <span class="line big" style="--angle:240deg;"></span>
                <span class="line " style="--angle:246deg;"></span>
                <span class="line " style="--angle:252deg;"></span>
                <span class="line " style="--angle:258deg;"></span>
                <span class="line " style="--angle:264deg;"></span>
            </div>
        </div>
    </section>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>