<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once ('../util/common.php');
    getPageHead('Concept', 'concept');
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Update les horloges toutes les secondes
            setInterval(updateConversion, 1000);

            // Initialisation de l'horloge
            updateConversion();

            // Dessine les aiguilles des 2 horloges
            drawLines(document.getElementById('clock-2'), 60, 5);
            drawLines(document.getElementById('clock-1'), 40, 5);
        })

        // Renvoie un temps octal à partir d'un élément Date
        function getOctTime(dt) {
            const time = Math.round(dt.getTime() / 1000);
            const hour = dt.getHours();
            const trinute = Math.floor((time % 3600) / 90);
            const second = Math.floor(time % 90);
            return [hour, trinute, second]
        }

        // Renvoie un string de temps sous format 24h à partir d'une Date
        function h24(dt) {
            let add = " heures (du matin),<br>";
            if (dt.getHours() > 12) add = `heures,<br>&emsp;C'est-à-dire ${dt.getHours() - 12} heures de l'après-midi,<br>`;
            return `${dt.getHours()} ${add}
            ${dt.getMinutes()} minutes,<br>
            ${dt.getSeconds()} secondes.<br>`;
        }

        // Renvoie un string de temps sous format 8h à partir d'une Date
        function h8(dt) {
            let add = `${dt[0]} heure premières`;
            if (dt[0] > 16) add = `${dt[0] - 16} heures hexales`;
            else if (dt[0] > 8) add = `${dt[0] - 8} heures octales`;
            return `${add},<br>
            ${dt[1]} trinutes,<br>
            ${dt[2]} secondes.<br>`;
        }

        // Mets à jour les horloges toutes les secondes
        function updateClock(dt, odt) {

            // HEURE OCTALE
            secondRatio = odt[2] / 90;
            minuteRatio = (odt[1] + secondRatio) / 40;
            hourRatio = (odt[0] + minuteRatio) / 8;

            setRotation('secondHand', secondRatio);
            setRotation('minuteHand', minuteRatio);
            setRotation('hourHand', hourRatio);

            // HEURE CLASSIQUE
            secondRatio = dt.getSeconds() / 60;
            minuteRatio = (secondRatio + dt.getMinutes()) / 60;
            hourRatio = (minuteRatio + dt.getHours()) / 12;
            setRotation('secondHand2', secondRatio);
            setRotation('minuteHand2', minuteRatio);
            setRotation('hourHand2', hourRatio);

        }

        function setRotation(elementID, rotationRatio) {
            document.getElementById(elementID).style.transform = `rotate(${rotationRatio * 360}deg)`;
        }

        function updateConversion() {
            const ts = Math.floor(Date.now() / 1000); // Temps actuel en secondes
            const dt = new Date(ts * 1000);
            const odt = getOctTime(dt);
            updateClock(dt, odt);

            // Mets à jour les paragraphes HTML avec la bonne date
            document.getElementById("format24").innerHTML = h24(dt);
            document.getElementById("format8").innerHTML = h8(odt);

            // Mets à jour l'horloge 12h
            document.getElementById("format24-hms").innerHTML = `
                ${dt.getHours().toString().padStart(2, '0')} :
                ${dt.getMinutes().toString().padStart(2, '0')} :
                ${dt.getSeconds().toString().padStart(2, '0')}
                <br>&emsp;ou<br> 
                ${(dt.getHours() % 12).toString().padStart(2, '0')} :
                ${dt.getMinutes().toString().padStart(2, '0')} :
                ${dt.getSeconds().toString().padStart(2, '0')} 
                ${dt.getHours() > 12 ? "de l'après-midi" : "du matin"}
                `;

            // Update l'horloge 8h
            document.getElementById("format8-hts").innerHTML = `
                ${odt[0].toString().padStart(2, '0')} :
                ${odt[1].toString().padStart(2, '0')} :
                ${odt[2].toString().padStart(2, '0')}
                <br>&emsp;ou<br> 
                ${(odt[0] % 8).toString().padStart(2, '0')}:
                ${odt[1].toString().padStart(2, '0')} :
                ${odt[2].toString().padStart(2, '0')} 
                ${odt[0] > 8 ? (odt[0] > 16 ? 'H (Hexale)' : 'O (Octale)') : 'M (Midenalle)'}
                `;
        }

        // Fonction pour dessiner n lignes sur l'horloge données. Toutes les dn lignes,
        // un plus gros trait sera dessiné, avec un nombre pour la marquer en plus
        function drawLines(clock, n, dn) {
            const delta = 360 / n, startAngle = -90;
            for (let i = 0; i < n; i++) {
                if (!(i % dn)) clock.innerHTML += `<span class="number" style="--angle:${i * delta + startAngle}deg;">${i ? i / dn : n / dn}</span>`;
                clock.innerHTML += `<span class="line ${!(i % dn) ? 'big' : ''}" style="--angle:${i * delta + startAngle}deg;"></span>`;
            }
        }
    </script>
</head>

<body>
    <section class="banner parallax" style="--src:url(/images/mechanism.jpg)">
        <h1>Une toute nouvelle façon de voir le temps</h1>
        <a href="#nav"></a>
        <span class="transition"></span>
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
            <p id="format8"></p>
            <p id="format8-hts"></p> <!-- HH:TT:SS -->
            <div id="clock-1" class="clock">
                <div class="hand hour" id="hourHand"></div>
                <div class="hand minute" id="minuteHand"></div>
                <div class="hand second" id="secondHand"></div>
            </div>
        </div>
        <div>
            <h3>Format d'heure classique</h3>
            <p id="format24"></p>
            <p id="format24-hms"></p> <!-- HH:MM:SS -->
            <div id="clock-2" class="clock">
                <div class="hand hour" id="hourHand2"></div>
                <div class="hand minute" id="minuteHand2"></div>
                <div class="hand second" id="secondHand2"></div>
            </div>
        </div>
    </section>

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>