<form action="<?= BASEURL ?>/index.php/objet" method="get">
    <label for="obj_nom">Nom bien : </label><input type="text" name="nom" id="obj_nom" />
    <label for="obj_desc">Descriptif : </label><input type="text" name="desc" id="obj_desc" />
    <label for="obj_value">Valeur : </label><input type="number" name="val" id="obj_value" />
    <input type="submit" value="Envoyer">
</form>