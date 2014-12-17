<div class="page_gestion_cpt">
    <h2 class='center'>Page de l'utilisateur "<?php echo $uti->pseudo(); ?>"</h2>
    <?php
    if ($uti->avatar() != null) {
        echo "<img src='" . $uti->avatar() . "' alt='Votre avatar' class='avatar_gestion'/>";
    } else {
        echo "<img src='" . BASEURL . "/images/avatar_default.png' alt='Votre avatar' class='avatar_gestion'/>";
    }
    ?>
    <h3>Evaluer l'utilisateur :</h3>
    <form method='POST' name='eval_uti' action='<?= BASEURL ?>/index.php/valid_eval_uti'>
        <input type='hidden' name='uti_eval' value='<?php echo $uti->id(); ?>'>
        <label for='titre'>Titre de votre évaluation</label><br/>
        <input type='text' name='titre' id='titre'/><br/><br/>
        <label for='note'>Note d'évaluation /5</label><br/>
        <select name='note'>
            <option value='0'>0</option>
            <option value='1'>1</option>
            <option value='2'>2</option>
            <option value='3'>3</option>
            <option value='4'>4</option>
            <option value='5'>5</option>
        </select><br/><br/>
        <label for='comm'>Commentaire</label><br/>
        <textarea rows="5" cols="50" name='comm'></textarea><br/><br/>
        <input type='submit' name='valid_eval' value='Envoyer Evaluation'/>
    </form>

    <div class="uti_evaluation">
        <h3 class='center'>Les évaluations de l'utilisateur (<?php echo $moyeval; ?>/5)</h3>
        <?php
        for ($i = 0; $i < count($tabeval); $i++) {
            $uti = Utilisateur::get_by_id($tabeval->get_iduti());
            echo "<div class='uneeval'>";
            echo "<h4>" . $tabeval[$i]->get_titre() . " (note : " . $tabeval[$i]->get_note() . "/5)</h4>";
            echo "<p>" . $tabeval[$i]->get_comm() . "</p>";
            echo "Evaluation postée par l'utilisateur <a href='" . BASEURL . "/index.php/pageuti?pseudo=" . $uti->pseudo() . "'>'" . $uti->pseudo() . "'</a>";
            echo "</div>";
        }
        ?>
    </div>
</div>