<?php

require_once 'modeles/model_base.php';

class Utilisateur extends Model_Base {

    private $_id;
    private $_nom;
    private $_pnom;
    private $_pseudo;
    private $_mdp;
    private $_adr;
    private $_email;
    private $_tel;
    private $_posigeox;
    private $_posigeoy;
    private $_photo;
    private $_point_troc;

    public function __construct($id, $nom, $pnom, $pseudo, $mdp, $adr, $email, $tel, $posix, $posiy, $photo, $pointtroc) {
        $this->_id = $id;
        $this->_nom = $nom;
        $this->_pnom = $pnom;
        $this->_pseudo = $pseudo;
        $this->_mdp = $mdp;
        $this->_adr = $adr;
        $this->_email = $email;
        $this->_tel = $tel;
        $this->_posigeox = $posix;
        $this->_posigeoy = $posiy;
        $this->_photo = $photo;
        $this->_point_troc = $pointtroc;
    }

    // Setter et Getter

    public static function create($nom, $pnom, $pseudo, $mdp, $adr, $email, $tel, $posix, $posiy, $photo) {
        $query = "INSERT INTO Utilisateurs VALUES (Utilisateurs_seq.nextval,:pseudo,:mdp,:pnom,:nom,:adr,:email,:posix,:posiy,:tel,:photo,0,1)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion utilisateur" . oci_error($conn));
        //formatage des variables et sécurité
        $nom_verif = stripslashes(htmlspecialchars($nom));
        $pnom_verif = stripslashes(htmlspecialchars($pnom));
        $pseudo_verif = stripslashes(htmlspecialchars($pseudo));
        $mdp_verif = sha1(stripslashes(htmlspecialchars($mdp)));
        $adr_verif = stripslashes(htmlspecialchars($adr));
        $email_verif = stripslashes(htmlspecialchars($email));
        $tel_verif = stripslashes(htmlspecialchars($tel));
        $photo_verif = stripslashes(htmlspecialchars($photo));
        $posix_verif = stripslashes(htmlspecialchars($posix));
        $posiy_verif = stripslashes(htmlspecialchars($posiy));
        oci_bind_by_name($stmt, ":pseudo", $pseudo_verif);
        oci_bind_by_name($stmt, ":mdp", $mdp_verif);
        oci_bind_by_name($stmt, ":pnom", $pnom_verif);
        oci_bind_by_name($stmt, ":nom", $nom_verif);
        oci_bind_by_name($stmt, ":adr", $adr_verif);
        oci_bind_by_name($stmt, ":email", $email_verif);
        oci_bind_by_name($stmt, ":posix", $posix_verif);
        oci_bind_by_name($stmt, ":posiy", $posiy_verif);
        oci_bind_by_name($stmt, ":tel", $tel_verif);
        oci_bind_by_name($stmt, ":photo", $photo_verif);
        oci_execute($stmt);
        //return new Utilisateur($nom, $pnom, $pseudo, $mdp, $adr, $email, $tel, $posix, $posiy, $photo, 0);
    }

    public static function get_by_pseudo($pseudo) {
        $pseudo_verif = stripslashes(htmlspecialchars($pseudo));
        $query = "SELECT * FROM Utilisateurs WHERE pseudoUti=:pseudo and desactive != 0";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur select by id utilisateur " . oci_error($conn));
        oci_bind_by_name($stmt, ":pseudo", $pseudo_verif);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        if ($row != null) {
            $id = $row['IDUTI'];
            $pseudo = $row['PSEUDOUTI'];
            $mdp = $row['MDPUTI'];
            $pnom = $row['PNOMUTI'];
            $nom = $row['NOMUTI'];
            $adr = $row['ADRUTI'];
            $email = $row['EMAILUTI'];
            $tel = $row['TELUTI'];
            $posix = $row['POSIGEOX'];
            $posiy = $row['POSIGEOY'];
            $photo = $row['PHOTOUTI'];
            $pt = $row['POINTTROC'];
            $o = new Utilisateur($id, $nom, $pnom, $pseudo, $mdp, $adr, $email, $tel, $posix, $posiy, $photo, $pt);
        } else {
            $o = null;
        }
        return $o;
    }

    public static function get_by_pseudo_mdp($pseudo, $mdp) {
        $pseudo_verif = stripslashes(htmlspecialchars($pseudo));
        $mdp_verif = sha1(stripslashes(htmlspecialchars($mdp)));
        $query = "SELECT * FROM Utilisateurs WHERE pseudoUti=:pseudo and mdpUti=:mdp and desactive != 0";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur select by id utilisateur " . oci_error($conn));
        oci_bind_by_name($stmt, ":pseudo", $pseudo_verif);
        oci_bind_by_name($stmt, ":mdp", $mdp_verif);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        if ($row != null) {
            $id = $row['IDUTI'];
            $pseudo = $row['PSEUDOUTI'];
            $mdp = $row['MDPUTI'];
            $pnom = $row['PNOMUTI'];
            $nom = $row['NOMUTI'];
            $adr = $row['ADRUTI'];
            $email = $row['EMAILUTI'];
            $tel = $row['TELUTI'];
            $posix = $row['POSIGEOX'];
            $posiy = $row['POSIGEOY'];
            $photo = $row['PHOTOUTI'];
            $pt = $row['POINTTROC'];
            $o = new Utilisateur($id, $nom, $pnom, $pseudo, $mdp, $adr, $email, $tel, $posix, $posiy, $photo, $pt);
        } else {
            $o = null;
        }
        return $o;
    }

    public static function get_by_id($id) {
        $o = null;
        if ((is_int($id)) || (is_numeric($id))) {
            $query = "SELECT * FROM Utilisateurs WHERE idUti=" . $id . " and desactive != 0";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur select by id utilisateur " . oci_error($conn));
            oci_execute($stmt);
            $row = oci_fetch_assoc($stmt);
            if ($row != null) {
                $id = $row['IDUTI'];
                $pseudo = $row['PSEUDOUTI'];
                $mdp = $row['MDPUTI'];
                $pnom = $row['PNOMUTI'];
                $nom = $row['NOMUTI'];
                $adr = $row['ADRUTI'];
                $email = $row['EMAILUTI'];
                $tel = $row['TELUTI'];
                $posix = $row['POSIGEOX'];
                $posiy = $row['POSIGEOY'];
                $photo = $row['PHOTOUTI'];
                $pt = $row['POINTTROC'];
                $o = new Utilisateur($id, $nom, $pnom, $pseudo, $mdp, $adr, $email, $tel, $posix, $posiy, $photo, $pt);
            }
        }
        return $o;
    }

    public static function verif_pseudo($pseudo) {
        $query = "select * from Utilisateurs where pseudoUti=:pseudo";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur select utilisateurs.pseudo " . oci_error($conn));
        oci_bind_by_name($stmt, ":pseudo", $pseudo);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);
        if ($row == null) {
            return true;
        } else {
            return false;
        }
    }

    //les getters
    public function id() {
        return $this->_id;
    }

    public function pseudo() {
        return $this->_pseudo;
    }

    public function mdp() {
        return $this->_mdp;
    }

    public function pt_troc() {
        return $this->_point_troc;
    }

    public function email() {
        return $this->_email;
    }

    public function adr() {
        return $this->_adr;
    }

    public function tel() {
        return $this->_tel;
    }

    public function nom() {
        return $this->_nom;
    }

    public function pnom() {
        return $this->_pnom;
    }

    public function pt() {
        return $this->_point_troc;
    }

    public function avatar() {
        return $this->_photo;
    }

    //les setters
    public function set_pseudo($c) {
        //verifier si le nouveau pseudo est pas déjà prit 
        if (Utilisateur::verif_pseudo($c) == true) {
            $this->_pseudo = stripslashes(htmlspecialchars($c));
            $query = "UPDATE Utilisateurs SET pseudoUti=:pseudo where idUti=:id";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur maj utilisateur.pseudo " . oci_error($conn));
            oci_bind_by_name($stmt, ":id", $this->_id);
            oci_bind_by_name($stmt, ":pseudo", $this->_pseudo);
            oci_execute($stmt);
            $_SESSION['pseudo'] = $this->_pseudo;
        } else {
            echo "<div class='warning'><p>Erreur, le pseudonyme saisie est déjà utilisé ...</p></div>";
        }
    }

    public function set_nom($c) {
        $this->_nom = stripslashes(htmlspecialchars($c));
        $query = "UPDATE Utilisateurs SET nomUti=:nom where idUti=:id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur maj utilisateur.nom " . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $this->_id);
        oci_bind_by_name($stmt, ":nom", $this->_nom);
        oci_execute($stmt);
    }

    public function set_mdp($mdp) {
        $this->_mdp = sha1(stripslashes(htmlspecialchars($mdp)));
        $query = "UPDATE Utilisateurs SET mdpUti=:mdp where idUti=:id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur maj utilisateur.nom " . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $this->_id);
        oci_bind_by_name($stmt, ":mdp", $this->_mdp);
        oci_execute($stmt);
        $_SESSION['mdp'] = $this->_mdp;
    }

    public function set_tel($tel) {
        $this->_tel = stripslashes(htmlspecialchars($tel));
        $query = "UPDATE Utilisateurs SET telUti=:tel where idUti=:id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur maj utilisateur.pnom " . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $this->_id);
        oci_bind_by_name($stmt, ":tel", $this->_tel);
        oci_execute($stmt);
    }

    public function set_email($email) {
        $this->_email = stripslashes(htmlspecialchars($email));
        $query = "UPDATE Utilisateurs SET emailUti=:email where idUti=:id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur maj utilisateur.pnom " . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $this->_id);
        oci_bind_by_name($stmt, ":email", $this->_email);
        oci_execute($stmt);
    }

    public function set_avatar($avatar) {
        $this->_photo = $avatar;
        $query = "UPDATE Utilisateurs SET photoUti=:photo where idUti=:id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur maj utilisateur.pnom " . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $this->_id);
        oci_bind_by_name($stmt, ":photo", $this->_photo);
        oci_execute($stmt);
    }

    public function set_adr($adr) {
        $this->_adr = stripslashes(htmlspecialchars($adr));
        $query = "UPDATE Utilisateurs SET adrUti=:adr where idUti=:id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur maj utilisateur.pnom " . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $this->_id);
        oci_bind_by_name($stmt, ":adr", $this->_adr);
        oci_execute($stmt);
    }

    public function set_pnom($c) {
        $this->_pnom = stripslashes(htmlspecialchars($c));
        $query = "UPDATE Utilisateurs SET pnomUti=:pnom where idUti=:id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur maj utilisateur.pnom " . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $this->_id);
        oci_bind_by_name($stmt, ":pnom", $this->_pnom);
        oci_execute($stmt);
    }

    public function ajout_pt($nb) {
        if (is_float(floatval($nb))) {
            $this->_point_troc = $this->_point_troc + $nb;
            $query = "UPDATE Utilisateurs SET pointTroc=:pt where idUti=:id";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur maj utilisateur.point troc " . oci_error($conn));
            oci_bind_by_name($stmt, ":id", $this->_id);
            oci_bind_by_name($stmt, ":pt", $this->_point_troc);
            oci_execute($stmt);
        } else {
            echo "<div class='warning'><p>Erreur, mauvaise saisie du nombre de point troc ...</p></div>";
        }
    }

    public function retire_pt($nb) {
        if (is_float($nb) == true) {
            $this->_point_troc = $this->_point_troc - $nb;
            if ($this->_point_troc < 0) {
                $this->_point_troc = 0;
            }
            $query = "UPDATE Utilisateurs SET pointTroc=:pt where idUti=:id";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur maj utilisateur.point troc " . oci_error($conn));
            oci_bind_by_name($stmt, ":id", $this->_id);
            oci_bind_by_name($stmt, ":pt", $this->_point_troc);
            oci_execute($stmt);
        } else {
            echo "<div class='warning'><p>Erreur, mauvaise saisie du nombre de point troc ...</p></div>";
        }
    }

}

?>