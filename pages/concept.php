<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');
    getPageHead('Concept', 'concept');
    ?>
    <script>
        const OR = "<?= _('or') ?>";
        const PM = "<?= _('PM') ?>";
        const AM = "<?= _('AM') ?>";
        const midenal = "<?= _('Midenal') ?>";
        const octal = "<?= _('Octal') ?>";
        const hexal = "<?= _('Hexal') ?>";

        document.addEventListener('DOMContentLoaded', () => {
            // Update les horloges toutes les secondes
            setInterval(updateConversion);

            // Initialisation de l'horloge
            updateConversion();

            // Dessine les aiguilles des 2 horloges
            drawLines(document.getElementById('clock-2'), 60, 5);
            drawLines(document.getElementById('clock-1'), 40, 5);
        });

        // Renvoie un temps octal à partir d'un élément Date
        function getOctTime(dt) {
            const time = dt.getTime() / 1000;
            const hour = dt.getHours();
            const trinute = Math.floor((time % 3600) / 90);
            const second = time % 90;
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
            else if (dt[0] >= 8) add = `${dt[0] - 8} heures octales`;
            return `${add},<br>
            ${dt[1]} trinutes,<br>
            ${Math.floor(dt[2])} secondes.<br>`;
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
            secondRatio = (dt.getMilliseconds() / 1_000 + dt.getSeconds()) / 60;
            minuteRatio = (secondRatio + dt.getMinutes()) / 60;
            hourRatio = (minuteRatio + dt.getHours()) / 12;
            setRotation('secondHand2', secondRatio);
            setRotation('minuteHand2', minuteRatio);
            setRotation('hourHand2', hourRatio);

        }

        function setRotation(elementID, rotationRatio) {
            document.getElementById(elementID).style.rotate = `${rotationRatio * 360}deg`;
        }

        function updateConversion() {
            const dt = new Date();
            const odt = getOctTime(dt);
            updateClock(dt, odt);

            // Mets à jour l'horloge 12h
            document.getElementById("format24-hms").innerHTML = `
                ${dt.getHours().toString().padStart(2, '0')} :
                ${dt.getMinutes().toString().padStart(2, '0')} :
                ${dt.getSeconds().toString().padStart(2, '0')}
                <br>&emsp;${OR}<br> 
                ${(dt.getHours() % 12).toString().padStart(2, '0')} :
                ${dt.getMinutes().toString().padStart(2, '0')} :
                ${dt.getSeconds().toString().padStart(2, '0')} 
                ${dt.getHours() > 12 ? PM : AM}
                `;

            // Update l'horloge 8h
            document.getElementById("format8-hts").innerHTML = `
                ${odt[0].toString().padStart(2, '0')} :
                ${odt[1].toString().padStart(2, '0')} :
                ${Math.floor(odt[2]).toString().padStart(2, '0')}
                <br>&emsp;${OR}<br> 
                ${(odt[0] % 8).toString().padStart(2, '0')}:
                ${odt[1].toString().padStart(2, '0')} :
                ${Math.floor(odt[2]).toString().padStart(2, '0')} 
                ${odt[0] >= 8 ? (odt[0] >= 16 ? 'H (' + hexal + ')' : 'O (' + octal + ')') : 'M (' + midenal + ')'}
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
        <h1><?= _('A brand new way of representing time') ?></h1>
        <a href="#nav"></a>
        <span class="transition"></span>
    </section>

    <?php
    getPageHeader('concept', $userInfo);
    ?>

    <div class="concept">
        <h2 class="title"><?= _('The Concept of Octime') ?></h2>
        <p class="p1 elt">
            <?= _("Right from its inception, Octime aimed to change people's perception of the passage of time. Its five creators decided to create a watch that would allow one to perceive time differently. How? Let us show you!") ?>
        </p>

        <p class="p2 elt">
            <?= _("It all started with a simple concept: If we can divide the day into 2 periods of 12 hours, why not be able to have periods of 8 hours? Thus were imagined the Midenalles hours (between 0 and 8h in hexal), Octales (8h-16h), and Hexales (16h-00h). But a question arose, how to fit 60 minutes into a dial suitable for 8 hours? In the classical system, the dial can be divided into small periods of 5 minutes, but in the Octime system, it needs to be divided into periods of 7.5 minutes. This posed the first problem in creating the Octime watch: How to make something both aesthetic and practical?") ?>
        </p>
        <p class="p1 elt">
            <?= _("It was a friend of one of us who found the solution: if 12 times 5 equals 60, then 8 times 5 equals 40, why not make \"trinutes\"? Small periods of 90 seconds, there would be 40 per hour, and this would allow for a \"classic\" dial shape. The three periods. Feeling lost? Don't worry, we'll show you!") ?>
        </p>
        <p class="p2 elt">
            <?= _('Let\'s take an example: It\'s 6:30 PM, which is 6 hours and 30 minutes in the afternoon. In octal, this would be 2:20 H (for "hexale"). Here\'s another one: 3:45 PM would become 7:30 O (for "octale"). Take a break and think about it, you\'ll see, it\'s not that difficult!') ?>
        </p>
    </div>
    <h2>Exemple</h2>
    <section id="time">
        <div>
            <h3><?= _('Octal time system') ?></h3>
            <p id="format8-hts"></p> <!-- HH:TT:SS -->
            <div id="clock-1" class="clock">
                <div class="hand hour" id="hourHand"></div>
                <div class="hand minute" id="minuteHand"></div>
                <div class="hand second" id="secondHand"></div>
            </div>
        </div>
        <div>
            <h3><?= _('Classic time system') ?></h3>
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