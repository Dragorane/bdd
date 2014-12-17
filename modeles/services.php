<?php

require_once 'modeles/model_base.php';

class services extends Model_Base {

    private $_id;
    private $_lib;
    private $_desc;
    private $_prix;
    private $_nbPlaces;
    private $_vendu;
    private $_iduti;
    private $_idcateg;

    public function __construct($id, $lib, $desc, $prix, $nbplaces, $vendu, $iduti, $categ) {
        $this->_id = $id;
        $this->_lib = $lib;
        $this->_desc = $desc;
        $this->_prix = $prix;
        $this->_nbplaces = $nbplaces;
        $this->_vendu = $vendu;
        $this->_iduti = $iduti;
        $this->_idcateg = $categ;
    }

    public function get_id() {
        return $this->_id;
    }

    public function get_titre() {
        return $this->_lib;
    }

    public function get_desc() {
        return $this->_desc;
    }

    public function get_prix() {
        return $this->_prix;
    }

    public function get_places() {
        return $this->_nbPlaces;
    }

    public function get_iduti() {
        return $this->_iduti;
    }

    public function get_categ() {
        return $this->_idcateg;
    }

    public static function create($lib, $desc, $prix, $nbplaces, $iduti, $categ) {
        if ((is_numeric($iduti)) && (is_numeric($categ)) && (is_numeric($nbplaces)) && (is_float(floatval($prix)))) {
            $query = "INSERT INTO services VALUES (Services_seq.nextval,:lib_v,:desc_v,:prix_v,:nblaces_v,1,:iduti_v,:categ_v)";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion service" . oci_error($conn));
            //formatage des variables et sécurité
            $lib_verif = stripslashes(htmlspecialchars($lib));
            $desc_verif = stripslashes(htmlspecialchars($desc));
            $nbplaces_verif = stripslashes(htmlspecialchars($nbplaces));
            oci_bind_by_name($stmt, ":lib_v", $lib_verif);
            oci_bind_by_name($stmt, ":desc_v", $desc_verif);
            oci_bind_by_name($stmt, ":prix_v", $prix);
            oci_bind_by_name($stmt, ":nblaces_v", $nbplaces);
            oci_bind_by_name($stmt, ":iduti_v", $iduti);
            oci_bind_by_name($stmt, ":categ_v", $categ);
            oci_execute($stmt);
        } else {
            echo "<div class='warning'><p>Erreur, données corrompues.</p></div>";
        }
    }

    public static function get_tabserv_by_uti($pseudo) {
        $uti = Utilisateur::get_by_pseudo($pseudo);
        $tabserv = null;
        if ($uti != NULL) {
            $query = "select idServ, libServ, descServ, prixServ, nbplaces, venduServ, idUti, idCat from Services where venduServ=1 and idUti=" . $uti->id();
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur select serv" . oci_error($conn));
            oci_execute($stmt);
            $i = 0;
            while ($row = oci_fetch_assoc($stmt)) {
                $tabserv[$i] = new services($row['IDSERV'], $row['LIBSERV'], $row['DESCSERV'], $row['PRIXSERV'], $row['NBPLACES'], $row['VENDUSERV'], $row['IDUTI'], $row['IDCAT']);
                $i = $i + 1;
            }
            return $tabserv;
        }
    }

    public static function get_serv_by_id($id) {
        $serv = null;
        if ((is_int($id)) || (is_numeric($id))) {
            $query = "select idServ, libServ, descServ, prixServ, nbplaces, venduServ, idUti, idCat from Services where venduServ=1 and idServ=" . $id;
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion service" . oci_error($conn));
            oci_execute($stmt);
            $row = oci_fetch_assoc($stmt);
            $serv = new services($row['IDSERV'], $row['LIBSERV'], $row['DESCSERV'], $row['PRIXSERV'], $row['NBPLACES'], $row['VENDUSERV'], $row['IDUTI'], $row['IDCAT']);
        }
        return $serv;
    }

