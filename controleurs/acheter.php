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
        echo "<h2 class='center'>Acheter un bien</h2>";
        include "vues/menu_cat.php";
        include "vues/filtre_recherche.php";
        echo "<div class='lesbiens'>";
        for ($i = 0; $i < count($tabbiens); $i++) {
            $uti = Utilisateur::get_by_id($tabbiens[$i]->get_uti());
            $bien = $tabbiens[$i];
            if ($uti != NULL) {
                echo "<div class='unbien'>";
                include "vues/afficher_bien.php";
                echo "<h4 class='center'><a href='pagebien?id=" . $bien->get_id() . "'>Acheter / En savoir plus ...</a></h4>";
                echo "</div>";
            } else {
                echo "<div class='warning'><p>erreur pas d'utilisateur " . $tabbiens->get_uti() . "</p></div>";
            }
        }
        echo "</div>";
    }

    public function acheterservice() {
        $tabcat = categories::list_categ(2);
        $tabserv = Controller_acheter::tab_services();
        echo "<h2 class='center'>Acheter un service</h2>";
        include "vues/menu_cat.php";
        include "vues/filtre_recherche.php";
        echo "<div class='lesbiens'>";
        for ($i = 0; $i < count($tabserv); $i++) {
            $uti = Utilisateur::get_by_id($tabserv[$i]->get_uti());
            $serv = $tabserv[$i];
            if ($uti != NULL) {
                echo "<div class='unservice'>";
                include "vues/afficher_service.php";
                echo "<h4 class='center'><a href='pageservice?id=" . $serv->get_id() . "'>Acheter / En savoir plus ...</a></h4>";
                echo "</div>";
            } else {
                echo "<div class='warning'><p>erreur pas d'utilisateur " . $serv->get_uti() . "</p></div>";
            }
        }
        echo "</div>";
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

    public static function tab_services() {
        if (isset($_GET['idcat'])) {
            if (isset($_GET['prixcroiss'])) {
                $tabserv = services::tabservices_prix_cat($_GET['idcat']);
            } else {
                if (isset($_GET['prixdecroiss'])) {
                    $tabserv = services::tabservices_prixdesc_cat($_GET['idcat']);
                } else {
                    if (isset($_GET['evaluation'])) {
                        $tabserv = services::tabservices_eval_cat($_GET['idcat']);
                    } else {
                        if (isset($_GET['geoloc'])) {
                            $tabserv = services::tabservices_geoloc_cat($_GET['idcat']);
                        } else {
                            $tabserv = services::tabservices_cat($_GET['idcat']);
                        }
                    }
                }
            }
        } else {
            if (isset($_GET['prixcroiss'])) {
                $tabserv = services::tabservices_prix();
            } else {
                if (isset($_GET['prixdecroiss'])) {
                    $tabserv = services::tabservices_prixdesc();
                } else {
                    if (isset($_GET['evaluation'])) {
                        $tabserv = services::tabservices_eval();
                    } else {
                        if (isset($_GET['geoloc'])) {
                            $tabserv = services::tabservices_geoloc();
                        } else {
                            $tabserv = services::tabservices();
                        }
                    }
                }
            }
        }
        return $tabserv;
    }

    public function pagebien() {
        if (isset($_GET['id'])) {
            $bien = biens::get_bien_by_id($_GET['id']);
            $uti = Utilisateur::get_by_id($bien->get_uti());
            if (($uti == NULL) || ($bien == NULL)) {
                echo "<div class='warning'><p>Erreur, aucun bien n'est selectionnés</p></div>";
            } else {
                $tabeval = evaluations::tabeval_bien($bien->get_id());
                $moyeval = evaluations::moy_eval_bien($bien->get_id());
                echo "<h2 class='center'>Page du bien sélectionné </h2>";
                echo "<div class='div_page_bien_serv'>";
                include "vues/afficher_bien.php";
                include 'vues/acheter/page_bien.php';
            }
        } else {
            echo "<div class='warning'><p>Erreur, aucun bien n'est selectionnés</p></div>";
        }
    }

    public function pageservice() {
        if (isset($_GET['id'])) {
            $serv = services::get_serv_by_id($_GET['id']);
            $uti = Utilisateur::get_by_id($serv->get_uti());
            if (($uti == NULL) || ($serv == NULL)) {
                echo "<div class='warning'><p>Erreur, aucun bien n'est selectionnés</p></div>";
            } else {
                $tabeval = evaluations::tabeval_service($serv->get_id());
                $moyeval = evaluations::moy_eval_serv($serv->get_id());
                echo "<h2 class='center'>Page du service sélectionné </h2>";
                echo "<div class='div_page_bien_serv'>";
                include "vues/afficher_service.php";
                include 'vues/acheter/page_service.php';
            }
        }
    }

    public function acheter_biens_pts() {
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != true))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir vendre un produit</p></div>";
        } else {
            if (isset($_GET['id'])) {
                $bien = biens::get_bien_by_id($_GET['id']);
                $uti = Utilisateur::get_by_pseudo($_SESSION['pseudo']);
                if (($bien == null) || ($uti == null)) {
                    echo "<div class='warning'><p>Erreur, aucun bien de selectionné</p></div>";
                } else {
                    $verif = $this->verifpts($uti, $bien);
                    include 'vues/acheter/acheter_bien_pts.php';
                    echo "<div class='div_page_bien_serv'>";
                    echo "<h4 class='center'>Rappel du bien séléctionné</h4>";
                    include "vues/afficher_bien.php";
                    echo "</div>";
                }
            }
        }
    }

    public function acheter_service_pts() {
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != true))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir vendre un produit</p></div>";
        } else {
            if (isset($_GET['id'])) {
                $serv = services::get_serv_by_id($_GET['id']);
                $uti = Utilisateur::get_by_pseudo($_SESSION['pseudo']);
                if (($serv == null) || ($uti == null)) {
                    echo "<div class='warning'><p>Erreur, aucun bien de selectionné</p></div>";
                } else {
                    $verif = $this->verifpts($uti, $serv);
                    include 'vues/acheter/acheter_service_pts.php';
                    echo "<div class='div_page_bien_serv'>";
                    echo "<h4 class='center'>Rappel du service séléctionné</h4>";
                    include "vues/afficher_service.php";
                    echo "</div>";
                }
            }
        }
    }

    public function acheter_biens_bienserv() {
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != true))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir acheter un produit</p></div>";
        } else {
            if (isset($_GET['id'])) {
                $bien = biens::get_bien_by_id($_GET['id']);
                $uti = Utilisateur::get_by_pseudo($_SESSION['pseudo']);
                if (($bien == null) || ($uti == null)) {
                    echo "<div class='warning'><p>Erreur, aucun bien de selectionné</p></div>";
                } else {
                    $tabbien = biens::get_tabbien_by_uti($_SESSION['pseudo']);
                    $tabserv = services::get_tabserv_by_uti($_SESSION['pseudo']);
                    include 'vues/acheter/acheter_bien_obj.php';
                    echo "<div class='div_page_bien_serv'>";
                    echo "<h4 class='center'>Rappel du bien séléctionné</h4>";
                    include "vues/afficher_bien.php";
                    echo "</div>";
                }
            }
        }
    }

    public function acheter_service_bienserv() {
        if ((!isset($_SESSION['connect']) || ($_SESSION['connect'] != true))) {
            echo "<div class='warning'><p>Erreur, vous devez être connecté pour pouvoir acheter un produit</p></div>";
        } else {
            if (isset($_GET['id'])) {
                $serv = services::get_serv_by_id($_GET['id']);
                $uti = Utilisateur::get_by_pseudo($_SESSION['pseudo']);
                if (($serv == null) || ($uti == null)) {
                    echo "<div class='warning'><p>Erreur, aucun bien de selectionné</p></div>";
                } else {
                    $tabbien = biens::get_tabbien_by_uti($_SESSION['pseudo']);
                    $tabserv = services::get_tabserv_by_uti($_SESSION['pseudo']);
                    include 'vues/acheter/acheter_serv_obj.php';
                    echo "<div class='div_page_bien_serv'>";
                    echo "<h4 class='center'>Rappel du service séléctionné</h4>";
                    include "vues/afficher_service.php";
                    echo "</div>";
                }
            }
        }
    }

    public function valid_acheter_bien_obj() {
        if ((is_numeric($_POST['bien'])) && (isset($_POST['valid_acheter_bien_pts']))) {
            $bien = biens::get_bien_by_id($_POST['bien']);
            $utiacheter = Utilisateur::get_by_pseudo($_SESSION['pseudo']);
            if (($bien == null) || ($utiacheter == null)) {
                echo "<div class='warning'><p>Erreur, aucun bien de selectionné</p></div>";
            } else {
                $date = explode("/", $_POST['date']);
                if ((isset($date[0])) && (isset($date[1])) && (isset($date[2]))) {
                    $verif = $this->verifierDate($date[1], $date[0], $date[2]);
                } else {
                    $verif = 0;
                }
                if ($verif == 0) {
                    echo "<div class='warning'><p>Erreur, la date saisie n'est pas correcte.</p></div>";
                } else {
                    $laprop = propositions::create($_POST['adr'], $_POST['date'], $bien->get_prix(), $utiacheter->id(), $bien->get_uti());
                    if ($laprop == null) {
                        echo "<div class='warning'><p>Erreur, la proposition n'a pas été enregistrée</p></div>";
                    } else {
                        $laprop->ajout_bien_proposition($bien);
                        $type = explode(':', $_POST['obj']);
                        if ($type[0] == "bien") {
                            $bien2 = biens::get_bien_by_id($type[1]);
                            $laprop->ajout_bien_proposition($bien2);
                        } else {
                            $serv = services::get_serv_by_id($type[1]);
                            $laprop->ajout_service_proposition($serv, $_POST['date']);
                        }
                        include "vues/acheter/valid_acheter_bien.php";
                    }
                }
            }
        } else {
            echo "<div class='warning'><p>Erreur, vous n'avez pas accès à cette page.</p></div>";
        }
    }

    public function valid_acheter_service_obj() {
        if ((is_numeric($_POST['bien'])) && (isset($_POST['valid_acheter_bien_pts']))) {
            $serv = services::get_serv_by_id($_POST['bien']);
            $utiacheter = Utilisateur::get_by_pseudo($_SESSION['pseudo']);
            if (($serv == null) || ($utiacheter == null)) {
                echo "<div class='warning'><p>Erreur, aucun bien de selectionné</p></div>";
            } else {
                $date = explode("/", $_POST['date']);
                if ((isset($date[0])) && (isset($date[1])) && (isset($date[2]))) {
                    $verif = $this->verifierDate($date[1], $date[0], $date[2]);
                } else {
                    $verif = 0;
                }
                if ($verif == 0) {
                    echo "<div class='warning'><p>Erreur, la date saisie n'est pas correcte.</p></div>";
                } else {
                    $laprop = propositions::create($_POST['adr'], $_POST['date'], $serv->get_prix(), $utiacheter->id(), $serv->get_uti());
                    if ($laprop == null) {
                        echo "<div class='warning'><p>Erreur, la proposition n'a pas été enregistrée</p></div>";
                    } else {
                        $laprop->ajout_service_proposition($serv, $_POST['date']);
                        $type = explode(':', $_POST['obj']);
                        if ($type[0] == "bien") {
                            $bien2 = biens::get_bien_by_id($type[1]);
                            $laprop->ajout_bien_proposition($bien2);
                        } else {
                            $serv = services::get_serv_by_id($type[1]);
                            $laprop->ajout_service_proposition($serv, $_POST['date']);
                        }
                        include "vues/acheter/valid_acheter_serv.php";
                    }
                }
            }
        } else {
            echo "<div class='warning'><p>Erreur, vous n'avez pas accès à cette page.</p></div>";
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
                    if ((isset($date[0])) && (isset($date[1])) && (isset($date[2]))) {
                        $verif = $this->verifierDate($date[1], $date[0], $date[2]);
                    } else {
                        $verif = 0;
                    }
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

    public function valid_acheter_service_pts() {
        if ((is_numeric($_POST['serv'])) && (isset($_POST['valid_acheter_serv_pts']))) {
            $serv = services::get_serv_by_id($_POST['serv']);
            $utiacheter = Utilisateur::get_by_pseudo($_SESSION['pseudo']);
            if (($serv == null) || ($utiacheter == null)) {
                echo "<div class='warning'><p>Erreur, aucun bien de selectionné</p></div>";
            } else {
                $verif = $this->verifpts($utiacheter, $serv);
                if ($verif == 0) {
                    echo "<div class='warning'><p>Erreur, vous n'avez pas assez de points trocs pour acheter le bien.</p></div>";
                } else {
                    $date = explode("/", $_POST['date']);
                    if ((isset($date[0])) && (isset($date[1])) && (isset($date[2]))) {
                        $verif = $this->verifierDate($date[1], $date[0], $date[2]);
                    } else {
                        $verif = 0;
                    }
                    if ($verif == 0) {
                        echo "<div class='warning'><p>Erreur, la date saisie n'est pas correcte.</p></div>";
                    } else {
                        $laprop = propositions::create($_POST['adr'], $_POST['date'], $serv->get_prix(), $utiacheter->id(), $serv->get_uti());
                        if ($laprop == null) {
                            echo "<div class='warning'><p>Erreur, la proposition n'a pas été enregistrée</p></div>";
                        } else {
                            $laprop->ajout_service_proposition($serv, $_POST['date']);
                            include "vues/acheter/valid_acheter_serv.php";
                        }
                    }
                }
            }
        } else {
            echo "<div class='warning'><p>Erreur, l'achat n'a pas été effectué.</p></div>";
        }
    }

    public function valid_eval_bien() {
        if (isset($_POST['valid_eval'])) {
            $uti = Utilisateur::get_by_pseudo($_SESSION['pseudo']);
            evaluations::nouvelle_eval_bien($_POST['titre'], $_POST['comm'], $_POST['note'], $uti->id(), $_POST['id']);
            echo "<div class='success'><p>Votre évaliation a bien été ajoutée.</p></div>";
            echo "<br/><a href='javascript:history.back()'><h3 class='center'>Retour à la page du bien...</h3></a>";
        } else {
            echo "<div class='warning'><p>Erreur, vous n'avez pas accès à cette page.</p></div>";
        }
    }

    public function valid_eval_service() {
        if (isset($_POST['valid_eval'])) {
            $uti = Utilisateur::get_by_pseudo($_SESSION['pseudo']);
            evaluations::nouvelle_eval_service($_POST['titre'], $_POST['comm'], $_POST['note'], $uti->id(), $_POST['id']);
            echo "<div class='success'><p>Votre évaliation a bien été ajoutée.</p></div>";
            echo "<br/><a href='javascript:history.back()'><h3 class='center'>Retour à la page du service...</h3></a>";
        } else {
            echo "<div class='warning'><p>Erreur, vous n'avez pas accès à cette page.</p></div>";
        }
    }

//fonction générales
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
