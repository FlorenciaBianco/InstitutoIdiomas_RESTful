<?php
require_once 'config.php';

    class DeployModel {
        protected $db;

        public function __construct() {
            $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);
            $this->_deploy();
        }
        private function _deploy() {
            $query = $this->db->query('SHOW TABLES');
            $tables = $query->fetchAll();
            if(count($tables) == 0) {
                $sql = <<<END
                CREATE TABLE Idioma (
                    id_idioma INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(40) NOT NULL,
                    descripcion VARCHAR(50) NOT NULL,
                    modulos INT NOT NULL,
                    imagen VARCHAR (250)
                );
                CREATE TABLE Profesor (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(40) NOT NULL,
                    telefono INT NOT NULL,
                    email VARCHAR(50) NOT NULL,
                    id_idioma INT,
                    imagen VARCHAR (250),
                    FOREIGN KEY (id_idioma) REFERENCES idioma(id_idioma)
                );
                CREATE TABLE usuario (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR (40) NOT NULL,
                    email VARCHAR(50) NOT NULL,
                    password VARCHAR (50) NOT NULL
                );
                END;
            
            $this->db->exec($sql);
        }
    }
}