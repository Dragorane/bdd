<h2 class='center'>Suppression de votre compte</h2>
<div class='petit_form'>
    <form action="<?= BASEURL ?>/index.php/valid_form_sup_cpt" method="post">
        <input type="hidden" value="<?php echo $_SESSION['pseudo']; ?>"/>
        <center><input type="submit" name="Oui" value="Oui" class='submit'/>
        <input type="submit" name="Non" value="Non" class='submit'/></center>
    </form>
</div>
