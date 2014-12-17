<div class="page_gestion_cpt">
    <h2 class='center'>Gestion du compte de l'utilisateur</h2>

    <div class="gestion_informations">
        <h3 class='center'>Informations du compte : </h3>
        <?php
        if ($uti->avatar() != null) {
            echo "<img src='" . $uti->avatar() . "' alt='Votre avatar' class='avatar_gestion'/>";
        } else {
            echo "<img src='" . BASEURL . "/images/avatar_default.png' alt='Votre avatar' class='avatar_gestion'/>";
        }
        ?>
        <br/>
        <h3 class="center"><a href='<?= BASEURL ?>/index.php/form_modif_avatar'>Modifier l'avatar</a></h3>
        <br/>
        <table class='gestion'>
            <tr><th>Pseudo</th><td><?php echo $uti->pseudo(); ?></td><td><a href='<?= BASEURL ?>/index.php/form_modif_pseudo'>Modifier</a></td></tr>
            <tr><th>Nom</th><td><?php echo $uti->nom(); ?></td><td><a href='<?= BASEURL ?>/index.php/form_modif_nom'>Modifier</a></td></tr>
            <tr><th>Prénom</th><td><?php echo $uti->pnom(); ?></td><td><a href='<?= BASEURL ?>/index.php/form_modif_pnom'>Modifier</a></td></tr>
            <tr><th>Adresse</th><td><?php echo $uti->adr(); ?></td><td><a href='<?= BASEURL ?>/index.php/form_modif_adr'>Modifier</a></td></tr>
            <tr><th>Email</th><td><?php echo $uti->email(); ?></td><td><a href='<?= BASEURL ?>/index.php/form_modif_email'>Modifier</a></td></tr>
            <tr><th>Téléphone</th><td><?php echo $uti->tel(); ?></td><td><a href='<?= BASEURL ?>/index.php/form_modif_tel'>Modifier</a></td></tr>
        </table>
    </div>
    <div class="gestion_portemonnaire">
        <h3 class='center'>Porte monnaie </h3>
        <br/>
        <h4>Disponible : <?php echo $uti->pt_troc(); ?>Pts</h4>
        <form action="<?= BASEURL ?>/index.php/valid_ajout_monnaie" method="post">
            <input type="text" name="monnaie" id="monnaie" />
            <input type="submit" name='submit' value="Ajouter">
        </form>
        <br/><br/>
        <h3 class='center'>Administration :</h3>
        <h4 class="center"><a href='<?= BASEURL ?>/index.php/form_modif_mdp'>Modifier le mot de passe</a></h4>
        <h4 class="center"><a href='<?= BASEURL ?>/index.php/form_sup_cpt'>Supprimer le compte</a></h4>
    </div>
    <div class="gestion_historique">
        <hr/>
        <h2 class='center'>Historique des Echanges</h2>
        <table>
            <tr><th>Acheteur</th><th>Vendeur</th><th>Prix</th><th>Date</th><th>Etat</th></tr>
            <?php
            for ($i = 0; $i < count($historique); $i++) {
                $utivendeur = Utilisateur::get_by_id($historique[$i]->get_idv());
                $utiacheteur = Utilisateur::get_by_id($historique[$i]->get_iduti());
                if ($historique[$i]->get_etat() == 1) {
                    $etat = "Acceptée";
                } else {
                    $etat = "Refusée";
                }
                echo "<tr>";
                echo "<td>" . $utiacheteur->pseudo() . "</td>";
                echo "<td>" . $utivendeur->pseudo() . "</td>";
                echo "<td>" . $historique[$i]->get_prix() . "</td>";
                echo "<td>" . $historique[$i]->get_date() . "</td>";
                echo "<td>" . $etat . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>