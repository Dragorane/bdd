<?php

require_once 'modeles/categorie.php';

class Controller_vendre {

    public function __construct() {
        
    }

    /* Page index */

    public function index() {
        categories::initcat();
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != 0))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir vendre un produit</p></div>";
        } else {
            include 'vues/vendre/index.php';
        }
    }

    public function vendrebien() {
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != 0))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir vendre un produit</p></div>";
        } else {
            include 'vues/vendre/vendrebien.php';
        }
    }

    public function vendreservice() {
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != 0))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir vendre un produit</p></div>";
        } else {
            include 'vues/vendre/vendreservice.php';
        }
    }

}
