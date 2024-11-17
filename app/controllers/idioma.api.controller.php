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

            if(isset($req->query->orderBy)){
                $orderBy = $req->query->orderBy;
            }
        
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

            $id = $this->model->insert($nombre, $descripcion, $modulos);
            
            if (!$id) {
                return $this->view->response("Error al crear idioma", 500);
            }
            
            $idioma = $this->model->getById($id);
            return $this->view->response($idioma, 201);
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

            $update = $this->model->update($id, $nombre, $descripcion, $modulos);
            
            if(!$update){
                return $this->view->response('No se pudo actualizar el idioma', 400);
            }
            $idioma = $this->model->getById($id);
            $this->view->response($idioma, 200);

        }

        public function delete($req, $res) {
            $id = $req->params->id;
            $idioma = $this->model->getById($id);
   
            if(!$idioma) {
               return $this->view->showError("El idioma con el id_idioma=$id no existe", 404);
            }

            $delete = $this->model->delete($id);
   
            if(!$delete){
                return $this->view->response('Error al borrar el idioma', 400);
            }
          
            return $this->view->response(" ", 204);
        }
        
    }
    