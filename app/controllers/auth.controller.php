<?php
require_once 'app/models/user.model.php';
require_once 'app/models/deploy.model.php';
require_once 'app/views/auth.view.php';

class AuthController {
    private $model;
    private $view;
    private $deployModel;

    public function __construct() {
        $this->model = new UserModel();
        $this->view = new AuthView();
        $this->deployModel = new DeployModel();
    }
    
    public function deploy(){
        $this->deployModel->_deploy();       
    }
    
    public function showLogin($res) {
        if($res->user) {
            header('Location: ' . BASE_URL . 'home');
            return;
        }
        return $this->view->showLogin();
    }

    public function login() {
        if (!isset($_POST['email']) || empty($_POST['email'])) {
            return $this->view->showLogin('Falta completar el nombre de usuario');
        }
    
        if (!isset($_POST['password']) || empty($_POST['password'])) {
          return $this->view->showLogin('Falta completar la contraseña');
        }
    
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        $userFromDB = $this->model->getUserByEmail($email);

        if($userFromDB && password_verify($password, $userFromDB->password)){
            session_start();
            $_SESSION['ID_USER'] = $userFromDB->id;
            $_SESSION['EMAIL_USER'] = $userFromDB->email;
    
            header('Location: ' . BASE_URL."home");
        } else {
            return $this->view->showLogin('Credenciales incorrectas');
        }
    }

    public function logout() {
        session_start(); 
        session_destroy(); 
        header('Location: ' . BASE_URL."home");
    }
}

