<?php
    require_once 'app/models/profesor.model.php';
    require_once 'app/models/idioma.model.php';
    require_once 'app/models/deploy.model.php';
    require_once 'app/views/json.view.php';

    class ProfesorApiController {
        private $model;
        private $view;
        private $deployModel;
        
        public function __construct (){
            $this->model = new ProfesorModel();
            $this->idiomaModel = new IdiomaModel();
            $this->view = new JSONView(); 
            $this->deployModel = new DeployModel();
        }
    
        public function deploy(){
            $this->deployModel->_deploy();       
            }

        public function getAll($req, $res) {
            $orderBy = false;
              
            if(isset($req->query->orderBy)){
                $orderBy = $req->query->orderBy;
            }
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

        public function create($req, $res){

            if (empty($req->body->nombre)) {
                return $this->view->response('Falta completar el nombre del profesor',  400);
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
            $idioma = $this->idiomaModel->getById($id_idioma);
            
            if (!$idioma) {
                return $this->view->response("El idioma con el id=$id_idioma no existe", 404);
            }
            else {
                $id = $this->model->insert($nombre, $telefono, $email, $id_idioma);
            }

            if (!$id) {
                return $this->view->response("Error al crear profesor", 500);
            }
            
            $profesor = $this->model->getById($id);
            return $this->view->response($profesor, 201);
        }
        
        public function update($req, $res) {
            $id = $req->params->id;
            $profesor = $this->model->getById($id);

            if (!$profesor) {
                return $this->view->response("El profesor con el id=$id no existe", 404);
            }

            if (empty($req->body->nombre) || empty($req->body->email) || empty($req->body->telefono) || empty($req->body->id_idioma)) {
                return $this->view->response('Faltan completar datos', 400);
            }
    
            $nombre = $req->body->nombre;       
            $email = $req->body->email;
            $telefono= $req->body->telefono;
            $id_idioma = $req->body->id_idioma;
            $idioma = $this->idiomaModel->getById($id_idioma);
            
            if (!$idioma) {
                return $this->view->response("El idioma con el id=$id_idioma no existe", 404);
            }
  
            $update = $this->model->update($id,$nombre, $telefono, $email, $id_idioma);
            if(!$update){
                return $this->view->response('Error al actualizar el profesor', 400);
            }
            $profesor = $this->model->getById($id);
            $this->view->response($profesor, 200);
        }

        public function delete($req, $res) {
            $id = $req->params->id;
            $profesor = $this->model->getById($id);
            
            if (!$profesor) {
                return $this->view->response("El profesor con el id=$id no existe", 404);
            }

            $delete = $this->model->delete($id);
    
            if(!$delete){
                return $this->view->response('Error al borrar el profesor', 400);
            }
           
            return $this->view->response(" ", 204);
        }
    
    }