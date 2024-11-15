<?php
require_once 'config.php';
require_once 'app/models/deploy.model.php';
class IdiomaModel{

    private $db;

    public function __construct(){ 
        $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);
    }
    
    public function getAll($orderBy){    
        $sql = 'SELECT * FROM idioma';
        if($orderBy) {
            switch($orderBy) {
                case 'nombre':
                    $sql .= ' ORDER BY nombre asc';
                    break;
                case 'modulos':
                    $sql .= ' ORDER BY modulos asc';
                    break;
            }
        }
        $query = $this->db->prepare($sql);
        $query->execute();

        $idiomas = $query->fetchAll(PDO::FETCH_OBJ); 

        return $idiomas;  
    }
   
    public function getById($id) {
        $query = $this->db->prepare('SELECT * FROM idioma WHERE id_idioma = ?');
        $query->execute([$id]);

        $idioma = $query->fetch(PDO::FETCH_OBJ);

        return $idioma;
    }

    public function insert($nombre, $descripcion, $modulos, $imagen = null){
        $pathImg = null;
        if ($imagen){
            
            $pathImg = $this->uploadImage($imagen);
        }
        $query = $this->db->prepare('INSERT INTO idioma (nombre, descripcion, modulos, imagen) VALUES(?,?,?,?)');
        $query->execute([$nombre, $descripcion, $modulos, $pathImg]);

        $id = $this->db->lastInsertId();
    
        return $id;
    }
    
    public function delete($id){
        $query = $this->db->prepare ('DELETE FROM idioma WHERE id_idioma = ?');
        $query->execute([$id]); 
    }

    public function update($id, $nombre, $descripcion, $modulos, $image = null){
        if(empty($image)){
            $query = $this->db->prepare('UPDATE idioma SET nombre = ?, descripcion = ?, modulos = ? WHERE id_idioma = ?');
            $query->execute([$nombre, $descripcion, $modulos, $id]);
        } else{
            $pathImg = $this->uploadImage($image);
            $query = $this->db->prepare('UPDATE idioma SET nombre = ?, descripcion = ?, modulos = ?, imagen = ? WHERE id_idioma = ?');
            $query->execute([$nombre, $descripcion, $modulos, $pathImg, $id]);
        }

    }

    private function uploadImage($image){
        $target = "docs/img/" . uniqid("", true) . "." . strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $success =move_uploaded_file($image['tmp_name'], $target);
       
        return $target;
    }

 
}



