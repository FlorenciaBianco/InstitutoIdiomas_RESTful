<?php

require_once 'libs/router.php';
require_once 'app/controllers/profesor.api.controller.php';
require_once 'app/controllers/idioma.api.controller.php';

$router = new Router();
$router->addRoute('profesores'      ,        'GET',     'ProfesorApiController',      'getAll');
$router->addRoute('idiomas'      ,           'GET',     'IdiomaApiController',        'getAll');
$router->addRoute('profesor/:id'  ,          'GET',     'ProfesorApiController',      'get'   );
$router->addRoute('idioma/:id'  ,            'GET',     'IdiomaApiController',        'get'   );
$router->addRoute('profesores'  ,            'POST',    'ProfesorApiController',      'create');
$router->addRoute('idiomas'  ,               'POST',    'IdiomaApiController',        'create');
$router->addRoute('profesor/:id'  ,          'PUT',     'ProfesorApiController',      'update');
$router->addRoute('idioma/:id'  ,            'PUT',     'IdiomaApiController',        'update');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);







