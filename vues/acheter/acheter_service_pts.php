<h2 class="center">Acheter un service avec vos points trocs</h2>
<div class='div_page_bien_serv'>
    <p>Vous souhaitez acheter le service ci-dessous avec vos points trocs<br/>
        Merci de proposez au vendeur une date et un lieu où vous pourrez bénéficier du service</p>

    <?php
    if ($verif == 0) {
        echo "<div class='warning'><p>Vous n'avez pas assez de point troc pour acheter ce service</p></div>";
    } else {
        ?>
        <form method='POST' name='form_acheter_service_pts' action='<?= BASEURL ?>/index.php/valid_acheter_service_pts'>
            <input type='hidden' name='serv' value='<?php echo $serv->get_id() ?>'>
            <label for='adr'>Adresse de l'échange</label><br/>
            <input type='text' name='adr' id='adr'/><br/><br/>
            <label for='date'>Date de l'échange (format dd/mm/aaaa)</label><br/>
            <input type='text' name='date' id='adr'/><br/><br/>
            <center><input type='submit' name='valid_acheter_serv_pts' value='Acheter le service' class="submit"/></center>
        </form>
        <?php
    }
    ?>
</div>