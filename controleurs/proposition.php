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
        } else {
            $prop_vendeur = propositions::propostion_vendeur($uti);
            $prop_acheteur = propositions::propostion_acheteur($uti);
            include "vues/proposition/propositions.php";
        }
    }

    public function laproposition() {
        if ((isset($_POST['detail_prop']))) {
            $prop = propositions::get_prop_by_id($_POST['laprop']);
            $utivendeur = Utilisateur::get_by_id($prop->get_idv());
            $utiacheteur = Utilisateur::get_by_id($prop->get_iduti());
            if (isset($_POST['vendeur'])) {
                include "vues/proposition/proposition_vendeur.php";
            } else {
                include "vues/proposition/proposition_acheteur.php";
            }
        } else {
            echo "<div class='warning'><p>Erreur, vous n'avez pas l'accès à cette page</p></div>";
        }
    }

    public static function valid_proposition() {
        if (isset($_POST['valid_prop'])) {
            propositions::proposition_accepte($_POST['idprop']);
            echo "<div class='success'><p>La proposition a été validée avec succès</p></div>";
        }
    }

    public static function annulerproposition() {
        if (isset($_POST['sup_prop'])) {
            propositions::proposition_refuse($_POST['idprop']);
            echo "<div class='success'><p>La proposition a été supprimée avec succès</p></div>";
        }
    }

}
