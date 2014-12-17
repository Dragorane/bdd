<?php

session_start();

define('SQL_DSN', 'codd.u-strasbg.fr:1521/ROSA');
define('SQL_USERNAME', 'llaisne');
define('SQL_PASSWORD', 'secretent1493');

require_once 'modeles/model_base.php';
require_once 'controleurs/utilisateur.php';
require_once 'controleurs/vendre.php';
require_once 'controleurs/acheter.php';
require_once 'modeles/categories.php';
categories::initcat();
if (isset($_SERVER['PATH_INFO'])) {
    $args = explode('/', $_SERVER['PATH_INFO']);
} else {
    $args = array("/", "/");
}

define('BASEURL', dirname($_SERVER['SCRIPT_NAME']));

Model_Base::set_db();
$titre = "";
ob_start();
$cu = new Controller_Utilisateur();
$cv = new Controller_vendre();
$ca = new Controller_acheter();

//appel des controller
switch ($args[1]) {
    case '/': //index
        $cu->index();
        break;
    //utilisateur
    case 'inscription':
        $cu->inscription();
        break;
    case 'valid_inscri':
        $cu->valid_inscri();
        break;
    case 'connexion':
        $cu->connexion();
        break;
    case 'deconnexion':
        $cu->deconnexion();
        break;
    case 'gestion_compte':
        $cu->gestion_cpt();
        break;
    case 'form_modif_adr':
        $cu->gestion_modif_adr();
        break;
    case 'form_modif_avatar':
        $cu->gestion_modif_avatar();
        break;
    case 'form_modif_email':
        $cu->gestion_modif_email();
        break;
    case 'form_modif_mdp':
        $cu->gestion_modif_mdp();
        break;
    case 'form_modif_nom':
        $cu->gestion_modif_nom();
        break;
    case 'form_modif_pnom':
        $cu->gestion_modif_pnom();
        break;
    case 'form_modif_pseudo':
        $cu->gestion_modif_pseudo();
        break;
    case 'form_modif_tel':
        $cu->gestion_modif_tel();
        break;
    case 'valid_adr':
        $cu->gestion_valid_adr();
        break;
    case 'valid_avatar':
        $cu->gestion_valid_avatar();
        break;
    case 'valid_email':
        $cu->gestion_valid_email();
        break;
    case 'valid_mdp':
        $cu->gestion_valid_mdp();
        break;
    case 'valid_nom':
        $cu->gestion_valid_nom();
        break;
    case 'valid_pnom':
        $cu->gestion_valid_pnom();
        break;
    case 'valid_pseudo':
        $cu->gestion_valid_pseudo();
        break;
    case 'valid_tel':
        $cu->gestion_valid_tel();
        break;
    case 'form_sup_cpt':
        $cu->gestion_sup_cpt();
        break;
    case 'valid_ajout_monnaie':
        $cu->gestion_valid_ajout_monnaie();
        break;
    case 'valid_connect':
        $cu->connexion_valide();
        break;
    //Troc acheter
    case 'acheter' :
        $ca->index();
        break;
    case 'acheterbien' :
        $ca->acheterbien();
        break;
    case 'acheterservice' :
        $ca->acheterservice();
        break;
    //troc vendre
    case 'vendre':
        $cv->index();
        break;
    case 'vendrebien':
        $cv->vendrebien();
        break;
    case 'vendreservice':
        $cv->vendreservice();
        break;
    case 'valid_form_vendre':
        $cv->valide_vendreservice();
        break;
    default :
        echo "<div class='warning'><p>La page demandée n'existe pas.</p></div>";
}

$content = ob_get_clean();
Model_Base::close_db();

include 'vues/template.php';
?>
