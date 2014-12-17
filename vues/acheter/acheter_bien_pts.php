<h2>Acheter un bien avec vos points trocs</h2>
<p>Vous souhaitez acheter le bien ci-dessous avec vos points trocs<br/>
    Merci de proposez au vendeur une date et un lieu où vous pourrez échanger le bien</p>

<?php
if ($verif == 0) {
    echo "<div class='warning'><p>Vous n'avez pas assez de point troc pour acheter ce bien</p></div>";
} else {
    ?>
    <form method='POST' name='form_acheter_bien_pts' action='<?= BASEURL ?>/index.php/valid_acheter_bien_pts'>
        <input type='hidden' name='bien' value='<?php echo $bien->get_id(); ?>'>
        <label for='adr'>Adresse de l'échange</label><br/>
        <input type='text' name='adr' id='adr'/><br/><br/>
        <label for='date'>Date de l'échange (format dd/mm/aaaa)</label><br/>
        <input type='text' name='date' id='adr'/><br/><br/>
        <center><input type='submit' name='valid_acheter_bien_pts' value='Acheter le bien'/></center>
    </form>
    <?php
}
?>
