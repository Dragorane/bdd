<?php
echo "<h4><a href='" . BASEURL . "/index.php/acheter_service_pts?id=" . $serv->get_id() . "'>Acheter ce service avec vos points trocs</a></h4>";
echo "<h4><a href='" . BASEURL . "/index.php/acheter_service_bienserv?id=" . $serv->get_id() . "'>Acheter ce service avec vos biens/services</a></h4>";
?>
<hr/>
<h3 class="center">Evaluer le service </h3>
<form method='POST' name='eval_service' action='<?= BASEURL ?>/index.php/valid_eval_service'>
    <input type='hidden' name='id' value='<?php echo $serv->get_id(); ?>'>
    <label for='titre'>Titre de votre évaluation</label><br/>
    <input type='text' name='titre' id='titre'/><br/><br/><br/>
    <label for='note'>Note d'évaluation (/5)   </label>
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
    <center><input type='submit' name='valid_eval' value='Envoyer Evaluation' class="submit"/></center>
</form>
</div>
<div class="uti_evaluation">
    <h3 class='center'>Les évaluations du service (<?php echo $moyeval; ?>/5)</h3>
    <?php
    for ($i = 0; $i < count($tabeval); $i++) {
        $uti = Utilisateur::get_by_id($tabeval[$i]->get_iduti());
        echo "<div class='uneeval'>";
        echo "<h4>" . $tabeval[$i]->get_titre() . " (note : " . $tabeval[$i]->get_note() . "/5)</h4>";
        echo "<p>" . $tabeval[$i]->get_comm() . "</p>";
        echo "Evaluation postée par l'utilisateur <a href='" . BASEURL . "/index.php/pageuti?pseudo=" . $uti->pseudo() . "'>'" . $uti->pseudo() . "'</a>";
        echo "</div>";
    }
    ?>
</div>