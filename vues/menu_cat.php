<?php
//le premier est obligatoirement une catégorie père.
echo "<div class='menu_categorie'>";
echo "<ul class='categorie'>";
$dernier_pere = $tabcat[0][1];
echo "<li class='cat_pere'><a href='#&idcat=" . $tabcat[0][1] . "'>" . $tabcat[0][2] . "</a></li>";
echo "<ul class='cat_fils'>";
for ($i = 1; $i < count($tabcat); $i++) {
    if ($tabcat[$i][0] == null) {
        echo "</ul>";
        $dernier_pere = $tabcat[$i][0];
        echo "<li class='cat_pere'><a href='#&idcat=" . $tabcat[0][1] . "'>" . $tabcat[0][2] . "</a></li>";
        echo "<ul class='cat_fils'>";
    } else {
        echo "<li class='cat_fils'><a href='#&idcat=" . $tabcat[0][1] . "'>" . $tabcat[0][2] . "</a></li>";
    }
}
echo "</ul>";
echo "</div>";

