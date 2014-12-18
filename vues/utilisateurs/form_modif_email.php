<h2 class="center">Modification de votre email</h2>
<div class='petit_form'>
    <form action="<?= BASEURL ?>/index.php/valid_email" method="POST">
        <label for="email">Nouveau email : </label><br/>
        <input type="text" name="email" id="adr"/><br/><br/>
        <label for="verif_email">Vérification nouveau email : </label><br/>
        <input type="text" name="verif_email" id="adr"/><br/><br/>
        <center><input type="submit" name="submit" class='submit'/></center>
    </form>
</div>