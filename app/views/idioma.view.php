<?php

class IdiomaView {
    
    private $user = null;
    
    public function __construct($user){ 
            $this->user = $user;
    }

    public function showList($idiomas) {
        
        require_once 'templates/lista_idiomas.phtml';  
    }

    public function showAddForm($idioma = null){
        
        require_once 'templates/form_alta_idiomas.phtml';  
    }

    public function showUpdateForm($idioma){
        require_once 'templates/form_alta_idiomas.phtml';  
    }

    public function showError($error) {
        echo $error;
    }
    public function showHome($idiomas){
        require_once 'templates/home.phtml';
    }


}