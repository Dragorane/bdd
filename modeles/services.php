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

    public static function create($lib, $desc, $prix, $nbplaces, $iduti, $categ) {
        if ((is_numeric($iduti)) && (is_numeric($categ)) && (is_numeric($nbplaces)) && (is_float(floatval($prix)))) {
            $query = "INSERT INTO services VALUES (Services_seq.nextval,:lib,:desc,:prix,:nblaces,1,:iduti,:categ)";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion service" . oci_error($conn));
            //formatage des variables et sécurité
            $lib_verif = stripslashes(htmlspecialchars($lib));
            $desc_verif = stripslashes(htmlspecialchars($desc));
            $nbplaces_verif = stripslashes(htmlspecialchars($nbplaces));
            $vendu_verif = stripslashes(htmlspecialchars($vendu));
            oci_bind_by_name($stmt, ":lib", $lib_verif);
            oci_bind_by_name($stmt, ":desc", $desc_verif);
            oci_bind_by_name($stmt, ":prix", $prix);
            oci_bind_by_name($stmt, ":nblaces", $nbplaces);
            oci_bind_by_name($stmt, ":iduti", $iduti);
            oci_bind_by_name($stmt, ":categ", $categ);
            oci_execute($stmt);
        } else {
            echo "<div class='warning'><p>Erreur, données corrompues.</p></div>";
        }
    }

    public static function get_tabsev_by_uti($pseudo) {
        $uti = Utilisateur::get_by_pseudo($pseudo);
        $tabserv = null;
        if ($uti != NULL) {
            $query = "select idServ, libServ, descServ, prixServ, nbplaces, venduServ, idUti, idCat from Services where venduServ=0 and idUti=" . $uti->id();
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

}

?>