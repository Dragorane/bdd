
<?php

require_once 'modeles/model_base.php';

/**
 * 
 */
class Object extends Model_Base {

    private $_id;
    private $_nom;
    private $_descriptif;
    private $_valeur;

    public function __construct($id, $nom, $desc, $val) {
        $this->_id = $id;
        $this->_nom = $nom;
        $this->_descriptif = $desc;
        $this->_valeur = $val;
    }

    // Setter et Getter

    public function id() {
        return $this->_id;
    }

    public function set_id($id) {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function nom() {
        return $this->_nom;
    }

    public function set_nom($c) {
        $this->_nom = $c;
    }

    public function descriptif() {
        return $this->_descriptif;
    }

    public function set_descriptif($c) {
        $this->_descriptif = $c;
    }

    public function valeur() {
        return $this->_valeur;
    }

    public function set_valeur($val) {
        $val = (int) $val;
        if ($val > 0) {
            $this->_valeur = $val;
        }
    }

    public static function create($nom, $desc, $val) {
        $query = "INSERT INTO object VALUES (1,:nom,:descriptif,:valeur)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion " . oci_error($conn));
        oci_bind_by_name($stmt, ":nom", $nom);
        oci_bind_by_name($stmt, ":descriptif", $desc);
        oci_bind_by_name($stmt, ":valeur", $val);

        oci_execute($stmt);

        return new Object(1, $nom, $desc, $val);
    }

    public static function get_by_id($id) {
        $query = "SELECT * FROM object WHERE id=:id";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion " . oci_error($conn));
        oci_bind_by_name($stmt, ":id", $id);
        oci_execute($stmt);
        $row = oci_fetch_assoc($stmt);

        if ($row != null) {
            $id = $row['ID'];
            $nom = $row['NOM'];
            $desc = $row['DESCRIPTIF'];
            $val = $row['VALEUR'];
            $o = new Object($id, $nom, $desc, $val);
        } else {
            $o = null;
        }

        return $o;
    }

    public static function get_all() {
        $query = "SELECT * FROM object";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion " . oci_error($conn));
        oci_execute($stmt);

        $array_obj = array();

        while ($row = oci_fetch_assoc($stmt)) {
            $id = $row['ID'];
            $nom = $row['NOM'];
            $desc = $row['DESCRIPTIF'];
            $val = $row['VALEUR'];
            $array_obj[] = new Object($id, $nom, $desc, $val);
        }

        return $array_obj;
    }

}

?>