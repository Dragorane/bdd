<?php

require_once 'modeles/model_base.php';

class Etat extends Model_Base {

    private $_id;
    private $_lib;

    public function __construct($id, $lib) {
        $this->_id = $id;
        $this->_lib = $lib;
    }

    public static function create($lib) {
        $query = "INSERT INTO Etat VALUES (Etat_seq.nextval,:lib)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
        $lib_verif = stripslashes(htmlspecialchars($lib));
        oci_bind_by_name($stmt, ":lib", $lib_verif);
        oci_execute($stmt);
    }

    public function get_id() {
        return $this->_id;
    }

    public function get_lib() {
        return $this->_lib;
    }

    public static function init() {
        Etat::create("Neuf");
        Etat::create("Bon état");
        Etat::create("Abimé");
    }

    public static function lesEtats() {
        $tab = null;
        $query = "SELECT idEtat, libEtat from Etat order by idEtat";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
        oci_execute($stmt);
        $i = 0;
        while ($row = oci_fetch_assoc($stmt)) {
            $tab[$i] = new Etat($row['IDETAT'], $row['LIBETAT']);
            $i = $i + 1;
        }
        return $tab;
    }

}

?>