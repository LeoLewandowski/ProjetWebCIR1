<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once ('./util/common.php');
    getPageHead('OcTime', 'index');
    ?>
    <script>
        // Fonction pour l'animation de l'horloge de l'accueil
        document.addEventListener('mousemove', (e) => {
            var rect = document.getElementById('nav').getBoundingClientRect();
            var x = e.clientX - (rect.left + rect.right) / 2;
            var y = e.clientY - (rect.top + rect.bottom) / 2; 
            document.getElementById('handle').style.setProperty('rotate', Math.round(Math.atan2(y, x) * 100) / 100 + Math.PI / 2 + "rad");
        });
    </script>
</head>

<body>

    <!-- Banner -->
    <section class="banner parallax" style="--src:url(/images/mechanism.jpg)">
        <img src="/images/logo.svg" style="filter: invert();">
        <a href="#nav"></a>
        <span class="transition" style="--color:var(--secondary-theme-color);"></span>
    </section>
    <!-- End Banner -->

    <!-- Clock Nav -->
    <h2><?= _('Navigation') ?></h2>
    <section id="nav">
        <div id="clock-links">
            <a href="/" style="color: var(--theme-accent-color);"><?= _('Homepage') ?></a>
            <a href="/history"><?= _('History') ?></a>
            <a href="/products"><?= _('Products') ?></a>
            <a href="/contact"><?= _('Contact') ?></a>
            <a href="/concept"><?= _('Concept') ?></a>
            <a href="/login"><?= _('Log in') ?></a>
            <a href="/login?signup"><?= _('Sign up') ?></a>
            <a href="/team"><?= _('Our team') ?></a>
        </div>
        <svg width="256" height="256" stroke="black" fill="black" stroke-width="10" stroke-linecap="round">
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
        <h2><?= _("Discover the excellence of time with Octime") ?></h2>
        <p>
            <?= _('Welcome to the refined and sophisticated world of Octime, where each watch embodies the very essence of elegance and precision. Since our inception, we have been committed to pushing the boundaries of watchmaking, creating exceptional timepieces that merge art and engineering.') ?>
        </p>
        <h2><?= _('Exceptional Craftsmanship') ?></h2>
        <p>
            <?= _('At Octime, we believe in exceptional craftsmanship. Each watch is the result of meticulous work carried out by our master watchmakers, experts in the ancient art of watchmaking. Every detail is carefully considered, every component is precisely selected to ensure unparalleled quality.') ?>
        </p>
        <h2><?= _('Timeless & Unique Design') ?></h2>
        <p>
            <?= _('Our watches reflect timeless design, combining elegance and modernity. Whether you choose a classic or contemporary model, an octal or dodecal watch, each Octime watch is a work of art in its own right, designed to transcend fleeting trends and remain a timeless symbol of style.') ?>
        </p>
        <h2><?= _('Technological Innovation') ?></h2>
        <p>
            <?= _('At the intersection of tradition and innovation, Octime incorporates the latest technological advancements into each of its creations. Our watches are equipped with cutting-edge movements, ensuring uncompromising chronometric precision. The durability and reliability of our mechanisms match our commitment to excellence.') ?>
        </p>
        <h2><?= _('Superior Quality Materials') ?></h2>
        <p>
            <?= _('At Octime, we only use the highest quality materials for the manufacture of our watches. From stainless steel cases to premium leather straps, each component is carefully chosen to ensure exceptional durability and optimal comfort.') ?>
        </p>
        <h2><?= _('Satisfaction Guarantee') ?></h2>
        <p>
            <?= _('We take pride in the quality of our watches, which is why we offer a lifetime satisfaction guarantee. At Octime, we are committed to exceeding your expectations, ensuring that each watch you choose is an investment in lasting luxury and elegance.') ?>
            <br><br>
            <?= _('Explore our exceptional collection and discover the perfect marriage of traditional watchmaking art and contemporary innovation. With Octime, time becomes an experience, a legacy to cherish through generations.') ?>
            <br><br>
        </p>
        <h3 style="color: var(--theme-accent-color);font-style: italic;"><?= _('Choose Octime. Choose excellence.') ?>
        </h3>
    </main>

    <h1><?= _('Some opinions & quotes') ?></h1>
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
            <span><?= _('My cat') ?></span>
        </div>
    </section>
    <!-- End Feedback -->

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>