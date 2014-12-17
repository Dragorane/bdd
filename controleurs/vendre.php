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
                echo "<h3>Etape 1 :</h3><p class='center'> Merci de selectionner la catégorie de votre bien dans le menu à droite.</p>";
            } else {
                $cat = categories::recupCat($_GET['idcat']);
                echo $cat->getlib();
                if ($cat != null) {
                    echo "<h3>Vous avez sélectionnez la catégorie : " . $cat->getlib() . "</h3>";
                    $tabetat = Etat::lesEtats();
                    include "vues/vendre/form_vendrebien.php";
                }
            }
        }
    }

    public function vendreservice() {
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != true))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir vendre un produit</p></div>";
        } else {
            $tabcat = categories::list_categ(2);
            include "vues/menu_cat.php";
            include 'vues/vendre/form_vendreservice.php';
        }
    }

    public function valide_vendreservice() {
        $verif = 0;
        if (!isset($_POST['valid_bien'])) {
            echo "<div class='warning'><p>Erreur, vous n'avez pas l'accès à cette page.</p></div>";
        } else {
            if (validpts($_POST['prix']) != 0) {
                biens::create($_POST['titre'], $_POST['desc'], $_POST['prix'], $iduti, $_POST['idcat'], $_POST['etat']);
                $verif = 1;
            }
        }
        if ($verif == 0) {
            echo "<a href='javascript:history.back()'><h2 class='center'>Retour au formulaire de vente</h2></a>";
        } else {
            echo "<div class='success'><p>Votre bien a été mis en vente.</p></div>";
        }
    }

    public function validpts($pts) {
        if ((is_float(floatval($nb))) && ($pts > 0)) {
            return 1;
        } else {
            echo "<div class='warning'><p>Erreur, vous avez mal saisi le montant de points troc.</p></div>";
            return 0;
        }
    }

}
