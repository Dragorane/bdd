<h2>Acheter un bien avec vos biens/services</h2>
<p>Vous souhaitez acheter le bien ci-dessous avec un de vos biens/services<br/>
    Merci de proposez au vendeur une date et un lieu où vous pourrez effectuer l'échange ainsi que l'objet ou le service</p>

<form method='POST' name='form_acheter_bien_pts' action='<?= BASEURL ?>/index.php/valid_acheter_bien_obj'>
    <input type='hidden' name='bien' value='<?php echo $bien->get_id(); ?>'>
    <label for='obj'>Bien ou service à échanger</label>
    <select name='obj'>
        <?php
        echo "  <optgroup label='Vos biens'>";
        for ($i = 0; $i < count($tabbien); $i++) {
            echo "<option value='bien:" . $tabbien[$i]->get_id() . "'></option>";
        }
        echo "</optgroup>";
        echo "  <optgroup label='Vos biens'>";
        for ($j = 0; $j < count($tabserv); $j++) {
            echo "<option value='serv:" . $tabserv[$j]->get_id() . "'></option>";
        }
        echo "</optgroup>";
        ?>
    </select>
    <label for='adr'>Adresse de l'échange</label><br/>
    <input type='text' name='adr' id='adr'/><br/><br/>
    <label for='date'>Date de l'échange (format dd/mm/aaaa)</label><br/>
    <input type='text' name='date' id='adr'/><br/><br/>
    <center><input type='submit' name='valid_acheter_bien_pts' value='Acheter le bien'/></center>
</form>