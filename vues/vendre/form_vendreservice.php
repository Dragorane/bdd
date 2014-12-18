<h2 class='center'>Mise en vente d'un Service</h2>
<div class="div_separer">

    <h3>Vous avez sélectionnez la catégorie : <?php echo $cat->getlib(); ?></h3>

    <form action="<?= BASEURL ?>/index.php/valid_form_vendre_service" method="post">
        <input type="hidden" name="idcat" value="<?php echo $_GET['idcat'] ?>">
        <label for="titre">Titre de votre service</label><br/>
        <input type="text" name="titre" id="titre"/><br/><br/>
        <label for="desc">Description de votre service</label><br/>
        <textarea rows="5" cols="50" name="desc" id="desc"></textarea><br/><br/>
        <label for="nbplace">Nombre de place </label><br/>
        <input type="text" name="nbplace" id="prix"/><br/><br/>
        <label for="prix">Prix (en Pts)</label><br/>
        <input type="text" name="prix" id="prix"/><br/><br/>
        <center><input type="submit" value="Vendre" name="valid_serv"></center>
    </form>
</div>

