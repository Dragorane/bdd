<div id="BarreUti">

    <?php if (!isset($_SESSION['connect'])) { ?> 
        <span class="messagebonjour">Bienvenue</span>
        <ul>
            <li><a href="<?= BASEURL ?>/index.php/connexion">Connexion</a></li> 
            <li><a href="<?= BASEURL ?>/index.php/inscription">Inscription</a></li> 
        </ul>
        <?php
    } else {
        $uti = Utilisateur::get_by_pseudo_mdp($_SESSION['pseudo'], $_SESSION['mdp']);
        if ($uti == null) {
            echo "<span class='messagebonjour'>Erreur lors de l'identification</span>";
            echo "<ul>
                <li><a href='/deconnexion'>Déconnexion</a></li> 
            </ul>";
        } else {
            ?>
            <ul>
                <li><a href="<?= BASEURL ?>/index.php/gestion_compte">Gestion Compte</a></li> 
                <li><a href="<?= BASEURL ?>/index.php/deconnexion">Déconnexion</a></li> 
            </ul>
            <span class="messagebonjour">Bonjour <?php echo $_SESSION['pseudo']; ?> </span><span class='nb_troc'>Pts : <?php echo $uti->pt_troc(); ?></span>

        <?php }
    } ?>
</div>