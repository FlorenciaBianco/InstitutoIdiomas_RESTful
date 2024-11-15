<?php
    require_once 'app/models/profesor.model.php';
    require_once 'app/models/deploy.model.php';
    require_once 'app/views/json.view.php';

    class ProfesorApiController {
        private $model;
        private $view;
        private $deployModel;
        
        public function __construct (){
            $this->model = new ProfesorModel();
            $this->view = new JSONView(); 
            $this->deployModel = new DeployModel();
        }
    
        public function deploy(){
            $this->deployModel->_deploy();       
            }

        public function create($req, $res){

            if (empty($req->body->nombre)) {
                return $this->view->response('Falta completar el nombre',  400);
            }
            if (empty($req->body->email)) {
                return $this->view->response('Falta completar el email',  400);
            }
            if (empty($req->body->telefono)) {
                return $this->view->response('Falta completar el telefono', 400);
            }
            if (empty($req->body->id_idioma)) {
                return $this->view->response('Falta completar la idioma', 400);
            }
                        
            $nombre = $req->body->nombre;
            $email = $req->body->email;
            $telefono= $req->body->telefono;
            $id_idioma = $req->body->id_idioma;

            // if($_FILES['imput_name']['type'] == "image/jpg" || $_FILES['imput_name']['type'] == "image/jpeg" || $_FILES['imput_name']['type'] == "image/png"){ 
            //    $id = $this->model->insert($nombre, $telefono, $email, $id_idioma, $_FILES['imput_name']);
            // } else {
                $id = $this->model->insert($nombre, $telefono, $email, $id_idioma);
            // }

            if (!$id) {
                return $this->view->response("Error al insertar profesor", 500);
            }
            
            $profesor = $this->model->getById($id);
            return $this->view->response($profesor, 201);
        
        }
        public function add(){
            if($_SERVER['REQUEST_METHOD']=='GET'){
                $indiceIdiomas = $this->getLanguageIndex();
                return $this->view->showAddForm(null, $indiceIdiomas);
            }

            if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
                return $this->view->showError('Falta completar el nombre');
            }
        
            if (!isset($_POST['email']) || empty($_POST['email'])) {
                return $this->view->showError('Falta completar el email');
            }
            if (!isset($_POST['telefono']) || empty($_POST['telefono'])) {
                return $this->view->showError('Falta completar el telefono');
            }
            if (!isset($_POST['idioma']) || empty($_POST['idioma'])) {
                return $this->view->showError('Falta completar la idioma');
            }
            
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $telefono= $_POST['telefono'];
            $id_idioma = $_POST['idioma'];
            
            if($_FILES['imput_name']['type'] == "image/jpg" || $_FILES['imput_name']['type'] == "image/jpeg" || $_FILES['imput_name']['type'] == "image/png"){ 
                $id = $this->model->insert($nombre, $telefono, $email, $id_idioma, $_FILES['imput_name']);

            } else {
                $id = $this->model->insert($nombre, $telefono, $email, $id_idioma);
            }
            header('Location: ' . BASE_URL."profesores");
        }

        public function getAll($req, $res) {
            $orderBy = false;
            if(isset($req->query->orderBy))
                $orderBy = $req->query->orderBy;
        
            $profesores = $this->model->getAll($orderBy);
                
            return $this->view->response($profesores);
            
        }

        public function get($req, $res) {
            $id = $req->params->id;
    
            $profesor = $this->model->getById($id);
    
            if(!$profesor) {
                return $this->view->response("El profesor con el id=$id no existe", 404);
            }
    
            return $this->view->response($profesor);
        }
    


        private function getLanguageIndex(){
            $idiomas = $this->idiomaModel->getAll();
            $indiceIdiomas = array();
            foreach ($idiomas as $idioma) {
                $indiceIdiomas[$idioma->id_idioma] = $idioma->nombre;
            }
            return $indiceIdiomas;
        }

        public function show($id){
            $profesor = $this->model->getById($id);
            return $this->view->show($profesor, $this->getLanguageIndex());
        }

        public function showByIdioma($id){
            $profesores = $this->model->getByIdioma($id);
            return $this->view->showByIdioma($profesores, $this->getLanguageIndex());
        }

        public function delete($id) {
    
            if (!$profesor) {
                return $this->view->showError("No existe el profesor con el id = $id");
            }

            $this->model->delete($id);
    
            header('Location: ' . BASE_URL."profesores");
        }
    
        public function update($req, $res) {
            $id = $req->params->id;
            $profesor = $this->model->getById($id);
            
            if (!$profesor) {
                return $this->view->response("El profesor con el id=$id no existe", 404);
            }
    
            if (empty($req->body->nombre) || empty($req->body->email) || empty($req->body->telefono) || empty($req->body->idioma)) {
                return $this->view->response('Faltan completar datos', 400);
            }
    
            $nombre = $req->body->nombre;       
            $email = $req->body->email;
            $telefono= $req->body->telefono;
            $id_idioma = $req->body->idioma;
    
            if($_FILES['imput_name']['type'] == "image/jpg" || $_FILES['imput_name']['type'] == "image/jpeg" || $_FILES['imput_name']['type'] == "image/png"){ 
                $id = $this->model->update($id,$nombre, $telefono, $email, $id_idioma, $_FILES['imput_name']);

            } else {
                $id = $this->model->update($id,$nombre, $telefono, $email, $id_idioma);
            }
         
            $profesor = $this->model->getById($id);
            $this->view->response($profesor, 200);
        }
    
        public function update($id) {
    
            if (!$id) {
                return $this->view->showError("No existe el profesor con el id = $id");
            }
            if($_SERVER['REQUEST_METHOD']=='GET'){
                $profesor = $this->model->getById($id);
                return $this->view->showUpdateForm($profesor,$this->getLanguageIndex());
            }

            if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
                return $this->view->showError('Falta completar el nombre');
            }
        
            if (!isset($_POST['email']) || empty($_POST['email'])) {
                return $this->view->showError('Falta completar el email');
            }
            if (!isset($_POST['telefono']) || empty($_POST['telefono'])) {
                return $this->view->showError('Falta completar el telefono');
            }
            if (!isset($_POST['idioma']) || empty($_POST['idioma'])) {
                return $this->view->showError('Falta completar la idioma');
            }
            
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $telefono= $_POST['telefono'];
            $id_idioma = $_POST['idioma'];
        
            if($_FILES['imput_name']['type'] == "image/jpg" || $_FILES['imput_name']['type'] == "image/jpeg" || $_FILES['imput_name']['type'] == "image/png"){ 
                $id = $this->model->update($id,$nombre, $telefono, $email, $id_idioma, $_FILES['imput_name']);

            } else {
                $id = $this->model->update($id,$nombre, $telefono, $email, $id_idioma);
            }
    
            header('Location: ' . BASE_URL ."profesores");
        }
     












    }