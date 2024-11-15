<?php

session_start();
    $_SESSION['NombredeUsuario'] = 'webadmin';
    $_SESSION['id'] = 'admin';
    $_SESSION['Rol'] = 'ADMIN';

    echo "Autenticado";