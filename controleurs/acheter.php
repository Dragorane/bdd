<?php

require_once 'modeles/categories.php';
require_once 'modeles/evaluations.php';
require_once 'modeles/biens.php';
require_once 'modeles/services.php';
require_once 'modeles/propositions.php';
require_once 'modeles/utilisateur.php';
require_once 'modeles/photos.php';

class Controller_acheter {

    public function __construct() {
        
    }

    /* Page index */

    public function index() {
        include 'vues/acheter/index.php';
    }

    public function acheterbien() {
        $type_categorie = 1;
        include 'vues/acheter/acheterbien.php';
        include "vues/menu_cat.php";
    }

    public function acheterservice() {
        $type_categorie = 2;
        include 'vues/acheter/acheterservice.php';
        include "vues/menu_cat.php";
    }

}
