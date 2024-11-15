<?php
    require_once 'app/models/idioma.model.php';
    require_once 'app/models/deploy.model.php';
    require_once 'app/views/json.view.php';

    class IdiomaApiController {
        private $model;
        private $view;
        private $deployModel;

        public function __construct (){
            $this->model = new IdiomaModel();
            $this->view = new JSONView(); 
            $this->deployModel = new DeployModel();
        }
    
        public function deploy(){
            $this->deployModel->_deploy();       
        
        }

        public function getAll($req, $res) {
            $orderBy = false;
            if(isset($req->query->orderBy))
                $orderBy = $req->query->orderBy;
        
            
            $idiomas = $this->model->getAll($orderBy);
            return $this->view->response($idiomas);
        }
       
        public function get($req, $res) {
            $id = $req->params->id;
    
            $idioma = $this->model->getById($id);
    
            if(!$idioma) {
                return $this->view->response("El idioma con el id=$id no existe", 404);
            }
    
            return $this->view->response($idioma);
        }
    
        public function showCategoria($nombre){
            $profesores = $this->model->getById($nombre);
            return $this->view->show($profesor);
        }
        
        public function create($req, $res){
            
            if (empty($req->body->nombre)) {
                return $this->view->response('Falta completar el nombre del idioma', 400);
            }
            if (empty($req->body->descripcion)) {
                return $this->view->response('Falta completar la descripcion', 400);
            }
            if (empty($req->body->modulos)) {
                return $this->view->response('Falta completar el modulos', 400);
            }

            $nombre = $req->body->nombre;
            $descripcion = $req->body->descripcion;
            $modulos= $req->body->modulos;

            // if($_FILES['input_name']['type'] == "image/jpg" || $_FILES['input_name']['type'] == "image/jpeg" || $_FILES['input_name']['type'] == "image/png"){ 
            //     $id = $this->model->insert($nombre, $descripcion, $modulos, $_FILES['input_name']);
            // } else {
                $id = $this->model->insert($nombre, $descripcion, $modulos);
            // }

            if (!$id) {
                return $this->view->response("Error al insertar idioma", 500);
            }
            
            $idioma = $this->model->getById($id);
            return $this->view->response($idioma, 201);
        }

        public function add(){
            if ($_SERVER['REQUEST_METHOD']=='GET'){
                return $this->view->showAddForm();
            }
            if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
                return $this->view->showError('Falta completar el nombre del idioma');
            }
            if (!isset($_POST['descripcion']) || empty($_POST['descripcion'])) {
                return $this->view->showError('Falta completar la descripcion');
            }
            if (!isset($_POST['modulos']) || empty($_POST['modulos'])) {
                return $this->view->showError('Falta completar el modulos');
            }

            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $modulos= $_POST['modulos'];

            if($_FILES['input_name']['type'] == "image/jpg" || $_FILES['input_name']['type'] == "image/jpeg" || $_FILES['input_name']['type'] == "image/png"){ 
                $id = $this->model->insert($nombre, $descripcion, $modulos, $_FILES['input_name']);
            } else {
                $id = $this->model->insert($nombre, $descripcion, $modulos);
            }
            header('Location: ' . BASE_URL."idiomas");
        }

        public function delete($id) {
            $idioma = $this->model->getById($id);
   
           if (!$id) {
               return $this->view->showError("No existe el idioma con el id_idioma=$id");
           }

           $this->model->delete($id);
   
           header('Location: ' . BASE_URL."idiomas");
        }

        public function update($req, $res) {
            $id = $req->params->id;
            $idioma = $this->model->getById($id);
        
            if (!$idioma) {
                return $this->view->response("El idioma con el id=$id no existe", 404);
            }

            if (empty($req->body->nombre) || empty($req->body->descripcion) || empty($req->body->modulos)) {
                return $this->view->response('Faltan completar datos', 400);
            }

            $nombre = $req->body->nombre;       
            $descripcion =  $req->body->descripcion;
            $modulos=  $req->body->modulos;

            if($_FILES['input_name']['type'] == "image/jpg" || $_FILES['input_name']['type'] == "image/jpeg" || $_FILES['input_name']['type'] == "image/png"){ 
                $id = $this->model->update($id, $nombre, $descripcion, $modulos, $_FILES['input_name']);
            } else {
                $id = $this->model->update($id, $nombre, $descripcion, $modulos);
            }

            $idioma = $this->model->getById($id);
            $this->view->response($idioma, 200);

        }

        public function update($id) {
            if (!$id) {
                return $this->view->showError("No existe el idioma con el id_idioma=$id");
            }
            if ($_SERVER['REQUEST_METHOD']=='GET'){
                $idioma = $this->model->getById($id);
                return $this->view->showUpdateForm($idioma);
            }
            if (!isset($_POST['nombre']) || empty($_POST['nombre'])) {
                return $this->view->showError('Falta completar el nombre del idioma');
            }

            if (!isset($_POST['descripcion']) || empty($_POST['descripcion'])) {
                return $this->view->showError('Falta completar la descripcion');
            }

            if (!isset($_POST['modulos']) || empty($_POST['modulos'])) {
                return $this->view->showError('Falta completar el modulos');
            }
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $modulos= $_POST['modulos'];

            if($_FILES['input_name']['type'] == "image/jpg" || $_FILES['input_name']['type'] == "image/jpeg" || $_FILES['input_name']['type'] == "image/png"){ 
                $id = $this->model->update($id, $nombre, $descripcion, $modulos, $_FILES['input_name']);
            } else {
                $id = $this->model->update($id, $nombre, $descripcion, $modulos);
            }

            header('Location: ' . BASE_URL."idiomas");
            
        }

        public function showHome(){
            $idiomas = $this->model->getAll();
            return $this->view->showHome($idiomas);
        }
     
    }
    