<h2 class="center">Formulaire d'inscription</h2>
<p>Les champs (*) sont à remplir obligatoirement.</p>
<form action="<?= BASEURL ?>/index.php/valid_inscri" method="post" enctype="multipart/form-data">
    <label for="pseudo">(*) Pseudo  </label><br/>
    <input type="text" name="pseudo" id="pseudo" /><br/><br/>
    <label for="mdp">(*) Password </label><br/>
    <input type="password" name="mdp" id="mdp" /><br/><br/>
    <label for="verif_mdp">(*) Verification Password </label><br/>
    <input type="password" name="verif_mdp" id="verif_mdp" /><br/><br/>
    <label for="mail">(*) Email </label><br/>
    <input type="email" name="mail" id="user_pass" /><br/><br/>
    <label for="verif_mail">(*) Verification Email </label><br/>
    <input type="email" name="verif_mail" id="verif_mail" /><br/><br/>
    <label for="nom">Nom  </label><br/>
    <input type="text" name="nom" id="nom" /><br/><br/>
    <label for="pnom">Prénom  </label><br/>
    <input type="text" name="pnom" id="pnom" /><br/><br/>
    <label for="adr"> Adresse  </label><br/>
    <input type="text" name="adr" id="adr" /><br/><br/>
    <label for="tel"> téléphone  </label><br/>
    <input type="text" name="tel" id="adr" /><br/><br/>
    <label for="photo"> Photo</label><br/>
    <input type="file" name="photo" id="photo" /><br/><br/>
    <label for="securite">(*)Combien font 40+2 ?</label><br/>
    <input type="securite" name="securite" id="securite"/><br/><br/>
    <input type="submit" value="Inscription"/>
</form>