<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="<?= BASEURL ?>/css/style.css" type="text/css">
        <title> Troc de biens et de services </title>
    </head>
    <body>
        <div class="site">
            <?php
            include 'utilisateurs/barre_uti.php';
            include 'template/header.php';
            echo "<div class='content'>";
            echo "<h2 class='center'>" . $titre . "</h2>";

            if (isset($_SESSION['message'])) {
                echo '<p>' . $_SESSION['message'] . '</p>';
                unset($_SESSION['message']);
            }
            ?>
            <?= $content ?>

            <?php
            echo "</div>";
            include 'template/footer.php';
            ?>
        </div>

    </body>
</html>