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
        $tabcat = categories::list_categ(1);
        $tabbiens = Controller_acheter::tab_biens();
        include 'vues/acheter/acheterbien.php';
        include "vues/menu_cat.php";
        include "vues/filtre_recherche.php";
        echo "<div class='lesbiens'>";
        for ($i = 0; $i < count($tabbiens); $i++) {
            $uti = Utilisateur::get_by_id($tabbiens[$i]->get_uti());
            if ($uti != NULL) {
                include "vues/lesbiens.php";
            } else {
                echo "<div class='warning'><p>erreur pas d'utilisateur " . $tabbiens[$i]->get_uti() . "</p></div>";
            }
        }
        echo "</div>";
    }

    public function acheterservice() {
        $tabcat = categories::list_categ(2);
        include 'vues/acheter/acheterservice.php';
        include "vues/menu_cat.php";
        include "vues/filtre_recherche.php";
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

    public function pagebien() {
        $bien = get_bien_by_id($_GET['id']);
        $uti = Utilisateur::get_by_id($bien->get_uti());
        if (($uti == NULL) || ($bien == NULL)) {
            echo "<div class='warning'><p>Erreur, aucun bien n'est selectionnés</p></div>";
        } else {
            include 'vues/acheter/page_bien.php';
        }
    }

}
