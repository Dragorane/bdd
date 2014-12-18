<h2 class="center">Modification de votre mot de passe</h2>
<div class='petit_form'>

    <form action="<?= BASEURL ?>/index.php/valid_mdp" method="POST">
        <label for="mdp">Nouveau mot de passe : </label><br/>
        <input type="text" name="mdp" id="adr"/><br/><br/>
        <label for="verif_mdp">Vérification nouveau mot de passe : </label><br/>
        <input type="text" name="verif_mdp" id="adr"/><br/><br/>
        <center><input type="submit" name="submit"/></center>
    </form>
</div>