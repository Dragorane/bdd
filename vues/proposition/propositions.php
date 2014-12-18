<h2 class='center'>Liste des propositions en cours</h2>

<h3 class='center'> Proposition où vous vendez</h3>
<table class='tab_visible'>
    <tr><th>Acheteur</th><th>prix</th><th>date</th><th>lieu</th></tr>
    <?php
    for ($i = 0; $i < count($prop_vendeur); $i++) {
        $uti_acheteur = Utilisateur::get_by_id($prop_vendeur[$i]->get_iduti());
        if ($uti != null) {
            echo "<tr>";
            echo "<td>" . $uti_acheteur->pseudo() . "</td>";
            echo "<td>" . $prop_vendeur[$i]->get_prix() . "</td>";
            echo "<td>" . $prop_vendeur[$i]->get_date() . "</td>";
            echo "<td>" . $prop_vendeur[$i]->get_adr() . "</td>";
            echo "<td>";
            echo "<form name='voir_prop' method='POST' action='" . BASEURL . "/index.php/laproposition'>"
            . "<input type='hidden' name='laprop' value='" . $prop_vendeur[$i]->get_id() . "'/>"
            . "<input type='hidden' name='vendeur'/>"
            . "<input type='submit' value='Plus de détail' name='detail_prop' class='submit'/>"
            . "</form>";
            echo "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>

<h3 class='center'>Proposition où vous achetez</h3>
<table class='tab_visible'>
    <tr><th>Vendeur</th><th>prix</th><th>date</th><th>lieu</th></tr>
    <?php
    for ($i = 0; $i < count($prop_vendeur); $i++) {
        $uti_vendeur = Utilisateur::get_by_id($prop_vendeur[$i]->get_idv());
        echo "<tr>";
        echo "<td>" . $uti_vendeur->pseudo() . "</td>";
        echo "<td>" . $prop_vendeur[$i]->get_prix() . "</td>";
        echo "<td>" . $prop_vendeur[$i]->get_date() . "</td>";
        echo "<td>" . $prop_vendeur[$i]->get_adr() . "</td>";
        echo "<td>";
        echo "<form name='voir_prop' method='POST' action='" . BASEURL . "/index.php/laproposition'>"
        . "<input type='hidden' name='laprop' value='" . $prop_vendeur[$i]->get_id() . "'/>"
        . "<input type='hidden' name='acheteur' value='" . $prop_vendeur[$i]->get_id() . "'/>"
        . "<input type='submit' value='Plus de détail' name='detail_prop' class='submit'/>"
        . "</form>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>