<?php
require_once 'config.php';
require_once 'app/models/deploy.model.php';

class ProfesorModel {
    private $db;

    public function __construct (){
        $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);
    }
    
    public function getAll($orderBy) {
        $sql = 'SELECT * FROM profesor';
        if($orderBy) {
            switch($orderBy) {
                case 'nombre':
                    $sql .= ' ORDER BY nombre asc';
                    break;
                case '-nombre':
                    $sql .= ' ORDER BY nombre desc';
                    break;
                case 'idioma':
                    $sql .= ' ORDER BY id_idioma asc';
                    break;
                case '-idioma':
                    $sql .= ' ORDER BY id_idioma desc';
                    break;
            }
        }
        $query = $this->db->prepare($sql);
        $query->execute();

        $profesores = $query->fetchAll(PDO::FETCH_OBJ); 

        return $profesores;  
    }

    public function getById ($id) {
        $query = $this->db->prepare('SELECT * FROM profesor WHERE id = ?');
        $query->execute([$id]);
    
        $profesor = $query->fetch(PDO::FETCH_OBJ);
    
        return $profesor;
    }
    
    public function insert ($nombre, $telefono, $email, $id_idioma, $imagen = null){
        $pathImg = null;
        
        if ($imagen){
            $pathImg = $this->uploadImage($imagen);
        }
        $query = $this->db->prepare('INSERT INTO profesor (nombre, telefono, email, id_idioma, imagen) VALUES (?,?,?,?,?)');
        $query->execute([$nombre, $telefono, $email, $id_idioma, $pathImg]);

        $id = $this->db->lastInsertId();
    
        return $id;
    }

    public function update($id, $nombre, $telefono, $email, $id_idioma, $image = null){    
            $query = $this->db->prepare('UPDATE profesor SET nombre = ?, telefono = ?, email = ?, id_idioma = ? WHERE id = ?');
            return $query->execute([$nombre, $telefono, $email, $id_idioma, $id]);
    }

    public function delete ($id) {
        $query = $this->db->prepare ('DELETE FROM profesor WHERE id = ?');
        return $query->execute([$id]); 
    }

}