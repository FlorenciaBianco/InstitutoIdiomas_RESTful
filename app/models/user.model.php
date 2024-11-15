<?php

require_once 'config.php';
require_once 'app/models/deploy.model.php';

    class UserModel {
        private $db;
        
        public function __construct() {
            $this->db = new PDO("mysql:host=".MYSQL_HOST .";dbname=".MYSQL_DB.";charset=utf8", MYSQL_USER, MYSQL_PASS);
        }

        public function getUserByEmail($email) {
            $query = $this->db->prepare("SELECT * FROM usuario WHERE email = ?");
            $query->execute([$email]);
            return $query->fetch(PDO::FETCH_OBJ);
        }

}
