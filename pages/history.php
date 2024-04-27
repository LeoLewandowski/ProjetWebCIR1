<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/common.php');
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/util/connection.php');
    getPageHead(_('History'), 'histoire');
    ?>
</head>

<body>
    <!-- Histoire -->
    <section class="banner parallax" style="--src:url(/images/mechanism.jpg)">
        <h1><?= _('A story like no other') ?></h1>
        <a href="#nav"></a>
        <span class="transition"></span>
    </section>

    <?php
    getPageHeader('history', $userInfo);
    ?>

    <div class="histoire">
        <h2><?= _('The Beginning of a Grand Project') ?></h2>
        <p class="p1">
            <?= _("Five years ago, five friends passionate about horology and space exploration decided to create their own company to bring their common vision to life: futuristic watches inspired by space, even integrating elements from the surface of Mars and the Moon. Thus was born \"Octime\". The founders, Léo, Mathis, Simon, Adèle, and Sasha, each possessed complementary skills ranging from engineering to artistic design. Their ambition was to push the boundaries of horological creativity by combining avant-garde aesthetics with authentic extraterrestrial materials.") ?>
        </p>

        <img src="/images/watch/montre_3.png" class="img1">

        <h2><?= _('The Beginning of Entrepreneurial Relationships') ?></h2>
        <p class="p2">
            <?= _("From the outset, the Octime team embarked on innovative partnerships with space agencies and scientific organizations. They succeeded in obtaining fragments of lunar and Martian rocks, which they then integrated into the design of their watches. Each piece was thus symbolically imbued with a part of the universe.") ?>
        </p>

        <img class="image img2" src="../images/watch/montre_2.png">

        <h2><?= _('Spectacular Launch of the First Collection') ?></h2>
        <p class="p1">
            <?= _("The first collection, named \"Cosmic Elegance\", was unveiled at a unique event where renowned astronauts were present to celebrate this unique collaboration. The watches were miniature works of art, blending futuristic lines and space materials with unmatched elegance. Over the years, Octime continued to innovate, launching new collections inspired by different planets and space phenomena. Each model was limited in quantity, adding a touch of exclusivity and rarity. The company's watches became symbols of prestige, coveted by collectors worldwide. Despite their growing success, the founders always maintained a collaborative and creative approach. They opened a research and development workshop where talented watchmakers, engineers, and artists could collaborate to bring forth new ideas and revolutionary concepts.") ?>
        </p>

        <img class="image img1" src="../images/watch/montre_5.png">

        <h2><?= _('A Company Active in Science Outreach') ?></h2>
        <p class="p2">
            <?= _("Octime also played an active role in education, organizing exhibitions and events to raise awareness about space exploration and the importance of preserving extraterrestrial resources. Even today, five years after its creation, Octime continues to push the boundaries of horological innovation and inspire watch enthusiasts worldwide. The company remains true to its initial vision, combining science, art, and a passion for space exploration in every watch it creates.") ?>
        </p>
        <img class="image img2" src="../images/watch/montre_4.png">
        <span class="placeholder"></span>
    </div>
    <!-- End Histoire -->

    <?php
    getPageTopButton();
    getPageFooter();
    ?>
</body>

</html>