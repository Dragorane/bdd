<?php

require_once 'modeles/categories.php';
require_once 'modeles/evaluations.php';
require_once 'modeles/biens.php';
require_once 'modeles/services.php';
require_once 'modeles/propositions.php';
require_once 'modeles/utilisateur.php';
require_once 'modeles/photos.php';

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
            $tabbiens = Controller_vendre::tab_biens();
            include 'vues/vendre/vendrebien.php';
            include "vues/menu_cat.php";
            include "vues/lesbiens.php";
        }
    }

    public function vendreservice() {
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != true))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir vendre un produit</p></div>";
        } else {
            $tabcat = categories::list_categ(2);
            include 'vues/vendre/vendreservice.php';
            include "vues/menu_cat.php";
        }
    }

    public function form_vendrebien() {
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != true))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir vendre un produit</p></div>";
        } else {
            include 'vues/vendre/form_vendreservice.php';
            include "vues/menu_cat.php";
        }
    }

    public static function tab_biens() {
        if (isset($_GET['idcat'])) {
            if (isset($_GET['prixcroiss'])) {
                $tabbien = biens::tabbiens_prix_cat($_GET['idcat']);
            } else {
                if (isset($_GET['prixdecroiss'])) {
                    $tabbien = biens::tabbiens_prixdesc_cat($_GET['idcat']);
                } else {
                    if (isset($_GET['evaluation'])) {
                        $tabbien = biens::tabbiens_eval_cat($_GET['idcat']);
                    } else {
                        if (isset($_GET['geoloc'])) {
                            $tabbien = biens::tabbiens_geoloc_cat($_GET['idcat']);
                        } else {
                            $tabbien = biens::tabbiens_cat($_GET['idcat']);
                        }
                    }
                }
            }
        } else {
            if (isset($_GET['prixcroiss'])) {
                $tabbien = biens::tabbiens_prix();
            } else {
                if (isset($_GET['prixdecroiss'])) {
                    $tabbien = biens::tabbiens_prixdesc();
                } else {
                    if (isset($_GET['evaluation'])) {
                        $tabbien = biens::tabbiens_eval();
                    } else {
                        if (isset($_GET['geoloc'])) {
                            $tabbien = biens::tabbiens_geoloc();
                        } else {
                            $tabbien = biens::tabbiens();
                        }
                    }
                }
            }
        }
        return $tabbien;
    }

}
