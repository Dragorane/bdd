<?php

require_once 'modeles/categories.php';
require_once 'modeles/biens.php';
require_once 'modeles/services.php';
require_once 'modeles/propositions.php';
require_once 'modeles/utilisateur.php';

class Controller_proposition {

    public function __construct() {
        
    }

    public function index() {
        $uti = Utilisateur::get_by_pseudo($_SESSION['pseudo']);
        if ($uti == NULL) {
            echo "<div class='warning'><p>Erreur d'identification...</p></div>";
        }
        $prop_vendeur = propositions::propostion_vendeur($uti);
        $prop_acheteur = propositions::propostion_acheteur($uti);
        include "vues/proposition/propositions.php";
    }

    public function laproposition() {
        
    }

}
