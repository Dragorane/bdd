<?php

echo "<h3>" . $bien->get_titre() . "</h3>";
echo "<p>" . $bien->get_desc() . "</p>";
echo "<p> Vendu au prix de : " . $bien->get_prix() . " Pts par l'utilisateur <a href='" . BASEURL . "/index.php/pageuti?pseudo=" . $uti->pseudo() . "'>'" . $uti->pseudo() . "'</a> </p>";
?>