<div class='filtre_recherche'>
    <?php
    if (isset($_GET['idcat'])) {
        echo "<h3 class='bouton_filtre'><a href='?prixcroiss&idcat=" . $_GET['idcat'] . ">Recherche par prix croissant</a></h3>";
        echo "<h3 class='bouton_filtre'><a href='?prixdecroiss&idcat=" . $_GET['idcat'] . "'>Recherche par prix décroissant</a></h3>";
        echo "<h3 class='bouton_filtre'><a href='?evaluation&idcat=" . $_GET['idcat'] . "'>Recherche par évaluation positive</a></h3>";
        echo "<h3 class='bouton_filtre'><a href='?geoloc&idcat=" . $_GET['idcat'] . "'>Recherche par géolocalisation</a></h3>";
    } else {
        echo "<h3 class='bouton_filtre'><a href='?prixcroiss'>Recherche par prix croissant</a></h3>";
        echo "<h3 class='bouton_filtre'><a href='?prixdecroiss'>Recherche par prix décroissant</a></h3>";
        echo "<h3 class='bouton_filtre'><a href='?evaluation'>Recherche par évaluation positive</a></h3>";
        echo "<h3 class='bouton_filtre'><a href='?geoloc'>Recherche par géolocalisation</a></h3>";
    }
    ?>
</div>