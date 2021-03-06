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
            oci_bind_by_name($stmt, ":id", $id);
            oci_execute($stmt);
            $row = oci_fetch_assoc($stmt);
            $cat = new categories($row['IDCAT'], $row['LIBCAT'], $row['TYPECAT'], $row['CAT_PERE']);
        } else {
            echo "<div class='warning'><p>Erreur, la catégorie a été mal séléctionnée...</p></div>";
        }
        return $cat;
    }

    public static function initcat() {
        categories::create("Informatique Logiciels", 1, null);
        categories::create("PC fixe", 1, 2);
        categories::create("PC portable", 1, 2);
        categories::create("Ecrans", 1, 2);
        categories::create("Claviers", 1, 2);
        categories::create("Souris", 1, 2);
        categories::create("Enceintes", 1, 2);
        categories::create("Memoires / RAM", 1, 2);
        categories::create("Livres BD", 1, null);
        categories::create("BD, humour et jeunesse", 1, 10);
        categories::create("Culture & societe", 1, 10);
        categories::create("Litterature & fiction", 1, 10);
        categories::create("Vie pratique & loisirs", 1, 10);
        categories::create("Scolaire & universitaire", 1, 10);
        categories::create("Musique CD", 1, null);
        categories::create("CD", 1, 16);
        categories::create("Instruments de musique", 1, 16);
        categories::create("Vinyles", 1, 16);
        categories::create("Partitions et paroles", 1, 16);
        categories::create("Aide a domicile", 2, null);
        categories::create("Femme de menage - Technicien de surface", 2, 21);
        categories::create("Aide soignante - Infirmier(e) a domicile", 2, 21);
        categories::create("Nourrice", 2, 21);
        categories::create("Gardiennage de maison", 2, 21);
        categories::create("Garde d'animaux", 2, 21);
        categories::create("Techniciens", 2, null);
        categories::create("Electriciens", 2, 27);
        categories::create("Plombiers", 2, 27);
        categories::create("Couvreurs", 2, 27);
        categories::create("Petits boulots", 2, null);
    }

}

?>