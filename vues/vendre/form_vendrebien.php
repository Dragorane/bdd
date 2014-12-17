<h2 class='center'>Mise en vente d'un Bien</h2>
<h3>Vous avez sélectionnez la catégorie : <?php echo $cat->getlib(); ?></h3>

<div class="form_vendre">
    <form action="<?= BASEURL ?>/index.php/valid_form_vendre" method="post">
        <input type="hidden" name="idcat" value="<?php echo $_GET['idcat'] ?>">
        <label for="titre">Titre de votre bien</label><br/>
        <input type="text" name="titre" id="titre"/><br/><br/>
        <label for="desc">Description de votre bien</label><br/>
        <textarea rows="5" cols="50" name="desc" id="desc"></textarea><br/><br/>
        <label for="etat">Etat du bien </label><br/>
        <select name="etat">
            <?php
            for ($i = 0; $i < count($tabetat); $i++) {
                echo "<option value='" . $tabetat[$i]->get_id() . "'>" . $tabetat[$i]->get_lib() . "</option>";
            }
            ?>
        </select><br/><br/>
        <label for="prix">Prix (en Pts)</label><br/>
        <input type="text" name="prix" id="prix"/><br/><br/>
        <center><input type="submit" value="Vendre" name="valid_bien"></center>
    </form>
</div>

