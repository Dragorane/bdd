<?php

require_once 'modeles/utilisateur.php';

class Controller_Utilisateur {

    public function __construct() {
        
    }

    /* Page index */

    public function index() {
        include 'vues/principale.php';
    }

    /* Connexion / inscription d'un utilisateur */
    /* Formulaire d'Inscription */

    public function inscription() {
        include 'vues/utilisateurs/form_inscription.php';
    }

    /* Validation du formulaire d'inscription et appel du modele */

    public function valid_inscri() {
        //verification des champs obligatoire
        $verif = 0;
        if ((!isset($_POST['pseudo'])) || ($_POST['pseudo'] == null) || ($_POST['pseudo'] == '')) {
            echo "<div class='warning'><p>Erreur, Le pseudo n'a pas été saisi.</p></div>";
        } else {
            if ((!isset($_POST['mdp'])) || ($_POST['mdp'] == null) || ($_POST['mdp'] == '')) {
                echo "<div class='warning'><p>Erreur, le mot de passe n'a pas été saisi.</p></div>";
            } else {
                if ((!isset($_POST['verif_mdp'])) || ($_POST['verif_mdp'] == null) || ($_POST['verif_mdp'] == '')) {
                    echo "<div class='warning'><p>Erreur, les mots de passe ne sont pas similaires.</p></div>";
                } else {
                    if ((!isset($_POST['mail'])) || ($_POST['mail'] == null) || ($_POST['mail'] == '')) {
                        echo "<div class='warning'><p>Erreur, l'adresse e-mail n'a pas été saisie.</p></div>";
                    } else {
                        if ((!isset($_POST['verif_mail'])) || ($_POST['verif_mail'] == null) || ($_POST['verif_mail'] == '')) {
                            echo "<div class='warning'><p>Erreur, les adresses email ne sont pas similaires.</p></div>";
                        } else {
                            if ((!isset($_POST['securite'])) || ($_POST['securite'] != '42')) {
                                echo "<div class='warning'><p>Erreur, le code de sécurité n'est pas valide.</p></div>";
                            } else {
                                //verification de l'unicité du pseudonyme
                                if (Utilisateur::verif_pseudo($_POST['pseudo']) == false) {
                                    echo "<div class='warning'><p>Erreur, le pseudonyme saisie n'est pas disponible.</p></div>";
                                } else {
                                    //verification de la saisie de mdp et du mail
                                    if ($_POST['mail'] != $_POST['verif_mail']) {
                                        echo "<div class='warning'><p>Erreur, les adresses emails saisient ne correspondent pas2.</p></div>";
                                    } else {
                                        if ($_POST['mdp'] != $_POST['verif_mdp']) {
                                            echo "<div class='warning'><p>Erreur, les mots de passes saisient ne correspondent pas.</p></div>";
                                        } else {
                                            //on ajoute l'utilisateur à la base de donnée
                                            $photo = Utilisateur::path_img();
                                            $verif = 1;
                                            $uti = Utilisateur::create($_POST['nom'], $_POST['pnom'], $_POST['pseudo'], $_POST['mdp'], $_POST['adr'], $_POST['mail'], $_POST['tel'], 0, 0, $photo);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($verif == 0) {
            echo "<a href='javascript:history.back()'><h2 class='center'>Retour au formulaire d'inscription</h2></a>";
        } else {
            echo "<div class='success'><p>L'utilisateur a bien été ajouté, vous pouvez vous conneter.</p></div>";
        }
    }

    /* Création du path vers l'avatar de l'utilisateur */

    public function path_img() {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION); //recupération de l'extension de la photo
        $content_dir = 'images/avatar/'; //dossier où la photo sera stocké
        $filename = $_FILES['photo']['tmp_name'];
        $filesize = getimagesize($filename);
        if ($ext == 'jpg') { //photo en jpg
            $source = imagecreatefromjpeg($filename);
        }
        if ($ext == 'gif') {//photo en gif
            $source = imagecreatefromgif($filename);
        }
        if ($ext == 'png') {//photo en png
            $source = imagecreatefrompng($filename);
        }
        $nouv_w = 175; //width de redimensionnement
        $nouv_h = round(($nouv_w / $filesize[0]) * $filesize[1]); //calcul height en fonction de width
        //$nouv_h = 175;
        $destination = imagecreatetruecolor($nouv_w, $nouv_h);
        ImageCopyResampled($destination, $source, 0, 0, 0, 0, $nouv_w, $nouv_h, $filesize[0], $filesize[1]);
        header('Content-type: image/png');
        if (imagepng($destination, $content_dir . $_FILES['photo']['name'])) {
            $etatcopie = 1;
        } else {
            $etatcopie = 0;
        }
        imagedestroy($destination);

        if ($etatcopie == 0) {
            return NULL;
        } else {
            $lienimg = "http://turing.u-strasbg.fr/~llaisne/bdd/images/avatar/" . $_FILES['photo']['name'];
            return $lienimg;
        }
    }

    /* Formulaire de connexion d'un utilisateur */

    public function connexion() {
        if (isset($_SESSION['connect'])) {
            echo "<div class='warning'><p>Vous êtes déjà connecté.</p></div>";
        } else {
            include 'vues/utilisateurs/connexion_form.php';
        }
    }

    /* Deconnexion d'un utilisateur et redirection vers l'index */

    public function deconnexion() {
        if (!isset($_SESSION['connect'])) {
            echo "<div class='warning'><p>Vous n'êtes pas connecté.</p></div>";
        }
        // Autre possibilitÃ©s, redirection vers la page principale
        else {
            echo "<div class='success'><p>Vous êtes déconnecté.</p></div>";
            session_unset();
            session_destroy();
            header('Location: ' . BASEURL . '/index.php');
            exit();
        }
    }

    /* Validation de la connexion saisie par l'utilisateur et création de la session. */

    public function connexion_valide() {
        $uti = Utilisateur::get_by_pseudo_mdp($_POST['pseudo'], $_POST['password']);
        if (isset($_SESSION['connect'])) {
            $content = "<div class='warning'><p>Vous êtes déjà connecté.</p></div>";
        } else {
            if ($uti != null) {
                echo "<div class='success'><p>Vous êtes connecté.</p></div>";
                $_SESSION['connect'] = true;
                $_SESSION['pseudo'] = $uti->pseudo();
                $_SESSION['mdp'] = $uti->mdp();
            } else {
                echo "<div class='warning'><p>Login ou mot de passe incorrect.</p></div>";
            }
        }
    }

    /* Page et fonction de Gestion de compte */

    /* Accès à la page principale de gestion de compte */

    public function gestion_cpt() {
        include 'vues/utilisateurs/gestion_cpt.php';
    }

    /* Accès au formulaire de modification du mot de passe */

    public function gestion_modif_mdp() {
        include 'vues/utilisateurs/form_modif_mdp.php';
    }

    /* Accès au formulaire de modification adresse */

    public function gestion_modif_adr() {
        include 'vues/utilisateurs/form_modif_adr.php';
    }

    /* Accès au formulaire de modification avatar */

    public function gestion_modif_avatar() {
        include 'vues/utilisateurs/form_modif_avatar.php';
    }

    /* Accès au formulaire de modification email */

    public function gestion_modif_email() {
        include 'vues/utilisateurs/form_modif_email.php';
    }

    /* Accès au formulaire de modification du nom */

    public function gestion_modif_nom() {
        include 'vues/utilisateurs/form_modif_nom.php';
    }

    /* Accès au formulaire de modification prénom */

    public function gestion_modif_pnom() {
        include 'vues/utilisateurs/form_modif_pnom.php';
    }

    /* Accès au formulaire de modification pseudo */

    public function gestion_modif_pseudo() {
        include 'vues/utilisateurs/form_modif_pseudo.php';
    }

    /* Accès au formulaire de modification telephone */

    public function gestion_modif_tel() {
        include 'vues/utilisateurs/form_modif_tel.php';
    }

    /* valide formulaire de modification du mot de passe */

    public function gestion_valid_mdp() {
        $uti = Utilisateur::get_by_pseudo_mdp($_SESSION['pseudo'], $_SESSION['mdp']);
        if (!isset($_SESSION['connect'])) {
            $content = "<div class='warning'><p>Vous n'êtes pas connecté.</p></div>";
        } else {
            if ($uti != null) {
                if (isset($_POST['submit'])) {
                    if ($_POST['mdp'] == $_POST['verif_mdp']) {
                        $uti->set_mdp($_POST['mdp']);
                        echo "<div class='success'><p>Votre mot de passe a été modifié.</p></div>";
                    } else {
                        $content = "<div class='warning'><p>Erreur : les mots de passes saisient ne sont pas similaires...</p></div>";
                    }
                } else {
                    $content = "<div class='warning'><p>Formulaire non validé. Vous ne pouvez pas ajouter de point troc.</p></div>";
                }
            } else {
                $content = "<div class='warning'><p>Erreur lors de l'identification de votre compte.</p></div>";
            }
        }
    }

    /* valide formulaire de modification adresse */

    public function gestion_valid_adr() {
        $uti = Utilisateur::get_by_pseudo_mdp($_SESSION['pseudo'], $_SESSION['mdp']);
        if (!isset($_SESSION['connect'])) {
            $content = "<div class='warning'><p>Vous n'êtes pas connecté.</p></div>";
        } else {
            if ($uti != null) {
                if (isset($_POST['submit'])) {
                    $uti->set_adr($_POST['adr']);
                    echo "<div class='success'><p>Votre adresse a été modifié.</p></div>";
                } else {
                    $content = "<div class='warning'><p>Formulaire non validé. Vous ne pouvez pas ajouter de point troc.</p></div>";
                }
            } else {
                $content = "<div class='warning'><p>Erreur lors de l'identification de votre compte.</p></div>";
            }
        }
    }

    /* valide de modification avatar */

    public function gestion_valid_avatar() {
        $uti = Utilisateur::get_by_pseudo_mdp($_SESSION['pseudo'], $_SESSION['mdp']);
        if (!isset($_SESSION['connect'])) {
            $content = "<div class='warning'><p>Vous n'êtes pas connecté.</p></div>";
        } else {
            if ($uti != null) {
                if (isset($_POST['submit'])) {
                    $photo = $uti->path_img();
                    $uti->set_avatar($photo);
                    echo "<div class='success'><p>Votre avatar a été modifié.</p></div>";
                } else {
                    $content = "<div class='warning'><p>Formulaire non validé. Vous ne pouvez pas ajouter de point troc.</p></div>";
                }
            } else {
                $content = "<div class='warning'><p>Erreur lors de l'identification de votre compte.</p></div>";
            }
        }
    }

    /* valid de modification email */

    public function gestion_valid_email() {
        $uti = Utilisateur::get_by_pseudo_mdp($_SESSION['pseudo'], $_SESSION['mdp']);
        if (!isset($_SESSION['connect'])) {
            $content = "<div class='warning'><p>Vous n'êtes pas connecté.</p></div>";
        } else {
            if ($uti != null) {
                if (isset($_POST['submit'])) {
                    $uti->set_email($_POST['email']);
                    echo "<div class='success'><p>Votre adresse mail a été modifié.</p></div>";
                } else {
                    $content = "<div class='warning'><p>Formulaire non validé. Vous ne pouvez pas ajouter de point troc.</p></div>";
                }
            } else {
                $content = "<div class='warning'><p>Erreur lors de l'identification de votre compte.</p></div>";
            }
        }
    }

    /* valid de modification du nom */

    public function gestion_valid_nom() {
        $uti = Utilisateur::get_by_pseudo_mdp($_SESSION['pseudo'], $_SESSION['mdp']);
        if (!isset($_SESSION['connect'])) {
            $content = "<div class='warning'><p>Vous n'êtes pas connecté.</p></div>";
        } else {
            if ($uti != null) {
                if (isset($_POST['submit'])) {
                    $uti->set_nom($_POST['nom']);
                    echo "<div class='success'><p>Votre nom a été modifié.</p></div>";
                } else {
                    $content = "<div class='warning'><p>Formulaire non validé. Vous ne pouvez pas ajouter de point troc.</p></div>";
                }
            } else {
                $content = "<div class='warning'><p>Erreur lors de l'identification de votre compte.</p></div>";
            }
        }
    }

    /* valid de modification prénom */

    public function gestion_valid_pnom() {
        $uti = Utilisateur::get_by_pseudo_mdp($_SESSION['pseudo'], $_SESSION['mdp']);
        if (!isset($_SESSION['connect'])) {
            $content = "<div class='warning'><p>Vous n'êtes pas connecté.</p></div>";
        } else {
            if ($uti != null) {
                if (isset($_POST['submit'])) {
                    $uti->set_pnom($_POST['pnom']);
                    echo "<div class='success'><p>Votre prénom a été modifié.</p></div>";
                } else {
                    $content = "<div class='warning'><p>Formulaire non validé. Vous ne pouvez pas ajouter de point troc.</p></div>";
                }
            } else {
                $content = "<div class='warning'><p>Erreur lors de l'identification de votre compte.</p></div>";
            }
        }
    }

    /* valid de modification pseudo */

    public function gestion_valid_pseudo() {
        $uti = Utilisateur::get_by_pseudo_mdp($_SESSION['pseudo'], $_SESSION['mdp']);
        if (!isset($_SESSION['connect'])) {
            $content = "<div class='warning'><p>Vous n'êtes pas connecté.</p></div>";
        } else {
            if ($uti != null) {
                if (isset($_POST['submit'])) {
                    $uti->set_pseudo($_POST['pseudo']);
                    echo "<div class='success'><p>Votre pseudo a été modifié.</p></div>";
                } else {
                    $content = "<div class='warning'><p>Formulaire non validé. Vous ne pouvez pas ajouter de point troc.</p></div>";
                }
            } else {
                $content = "<div class='warning'><p>Erreur lors de l'identification de votre compte.</p></div>";
            }
        }
    }

    /* valid de modification telephone */

    public function gestion_valid_tel() {
        $uti = Utilisateur::get_by_pseudo_mdp($_SESSION['pseudo'], $_SESSION['mdp']);
        if (!isset($_SESSION['connect'])) {
            $content = "<div class='warning'><p>Vous n'êtes pas connecté.</p></div>";
        } else {
            if ($uti != null) {
                if (isset($_POST['submit'])) {
                    $uti->set_tel($_POST['tel']);
                    echo "<div class='success'><p>Votre téléphone a été modifié.</p></div>";
                } else {
                    $content = "<div class='warning'><p>Formulaire non validé. Vous ne pouvez pas ajouter de point troc.</p></div>";
                }
            } else {
                $content = "<div class='warning'><p>Erreur lors de l'identification de votre compte.</p></div>";
            }
        }
        include 'vues/utilisateurs/gestion_cpt.php';
    }

    /* Accès au formulaire de suppression de compte */

    public function gestion_sup_cpt() {
        include 'vues/utilisateurs/form_sup_cpt.php';
    }

    /* Accès au formulaire de modification */

    public function gestion_valid_ajout_monnaie() {
        $uti = Utilisateur::get_by_pseudo_mdp($_SESSION['pseudo'], $_SESSION['mdp']);
        if (!isset($_SESSION['connect'])) {
            $content = "<div class='warning'><p>Vous n'êtes pas connecté.</p></div>";
        } else {
            if ($uti != null) {
                if (isset($_POST['submit'])) {
                    $uti->ajout_pt($_POST['monnaie']);
                } else {
                    $content = "<div class='warning'><p>Formulaire non validé. Vous ne pouvez pas ajouter de point troc.</p></div>";
                }
            } else {
                $content = "<div class='warning'><p>Erreur lors de l'identification de votre compte.</p></div>";
            }
        }
        include 'vues/utilisateurs/gestion_cpt.php';
    }

}
