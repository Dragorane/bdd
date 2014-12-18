<h3 class='center'>Gestion d'une proposition</h3>
<div class='div_page_bien_serv'>

    <h4>Résumé de la proposition :</h4>
    <?php
    echo "<p>Vendeur : " . $utivendeur->pseudo() . "</p>";
    echo "<p>Acheteur : " . $utiacheteur->pseudo() . "</p>";
    echo "<p>Prix en points trocs de la proposition : " . $prop->get_prix() . "</p>";
    echo "<p>Date de la proposition : " . $prop->get_date() . "</p>";
    ?>
    <center>
        <form method='POST' action='<?= BASEURL ?>/index.php/valider_prop'>
            <input type='hidden' name='idprop' value='<?php echo $prop->get_id(); ?>'>
            <input type='submit' name='valid_prop' value='Accepter la proposition' class='submit'>
        </form><br/><br/>
        <form method='POST' action='<?= BASEURL ?>/index.php/annuler_prop'>
            <input type='hidden' name='idprop' value='<?php echo $prop->get_id(); ?>'>
            <input type='submit' name='sup_prop' value='Refuser/Annuler la proposition' class='submit'>
        </form>
    </center>
</div>