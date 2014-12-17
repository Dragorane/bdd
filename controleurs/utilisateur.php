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
                                            $photo = Controller_Utilisateur::path_img($_FILES['photo']);
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

    public function path_img($photo) {
        $content_dir = '/users/info/il3/llaisne/public_html/bdd/images/avatar/'; //dossier où la photo sera stocké
        $tmp_file = $photo['tmp_name'];

        if (!is_uploaded_file($tmp_file)) {
            exit("Le fichier est introuvable");
        }
        // on vérifie maintenant l'extension
        $type_file = $photo['type'];

        if (!strstr($type_file, 'jpg') && !strstr($type_file, 'jpeg') && !strstr($type_file, 'bmp') && !strstr($type_file, 'gif') && !strstr($type_file, 'png')) {
            exit("Le fichier n'est pas une image");
        }
        // on copie le fichier dans le dossier de destination
        $name_file = $photo['name'];
        if (!move_uploaded_file($tmp_file, $content_dir . $name_file)) {
            return null;
        }
        $lienimg = BASEURL . "/images/avatar/" . $photo['name'];
        return $lienimg;
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
        $uti = Utilisateur::get_by_pseudo($_SESSION['pseudo']);
        if ($uti == null) {
            echo "<div class='warning'><p>Erreur, vous n'êtes pas identifié</p></div>";
        } else {
            include 'vues/utilisateurs/gestion_cpt.php';
        }
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
                    $photo = Controller_Utilisateur::path_img($_FILES['photo']);
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
                $content = "<div class='warning'><p>Erreur lorsh de l'identification de votre compte.</p></div>";
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

    public function page_public_uti() {
        if (!isset($_GET['id'])) {
            echo "<div class='warning'><p>Erreur, aucun utilisateur selectionné.</p></div>";
        } else {
            $uti = Utilisateur::get_by_id($_GET['id']);
            if ($uti == null) {
                echo "<div class='warning'><p>Erreur, vous n'êtes pas identifié</p></div>";
            } else {
                include 'vues/utilisateurs/page_uti.php';
            }
        }
    }

}
