<h2 class='center'>Suppression de votre bite</h2>

<div class='div_form_sup_cpt'>
		<form action="<?= BASEURL ?>/index.php/valid_form_sup_cpt" method="post">
		<input type="hidden" value="<?php echo $_SESSION['pseudo'];?>">
        <input type="submit" name="Oui" value="Oui">
        <input type="submit" name="Non" value="Non">
    </form>
</div>
