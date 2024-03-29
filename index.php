<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once('./util/common.php');
    getPageHead('OcTime', 'index');
    ?>
</head>

<body>

    <!-- Banner -->
    <section class="banner parallax" style="--src:url(/images/mechanism.jpg)">
        <img src="/images/logo.svg" style="filter: invert();">
        <a href="#nav"></a>
    </section>
    <!-- End Banner -->

    <!-- Clock Nav -->
    <h2>Navigation</h2>
    <section id="nav">
        <div id="clock-links">
            <a href="/" style="color: var(--theme-accent-color);">Accueil</a>
            <a href="/history">Histoire</a>
            <a href="/products">Produits</a>
            <a href="/contact">Contact</a>
            <a href="/concept">Concept</a>
            <a href="/login">Connexion</a>
            <a href="/register">Inscription</a>
            <a href="/team">Équipe</a>
        </div>
        <svg class="img-theme" width="256" height="256" stroke="black" fill="black" stroke-width="10"
            stroke-linecap="round">
            <circle cx="128.25" cy="128.25" r="123.25" fill="none" />
            <line id="handle" x1="128" x2="128" y1="128" y2="50" />
            <g stroke-width="5">
                <line x1="128" x2="128" y1="30" y2="0" />
                <line x1="128" x2="128" y1="226" y2="256" />
                <line x1="30" x2="0" y1="128" y2="128" />
                <line x1="226" x2="256" y1="128" y2="128" />
                <line x1="57" x2="43" y1="57" y2="43" />
                <line x1="199" x2="213" y1="57" y2="43" />
                <line x1="57" x2="43" y1="199" y2="213" />
                <line x1="199" x2="213" y1="199" y2="213" />
            </g>
        </svg>
    </section>
    <!-- End Clock Nav -->

    <main>
        <h2>Découvrez l'Excellence du Temps avec Octime</h2>
        <p>
            Bienvenue dans l'univers raffiné et sophistiqué d'Octime, où chaque montre incarne l'essence même de
            l'élégance et de la précision. Depuis notre création, nous nous sommes engagés à repousser les limites de
            l'horlogerie, créant des garde-temps d'exception qui fusionnent art et ingénierie.
        </p>
        <h2>Artisanat d'exception</h2>
        <p>
            Chez Octime, nous croyons en l'artisanat d'exception. Chaque montre est le fruit d'un travail méticuleux
            effectué par nos maîtres horlogers, experts dans l'art ancestral de la conception de montres. Chaque détail
            est soigneusement étudié, chaque composant est sélectionné avec précision pour garantir une qualité
            inégalée.
        </p>
        <h2>Design intemporel & unique</h2>
        <p>
            Nos montres sont le reflet d'un design intemporel, alliant élégance et modernité. Que vous optiez pour un
            modèle classique ou contemporain, pour une montre octale ou dodécale, chaque montre Octime est une œuvre
            d'art à part entière, conçue pour transcender les tendances éphémères et demeurer un symbole intemporel de
            style.
        </p>
        <h2>Innovation technologique</h2>
        <p>
            À la croisée de la tradition et de l'innovation, Octime intègre les dernières avancées technologiques dans
            chacune de ses créations. Nos montres sont équipées de mouvements de pointe, assurant une précision
            chronométrique sans compromis. La durabilité et la fiabilité de nos mécanismes sont à la hauteur de notre
            engagement envers l'excellence.
        </p>
        <h2>Matériaux de qualité supérieure</h2>
        <p>
            Chez Octime, nous n'utilisons que des matériaux de la plus haute qualité pour la fabrication de nos montres.
            Des boîtiers en acier inoxydable aux bracelets en cuir de première qualité, chaque composant est choisi avec
            soin pour assurer une durabilité exceptionnelle et un confort optimal.
        </p>
        <h2>Garantie de satisfaction</h2>
        <p>
            Nous sommes fiers de la qualité de nos montres, c'est pourquoi nous offrons une garantie de satisfaction à
            vie. Chez Octime, nous nous engageons à dépasser vos attentes, garantissant que chaque montre que vous
            choisissez est un investissement dans le luxe et l'élégance durables.
            <br><br>
            Explorez notre collection exceptionnelle et découvrez le mariage parfait entre l'art horloger traditionnel
            et l'innovation contemporaine. Avec Octime, le temps devient une expérience, un héritage à chérir à travers
            les générations.
            <br><br>
            <h3 style="color: var(--theme-accent-color);font-style: italic;">Choisissez Octime. Choisissez l'excellence.</h3>
        </p>
    </main>

    <h1>Quelques avis & citations</h1>
    <!-- Feedback -->
    <section id="quotes">
        <div class="quote">
            <q>Un concept unique en son genre, qui saura s'imposer dans le monde de l'horlogerie</q>
            <span>Véli</span>
        </div>
        <div class="quote">
            <q>
                De nos jours, on voit peu de nouvelles entreprises qui osent casser
                les codes du marché. Octime prend le pari de le faire avec ses montres
                octales, et a réussi avec brio !
            </q>
            <span>Nagui</span>
        </div>
        <div class="quote">
            <q>Le temps nous file entre les doigts depuis si longtemps que nous avons fini par le réinventer</q>
            <span>Louis Damay</span>
        </div>
        <div class="quote">
            <q>La moissoneuse bat le blé, l'hélicoptère bat l'avoine</q>
            <span>Robin Matarese</span>
        </div>
        <div class="quote">
            <q>A truly mind-blowing design</q>
            <span>John Fitzgerald Kennedy</span>
        </div>
        <div class="quote">
            <q>Miau</q>
            <span>Mon chat</span>
        </div>
    </section>
    <!-- End Feedback -->

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>