<?php

session_start();

define('SQL_DSN', 'codd.u-strasbg.fr:1521/ROSA');
define('SQL_USERNAME', 'llaisne');
define('SQL_PASSWORD', 'secretent1493');

require_once 'modeles/model_base.php';
require_once 'controleurs/utilisateur.php';
require_once 'controleurs/object.php';

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
$co = new Controller_Object();

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
    case 'form_sup_cpt':
        $cu->gestion_sup_cpt();
        break;
    case 'valid_ajout_monnaie':
        $cu->gestion_valid_ajout_monnaie();
        break;
    case 'valid_connect':
        $cu->connexion_valide();
        break;
    case 'objet_form':
        $co->objet_form();
        break;
    case 'objet':
        $co->objet();
        break;
    case 'objet_id':
        if (isset($args[2])) {
            $co->objet_id($args[2]);
        }
        break;
    case 'all_object' :
        $co->all_object();
        break;
    default :
        echo "<div class='warning'><p>La page demandée n'existe pas.</p></div>";
}

$content = ob_get_clean();
Model_Base::close_db();

include 'vues/template.php';
?>
