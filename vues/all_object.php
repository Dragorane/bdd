Liste des objets :
<ul>
    <?php foreach ($array_obj as $obj) { ?>

        <li>Nom : <?= $obj->nom() ?>
            <ul>
                <li>Id : <?= $obj->id() ?></li>
                <li>Descriptif : <?= $obj->descriptif() ?></li>
                <li>Valeur : <?= $obj->valeur() ?></li>
            </ul></li>
    <?php } ?>    
</ul>