<?php

require_once 'modeles/model_base.php';

class photos extends Model_Base {

    private $_idPhoto;
    private $_pathPhoto;
    private $_idBien;

    public function __construct($id, $path, $idbien) {
        $this->_idPhoto = $id;
        $this->_pathPhoto = $path;
        $this->_idBien = $idbien;
    }

    public static function create($path, $idbien) {
        $query = "INSERT INTO Photo VALUES (Photo_seq.nextval,:path,:idbien)";
        $stmt = @oci_parse(Model_Base::$_db, $query) or die("erreur insertion photo" . oci_error($conn));
        //formatage des variables et sécurité
        $path_verif = stripslashes(htmlspecialchars($path));
        $idbien_verif = stripslashes(htmlspecialchars($idbien));
        oci_bind_by_name($stmt, ":path", $path_verif);
        oci_bind_by_name($stmt, ":idbien", $idbien_verif);
        oci_execute($stmt);
    }

}

?>