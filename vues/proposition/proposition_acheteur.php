<h3 class='center'>Gestion d'une proposition</h3>
<h4>Résumé de la proposition :</h4>
<?php
echo "<p>Vendeur : " . $uti_vendeur->pseudo() . "</p>";
echo "<p>Acheteur : " . $uti_acheteur->pseudo() . "</p>";
echo "<p>Prix en points trocs de la proposition : " . $prop->get_prix() . "</p>";
echo "<p>Date de la proposition : " . $prop->get_date() . "</p>";
?>
<center>
    <form method='POST' action='<?= BASEURL ?>/index.php/annuler_prop'>
        <input type='hidden' name='idprop' value=''>
        <input type='submit' value='Refuser/Annuler la proposition'>
    </form>
</center>