<h2 class='center'>Suppression de votre compte utilisateur</h2>

<div class='div_form_sup_cpt'>
		<form action="<?= BASEURL ?>/index.php/form_sup_cpt" method="post">
				<input type="hidden" value=$_SESSION['pseudo'];>
        <input type="submit" value="Oui">
        <input type="submit" value="Non">
    </form>
</div>
