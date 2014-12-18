<?php
echo "<h3>" . $serv->get_titre() . "</h3>";
echo "<p>" . $serv->get_desc() . "</p>";
echo "<p> Vendu au prix de : " . $serv->get_prix() . " Pts par l'utilisateur <a href='" . BASEURL . "/index.php/pageuti?pseudo=" . $uti->pseudo() . "'>'" . $uti->pseudo() . "'</a> </p>";
?>