    public static function tabservices() {
        $query = "select idServ, libServ, descServ, prixServ, nbplaces, venduServ, idUti, idCat from Services where venduServ=1";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
        oci_execute($stmt);
        $i = 0;
        $tabserv = null;
        while ($row = oci_fetch_assoc($stmt)) {
            $tabserv[$i] = new services($row['IDSERV'], $row['LIBSERV'], $row['DESCSERV'], $row['PRIXSERV'], $row['NBPLACES'], $row['VENDUSERV'], $row['IDUTI'], $row['IDCAT']);
            $i = $i + 1;
        }
        return $tabserv;
    }

    public static function tabservices_prix() {
        $tabserv = null;
        $query = "select idServ, libServ, descServ, prixServ, nbplaces, venduServ, idUti, idCat from Services where venduServ=1 order by prix";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
        oci_execute($stmt);
        $i = 0;
        while ($row = oci_fetch_assoc($stmt)) {
            $tabserv[$i] = new services($row['IDSERV'], $row['LIBSERV'], $row['DESCSERV'], $row['PRIXSERV'], $row['NBPLACES'], $row['VENDUSERV'], $row['IDUTI'], $row['IDCAT']);
            $i = $i + 1;
        }
        return $tabserv;
    }

    public static function tabservices_prixdesc() {
        $tabserv = null;
        $query = "select idServ, libServ, descServ, prixServ, nbplaces, venduServ, idUti, idCat from Services where venduServ=1 order by prixServ DESC";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
        oci_execute($stmt);
        $i = 0;
        while ($row = oci_fetch_assoc($stmt)) {
            $tabserv[$i] = new services($row['IDSERV'], $row['LIBSERV'], $row['DESCSERV'], $row['PRIXSERV'], $row['NBPLACES'], $row['VENDUSERV'], $row['IDUTI'], $row['IDCAT']);
            $i = $i + 1;
        }
        return $tabserv;
    }

    public static function tabservices_cat($cat) {
        $tabserv = null;
        if (is_int($cat)) {
            $query = "select idServ, libServ, descServ, prixServ, nbplaces, venduServ, idUti, idCat from Services where venduServ=1  and idCat=" . $cat;
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
            oci_execute($stmt);
            $i = 0;
            while ($row = oci_fetch_assoc($stmt)) {
                $tabserv[$i] = new services($row['IDSERV'], $row['LIBSERV'], $row['DESCSERV'], $row['PRIXSERV'], $row['NBPLACES'], $row['VENDUSERV'], $row['IDUTI'], $row['IDCAT']);
                $i = $i + 1;
            }
        }
        return $tabserv;
    }

    public static function tabservices_prixdesc_cat($cat) {
        $tabserv = null;
        if (is_int($cat)) {
            $query = "select idServ, libServ, descServ, prixServ, nbplaces, venduServ, idUti, idCat from Services where venduServ=1 and idCat=" . $cat . " order by prix DESC";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
            oci_execute($stmt);
            $i = 0;
            while ($row = oci_fetch_assoc($stmt)) {
                $tabserv[$i] = new services($row['IDSERV'], $row['LIBSERV'], $row['DESCSERV'], $row['PRIXSERV'], $row['NBPLACES'], $row['VENDUSERV'], $row['IDUTI'], $row['IDCAT']);
                $i = $i + 1;
            }
        }
        return $tabserv;
    }

    public static function tabservices_prix_cat($cat) {
        $tabserv = null;
        if (is_int($cat)) {
            $query = "select idServ, libServ, descServ, prixServ, nbplaces, venduServ, idUti, idCat from Services where venduServ=1 and idCat=" . $cat . " order by prix";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
            oci_execute($stmt);
            $i = 0;
            while ($row = oci_fetch_assoc($stmt)) {
                $tabserv[$i] = new services($row['IDSERV'], $row['LIBSERV'], $row['DESCSERV'], $row['PRIXSERV'], $row['NBPLACES'], $row['VENDUSERV'], $row['IDUTI'], $row['IDCAT']);
                $i = $i + 1;
            }
        }
        return $tabserv;
    }

    public static function tabservices_eval_cat($cat) {
        $tabserv = null;
        return $tabserv;
    }

    public static function tabservices_eval() {
        $tabserv = null;
        return $tabserv;
    }

    public static function tabservices_geoloc_cat($cat) {
        $tabserv = null;
        return $tabserv;
    }

    public static function tabservices_geoloc() {
        $tabserv = null;
        return $tabserv;
    }

}

?>