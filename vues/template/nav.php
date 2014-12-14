<div id="menu">
    <ul>
        <li><a href="<?= BASEURL ?>/index.php">Page principale</a></li>
        <li><a href="<?= BASEURL ?>/index.php/acheter">Acheter</a></li>
        <?php if ((isset($_SESSION['connect']) && ($_SESSION['connect'] == 0))) { ?>
            <li><a href="<?= BASEURL ?>/index.php/vendre">Vendre</a></li>
        <?php } ?>

    </ul>
</div>