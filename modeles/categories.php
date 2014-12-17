<?php

require_once 'modeles/model_base.php';

class categories extends Model_Base {

    private $_id;
    private $_lib;
    private $_type;
    private $_cat_pere;

    public function getlib() {
        return $this->_lib;
    }

    public function __construct($id, $lib, $type, $cat_pere) {
        $this->_id = $id;
        $this->_lib = $lib;
        $this->_type = $type;
        $this->_cat_pere = $cat_pere;
    }

    public static function create($lib, $type, $cat_pere) {
        $query = "INSERT INTO Categorie VALUES (Categorie_seq.nextval,:lib,:type,:catpere)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
        //formatage des variables et sécurité
        $lib_verif = stripslashes(htmlspecialchars($lib));
        $type_verif = stripslashes(htmlspecialchars($type));
        $cat_pere_verif = stripslashes(htmlspecialchars($cat_pere));
        oci_bind_by_name($stmt, ":lib", $lib_verif);
        oci_bind_by_name($stmt, ":type", $type_verif);
        oci_bind_by_name($stmt, ":catpere", $cat_pere_verif);
        oci_execute($stmt);
    }

    public static function list_categ($type) {
        $query = "select idCat, libCat, typeCat, cat_pere from categorie where typeCat=" . $type . " order by idCat,cat_pere DESC";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
        oci_execute($stmt);
        $i = 0;
        $tabcat = null;
        while ($row = oci_fetch_assoc($stmt)) {
            $tabcat[$i][0] = $row['CAT_PERE'];
            $tabcat[$i][1] = $row['IDCAT'];
            $tabcat[$i][2] = $row['LIBCAT'];
            $i = $i + 1;
        }
        return $tabcat;
    }

    public static function recupCat($id) {
        $cat = null;
        if (is_numeric($id)) {
            $query = "select * from Categorie where idCat=:id";
            $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion categrie" . oci_error($conn));
            //formatage des variables et sécurité
            oci_bind_by_name($stmt, ":id", $id_verif);
            oci_execute($stmt);
            $row = oci_fetch_assoc($stmt);
            echo "<p>" . $row['IDCAT'] . $row['LIBCAT'] . $row['TYPE'] . $row['CAT_PERE'] . "</p>";
            $cat = new categories($row['IDCAT'], $row['LIBCAT'], $row['TYPE'], $row['CAT_PERE']);
        } else {
            echo "<div class='warning'><p>Erreur, la catégorie a été mal séléctionnée...</p></div>";
        }
        return $cat;
    }

    public static function initcat() {
        categories::create("Livres BD", 1, null);
        categories::create("BD, humour et jeunesse", 1, 10);
        categories::create("Culture & société", 1, 10);
        categories::create("Littérature & fiction", 1, 10);
        categories::create("Vie pratique & loisirs", 1, 10);
        categories::create("Scolaire & universitaire", 1, 10);
        categories::create("Enceintes", 1, 10);
        categories::create("Mémoires / RAM", 1, 10);
        categories::create("Musique CD", 1, null);
        categories::create("CD", 1, 18);
        categories::create("Instruments de musique", 1, 18);
        categories::create("Vinyles", 1, 18);
        categories::create("Partitions et paroles", 1, 18);
    }

}

?>