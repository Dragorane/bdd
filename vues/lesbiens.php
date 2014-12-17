<?php

echo "<div class='unbien'>";
include BASEURL . "/vues/afficher_bien.php";
echo "<h4 class='center'><a href='pagebien?id=" . $bien->get_id() . "'>Acheter / En savoir plus ...</h4>";
echo "</div>";
?>