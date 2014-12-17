<?php

require_once 'modeles/model_base.php';

class biens extends Model_Base {

    private $_id;
    private $_lib;
    private $_desc;
    private $_prix;
    private $_vendu;
    private $_iduti;
    private $_idcateg;
    private $_idetat;

    public function __construct($id, $lib, $desc, $prix, $vendu, $iduti, $categ, $etat) {
        $this->_id = $id;
        $this->_lib = $lib;
        $this->_desc = $desc;
        $this->_prix = $prix;
        $this->_vendu = $vendu;
        $this->_iduti = $iduti;
        $this->_idcateg = $categ;
        $this->_idetat = $etat;
    }

    public static function create($lib, $desc, $prix, $iduti, $categ, $etat) {
        if ((is_numeric($iduti)) && (is_numeric($categ)) && (is_numeric($etat)) && (is_float(floatval($prix)))) {
            $query = "INSERT INTO Biens VALUES (Biens_seq.nextval,:lib_v,:desc_v,:prix_v,0,:iduti_v,:etat_v,:categ_v)";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion bien" . oci_error($conn));
//formatage des variables et sécurité
            $lib_verif = stripslashes(htmlspecialchars($lib));
            $desc_verif = stripslashes(htmlspecialchars($desc));
            oci_bind_by_name($stmt, ":lib_v", $lib_verif);
            oci_bind_by_name($stmt, ":desc_v", $desc_verif);
            oci_bind_by_name($stmt, ":prix_v", $prix);
            oci_bind_by_name($stmt, ":iduti_v", $iduti);
            oci_bind_by_name($stmt, ":etat_v", $etat);
            oci_bind_by_name($stmt, ":categ_v", $categ);
            oci_execute($stmt);
        } else {
            echo "<div class='warning'><p>Erreur, données corrompues.</p></div>";
        }
    }

    public function get_titre() {
        return $this->_lib;
    }

    public function get_desc() {
        return $this->_desc;
    }

    public function get_id() {
        return $this->_id;
    }

    public function get_prix() {
        return $this->_prix;
    }

    public function get_uti() {
        return $this->_iduti;
    }

    public function get_categ() {
        return $this->_idcateg;
    }

    public function get_etat() {
        return $this->_etat;
    }

    public function get_vendu() {
        return $this->_vendu;
    }

    public function bien_vendu() {
        
    }

    public static function get_tabbien_by_uti($pseudo) {
        $uti = Utilisateur::get_by_pseudo($pseudo);
        $tabbien = null;
        if ($uti != NULL) {
            $query = "select idBien, libBien, descBien, prixBiens, venduBien, idUti, idEtat, idCat from Biens where venduBien=0 and idUti=" . $uti->id();
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
            oci_execute($stmt);
            $i = 0;
            while ($row = oci_fetch_assoc($stmt)) {
                $tabbien[$i] = new biens($row['IDBIEN'], $row['LIBBIEN'], $row['DESCBIEN'], $row['PRIXBIENS'], $row['VENDUBIEN'], $row['IDUTI'], $row['IDCAT'], $row['IDETAT']);
                $i = $i + 1;
            }
            return $tabbien;
        }
    }

    public static function get_bien_by_id($id) {
        $bien = null;
        if ((is_int($id)) || (is_numeric($id))) {
            $query = "select idBien, libBien, descBien, prixBiens, venduBien, idUti, idEtat, idCat from Biens where venduBien=0 and idBien=" . $id;
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
            oci_execute($stmt);
            $row = oci_fetch_assoc($stmt);
            $bien = new biens($row['IDBIEN'], $row['LIBBIEN'], $row['DESCBIEN'], $row['PRIXBIENS'], $row['VENDUBIEN'], $row['IDUTI'], $row['IDCAT'], $row['IDETAT']);
        }
        return $bien;
    }

    public static function tabbiens() {
        $query = "select idBien, libBien, descBien, prixBiens, venduBien, idUti, idEtat, idCat from Biens where venduBien=0";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
        oci_execute($stmt);
        $i = 0;
        $tabbien = null;
        while ($row = oci_fetch_assoc($stmt)) {
            $tabbien[$i] = new biens($row['IDBIEN'], $row['LIBBIEN'], $row['DESCBIEN'], $row['PRIXBIENS'], $row['VENDUBIEN'], $row['IDUTI'], $row['IDCAT'], $row['IDETAT']);
            $i = $i + 1;
        }
        return $tabbien;
    }

