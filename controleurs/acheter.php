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
            $bien = $tabbiens[$i];
            if ($uti != NULL) {
                echo "<div class='unbien'>";
                include "vues/afficher_bien.php";
                echo "<h4 class='center'><a href='pagebien?id=" . $bien->get_id() . "'>Acheter / En savoir plus ...</h4>";
                echo "</div>";
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
        $bien = biens::get_bien_by_id($_GET['id']);
        $uti = Utilisateur::get_by_id($bien->get_uti());
        if (($uti == NULL) || ($bien == NULL)) {
            echo "<div class='warning'><p>Erreur, aucun bien n'est selectionnés</p></div>";
        } else {
            include "vues/afficher_bien.php";
            include 'vues/acheter/page_bien.php';
        }
    }

    public function acheter_biens_pts() {
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != true))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir vendre un produit</p></div>";
        } else {
            $bien = biens::get_bien_by_id($_GET['id']);
            $uti = Utilisateur::get_by_pseudo($_SESSION['pseudo']);
            if (($bien == null) || ($uti == null)) {
                echo "<div class='warning'><p>Erreur, aucun bien de selectionné</p></div>";
            } else {
                $verif = $this->verifpts($uti, $bien);
                include 'vues/acheter/acheter_bien_pts.php';
                include "vues/afficher_bien.php";
            }
        }
    }

    public function acheter_biens_bienserv() {
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != true))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir acheter un produit</p></div>";
        } else {
            $bien = biens::get_bien_by_id($_GET['id']);
            $uti = Utilisateur::get_by_pseudo($_SESSION['pseudo']);
        }
    }

    public function valid_acheter_bien_pts() {
        if ((is_numeric($_POST['bien'])) && (isset($_POST['valid_acheter_bien_pts']))) {
            $bien = biens::get_bien_by_id($_POST['bien']);
            $utiacheter = Utilisateur::get_by_pseudo($_SESSION['pseudo']);
            if (($bien == null) || ($utiacheter == null)) {
                echo "<div class='warning'><p>Erreur, aucun bien de selectionné</p></div>";
            } else {
                $verif = $this->verifpts($utiacheter, $bien);
                if ($verif == 0) {
                    echo "<div class='warning'><p>Erreur, vous n'avez pas assez de points trocs pour acheter le bien.</p></div>";
                } else {
                    $date = explode("/", $_POST['date']);
                    $verif = $this->verifierDate($date[1], $date[0], $date[2]);
                    if ($verif == 0) {
                        echo "<div class='warning'><p>Erreur, la date saisie n'est pas correcte.</p></div>";
                    } else {
                        $laprop = propositions::create($_POST['adr'], $_POST['date'], $bien->get_prix(), $utiacheter->id(), $bien->get_uti());
                        if ($laprop == null) {
                            echo "<div class='warning'><p>Erreur, la proposition n'a pas été enregistrée</p></div>";
                        } else {
                            $laprop->ajout_bien_proposition($bien);
                            include "vues/acheter/valid_acheter_bien.php";
                        }
                    }
                }
            }
        } else {
            echo "<div class='warning'><p>Erreur, l'achat n'a pas été effectué.</p></div>";
        }
    }

    public function verifpts($uti, $bien) {
        if ($uti->pt_troc() >= $bien->get_prix()) {
            return 1;
        } else {
            return 0;
        }
    }

    public function verifierDate($month, $day, $year) {
        if (checkdate($month, $day, $year) == true) {
            return 1;
        } else {
            return 0;
        }
    }

}
