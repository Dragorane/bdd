<div id="menu">
    <ul>
        <li><a href="<?= BASEURL ?>/index.php">Page principale</a></li>
        <li><a href="<?= BASEURL ?>/index.php/acheter">Acheter</a></li>
        <?php if ((isset($_SESSION['connect']) && ($_SESSION['connect'] == true))) { ?>
            <li><a href="<?= BASEURL ?>/index.php/vendre">Vendre</a></li>
            <li><a href="<?= BASEURL ?>/index.php/propositions">Propositions de troc</a></li>
        <?php } ?>

    </ul>
</div>