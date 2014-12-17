<?php

echo "<div class='unbien'>";
echo "<h3>" . $tabbiens[$i]->get_titre() . "</h3>";
echo "<p>" . wordwrap($tabbiens[$i]->get_desc(), 50) . "</p>";
echo "<p> Vendu au prix de : " . $tabbiens[$i]->get_prix() . " Pts par l'utilisateur <a href='index.php/pageuti?pseudo=" . $uti->pseudo() . "'>'" . $uti->pseudo() . "'</a> </p>";
echo "<h4 class='center'><a href='pagebien?id=" . $tabbiens[$i]->get_id() . "'>Acheter / En savoir plus ...</h4>";
echo "</div>";
?>