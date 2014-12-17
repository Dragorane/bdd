<?php
echo "<h4><a href='" . BASEURL . "/index.php/acheter_biens_pts?id=" . $bien->get_id() . "'>Acheter ce bien avec vos points trocs</a></h4>";
echo "<h4><a href='" . BASEURL . "/index.php/acheter_biens_bienserv?id=" . $bien->get_id() . "'>Acheter ce bien avec vos biens/services</a></h4>";
?>
<h3>Evaluer le bien </h3>
<form methode='POST' name='eval_bien' action='<?= BASEURL ?>/index.php/valid_eval_bien'>
    <input type='hidden' name='id' value='<?php echo $bien->get_id();
?>'>
    <label for='titre'>Titre de votre évaluation</label><br/>
    <input type='text' name='titre' id='titre'/><br/><br/><br/>
    <label for='num_eval'>Note d'évaluation /5</label><br/>
    <select name='num_eval'>
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
    <h3 class='center'>Evaluations du bien</h3>
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

