<?php
echo "<h4><a href='" . BASEURL . "/index.php/acheter_service_pts?id=" . $serv->get_id() . "'>Acheter ce service avec vos points trocs</a></h4>";
echo "<h4><a href='" . BASEURL . "/index.php/acheter_service_bienserv?id=" . $serv->get_id() . "'>Acheter ce service avec vos biens/services</a></h4>";
?>
<h3>Evaluer le service </h3>
<form methode='POST' name='eval_service' action='<?= BASEURL ?>/index.php/valid_eval_service'>
    <input type='hidden' name='id' value='<?php echo $serv->get_id();
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
    <h3 class='center'>Evaluations du service</h3>
</div>

