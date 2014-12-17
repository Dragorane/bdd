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
    <form methode='POST' name='eval_uti' action='<?= BASEURL ?>/index.php/valid_eval_produit'>
        <input type='hidden' name='id' value='<?php echo $_GET['id']; ?>'>
        <label for='titre'>Titre de votre évaluation</label><br/>
        <input type='text' name='titre' id='titre'/><br/><br/>
        <label for='num_eval'>Note d'évaluation /5</label>
        <select name='num_eval'>
            <option value='0'>0</option>
            <option value='1'>1</option>
            <option value='2'>2</option>
            <option value='3'>3</option>
            <option value='4'>4</option>
            <option value='5'>5</option>
        </select>
        <label for='comm'>Commentaire</label>
        <textarea rows="5" cols="50" name='comm'></textarea>
    </form>

    <div class="uti_evaluation">
        <h3 class='center'>Evaluations de l'utilisateur</h3>
    </div>
</div>