    public static function tabbiens_prix() {
        $tabbien = null;
        $query = "select idBien, libBien, descBien, prixBiens, venduBien, idUti, idEtat, idCat from Biens where venduBien=0 order by prix";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
        oci_execute($stmt);
        $i = 0;
        while ($row = oci_fetch_assoc($stmt)) {
            $tabbien[$i] = new biens($row['IDBIEN'], $row['LIBBIEN'], $row['DESCBIEN'], $row['PRIXBIENS'], $row['VENDUBIEN'], $row['IDUTI'], $row['IDCAT'], $row['IDETAT']);
            $i = $i + 1;
        }
    }

    public static function tabbiens_prixdesc() {
        $tabbien = null;
        $query = "select idBien, libBien, descBien, prixBiens, venduBien, idUti, idEtat, idCat from Biens where venduBien=0 order by prix DESC";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
        oci_execute($stmt);
        $i = 0;
        while ($row = oci_fetch_assoc($stmt)) {
            $tabbien[$i] = new biens($row['IDBIEN'], $row['LIBBIEN'], $row['DESCBIEN'], $row['PRIXBIENS'], $row['VENDUBIEN'], $row['IDUTI'], $row['IDCAT'], $row['IDETAT']);
            $i = $i + 1;
        }
    }

    public static function tabbiens_cat($cat) {
        $tabbien = null;
        if (is_int($cat)) {
            $query = "select idBien, libBien, descBien, prixBiens, venduBien, idUti, idEtat, idCat from Biens where venduBien=0 and idCat=" . $cat;
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
            oci_execute($stmt);
            $i = 0;
            while ($row = oci_fetch_assoc($stmt)) {
                $tabbien[$i] = new biens($row['IDBIEN'], $row['LIBBIEN'], $row['DESCBIEN'], $row['PRIXBIENS'], $row['VENDUBIEN'], $row['IDUTI'], $row['IDCAT'], $row['IDETAT']);
                $i = $i + 1;
            }
        }
        return $tabbien;
    }

    public static function tabbiens_prixdesc_cat($cat) {
        $tabbien = null;
        if (is_int($cat)) {
            $query = "select idBien, libBien, descBien, prixBiens, venduBien, idUti, idEtat, idCat from Biens where venduBien=0 and idCat=" . $cat . " order by prix DESC";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
            oci_execute($stmt);
            $i = 0;
            while ($row = oci_fetch_assoc($stmt)) {
                $tabbien[$i] = new biens($row['IDBIEN'], $row['LIBBIEN'], $row['DESCBIEN'], $row['PRIXBIENS'], $row['VENDUBIEN'], $row['IDUTI'], $row['IDCAT'], $row['IDETAT']);
                $i = $i + 1;
            }
        }
        return $tabbien;
    }

    public static function tabbiens_prix_cat($cat) {
        $tabbien = null;
        if (is_int($cat)) {
            $query = "select idBien, libBien, descBien, prixBiens, venduBien, idUti, idEtat, idCat from Biens where venduBien=0 and idCat=" . $cat . " order by prix";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
            oci_execute($stmt);
            $i = 0;
            while ($row = oci_fetch_assoc($stmt)) {
                $tabbien[$i] = new biens($row['IDBIEN'], $row['LIBBIEN'], $row['DESCBIEN'], $row['PRIXBIENS'], $row['VENDUBIEN'], $row['IDUTI'], $row['IDCAT'], $row['IDETAT']);
                $i = $i + 1;
            }
        }
        return $tabbien;
    }

    public static function tabbiens_eval_cat($cat) {
        $tabbien = null;
        return $tabbien;
    }

    public static function tabbiens_eval() {
        $tabbien = null;
        return $tabbien;
    }

    public static function tabbiens_geoloc_cat($cat) {
        $tabbien = null;
        return $tabbien;
    }

    public static function tabbiens_geoloc() {
        $tabbien = null;
        return $tabbien;
    }

}

?>