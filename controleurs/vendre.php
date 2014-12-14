<?php

require_once 'modeles/categories.php';
require_once 'modeles/evaluations.php';
require_once 'modeles/biens.php';
require_once 'modeles/services.php';
require_once 'modeles/propositions.php';
require_once 'modeles/utilisateur.php';
require_once 'modeles/photos.php';
require_once 'modeles/Etat.php';

class Controller_vendre {

    public function __construct() {
        
    }

    /* Page index */

    public function index() {
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != true))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir vendre un produit</p></div>";
        } else {
            include 'vues/vendre/index.php';
        }
    }

    public function vendrebien() {
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != true))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir vendre un produit</p></div>";
        } else {
            $tabcat = categories::list_categ(1);
            include "vues/menu_cat.php";
            if (!isset($_GET['idcat'])) {
                echo "<h2>Etape 1 :</h2><p class='center'> Merci de selectionner la catégorie de votre bien dans le menu à droite.</p>";
            } else {
                $tabetat = Etat::lesEtats();
                include "vues/form_vendrebien.php";
            }
        }
    }

    public function vendreservice() {
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != true))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir vendre un produit</p></div>";
        } else {
            $tabcat = categories::list_categ(2);
            include 'vues/vendre/form_vendreservice.php';
            include "vues/menu_cat.php";
        }
    }

}
