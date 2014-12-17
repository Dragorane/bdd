<h2 class='center'>Vendre un Bien/Service</h2>
<h3 class='center'><a href='<?= BASEURL ?>/index.php/vendrebien'>Je veux vendre un Bien</a></h3>
<h3 class='center'><a href='<?= BASEURL ?>/index.php/vendreservice'>Je veux vendre un Service</a></h3>

<h3 class='center'>Liste de vos Biens en vente</h3>
<table class='biens'>
    <tr><th>titre bien</th><th>categorie bien</th><th>prix</th></tr>
    <?php
    for ($i = 0; $i < count($tabbien); $i++) {
        $cat = categories::recupCat($tabbien[$i]->get_categ());
        echo "<tr>";
        echo "<td>" . $tabbien[$i]->get_titre() . "</td>";
        echo "<td>" . $cat->getlib() . "</td>";
        echo "<td>" . $tabbien[$i]->get_prix() . "</td>";
        echo "<td>";
        echo "<form name='modifiervente' method='POST' action='" . BASEURL . "/index.php/modif_vente'>"
        . "<input type='hidden' name='id' value='" . $tabbien[$i]->get_id() . "'/>"
        . "<input type='hidden' name='type' value='1'/>"
        . "<input type='submit' value='Modifier la vente' name='modif_vente'/>"
        . "</form>";
        echo "</td><td>";
        echo "<form name='supprimervente' method='POST' action='" . BASEURL . "/index.php/sup_vente'>"
        . "<input type='hidden' name='id' value='" . $tabbien[$i]->get_id() . "'/>"
        . "<input type='hidden' name='type' value='1'/>"
        . "<input type='submit' value='Supprimer la vente' name='modif_vente'/>"
        . "</form>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>

<h3 class='center'>Liste de vos Services en vente</h3>
<table class='biens'>
    <tr><th>titre service</th><th>categorie service</th><th>service</th></tr>
    <?php
    for ($i = 0; $i < count($tabserv); $i++) {
        $cat = categories::recupCat($tabserv[$i]->get_categ());
        echo "<tr>";
        echo "<td>" . $tabserv[$i]->get_titre() . "</td>";
        echo "<td>" . $cat->getlib() . "</td>";
        echo "<td>" . $tabserv[$i]->get_prix() . "</td>";
        echo "<td>";
        echo "<form name='modifiervente' method='POST' action='" . BASEURL . "/index.php/modif_vente'>"
        . "<input type='hidden' name='id' value='" . $tabserv[$i]->get_id() . "'/>"
        . "<input type='hidden' name='type' value='2'/>"
        . "<input type='submit' value='Modifier la vente' name='modif_vente'/>"
        . "</form>";
        echo "</td><td>";
        echo "<form name='supprimervente' method='POST' action='" . BASEURL . "/index.php/sup_vente'>"
        . "<input type='hidden' name='id' value='" . $tabserv[$i]->get_id() . "'/>"
        . "<input type='hidden' name='type' value='2'/>"
        . "<input type='submit' value='Supprimer la vente' name='modif_vente'/>"
        . "</form>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>
