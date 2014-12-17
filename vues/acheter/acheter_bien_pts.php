<h2>Acheter un bien avec vos points trocs</h2>
<p>Vous souhaitez acheter le bien ci-dessous avec vos points trocs</p>
<?php
if ($verif == 0) {
    echo "<div class='warning'><p>Vous n'avez pas assez de point troc pour acheter ce bien</p></div>";
} else {
    ?>
    <form method='POST' name='form_acheter_bien_pts' action='<?= BASEURL ?>/index.php/acheter_bien_pts'>
        <input type='hidden' name='bien' value='<?php echo $bien->get_id() ?>'>
        <input type='submit' name='valid_acheter_bien_pts' value='Acheter le bien'>
    </form>
    <?php
}
?>
