# InstitutoIdiomas
Instituto de Idiomas Pagina Web
Integrantes: Biondi, Mateo ; Bianco, Florencia.

Este trabajo aborda el desarrollo de una pagina web que consiste en una Escuela de Idiomas donde los usuarios pueden acceder a clases virtuales. 
Nuestro modelo de datos establece una relacion 1 a N entre las tablas Idioma y Profesor. 
Establecimos para nuestro sitio que un idioma puede ser enseñado por distintos profesores y que cada profesor puede enseñar un solo idioma.
La clave forànea corresponde al atributo id_idioma de la tabla Profesor.
La clave primaria corresponde al atributo primario autoincremental id_idioma de la tabla Idioma. 

![image](docs/img/erd.png)

## TPE - Parte 2

Acceso Publico:
El sitio web cuenta con una barra de navegacion que el usuario puede recorrer de manera libre, accediendo a la lista de categorias (correspondiente a los Idiomas) y lista de Items (correspondiente a los Profesores).
Desde el home del sitio puede accederce a los items por categoria y los detalles de cada uno de ellos.

Acceso Administrador de Datos:
Designamos como administrador del sitio web un usuario administrador el cual debe loguearse con los siguientes datos a traves del boton disponible en la barra de navegacion:
```
Email: webadmin@web2.com
Password: admin
```
Unicamente el usuario administrador puede modificar, agregar y eliminar items o categorias.

La administacion de items y categorias del sitio web puede realizarse a traves de los botones disponibles y acceso a traves de URL semantica:

Administracion de Items:
/profesores -> Lista de Items 
/agregar/profesor -> Agregar Item 
/eliminar/profesor/id -> Eliminar Item 
/Modificar/profesor/id -> Modificar Item

Administracion de Categorias:
/idiomas -> Lista de Categorias
/agregar/idioma -> Agregar Categoria 
/eliminar/idioma/id -> Eliminar Categoria 
/Modificar/idioma/id -> Modificar Categoria

Al disponer de una entidad relacion de 1 - N seleccionamos como mecanismo de administracion de datos, el efecto cascada de la categoria al item, es decir, al eliminarse una categoria (idioma) determinamos que no tiene sentido conservar los items (profesores) de la misma.

## TPE - Parte 3

La API Restful Instituto Idiomas cuenta con una lista de servicios correspondientes a Idiomas y Profesores.

Se desarrollan la siguiente lista de endpoints:

Host: http://localhost/WEB2/TPE_Restful/api/

### Listar Idiomas
Method: GET         Endpoint: /idiomas 

Respuesta:

Body    Status Code: 200(OK)

Nos devuelve la coleccion entera de idiomas 

### Listar Profesores
Method: GET         Endpoint: /profesores 

Respuesta:

Body    Status Code: 200(OK)

Nos devuelve la coleccion entera de profesores

### Ordenamientos
Ambos Servicios de Listado pueden ordenarse de acuerdo a criterios:

### Idiomas
En el caso de Idiomas en forma ascendente o descendente de acuerdo a su Nombre y Cantidad de Modulos que cuenta.

Ejemplo:    
Method: GET         Endpoint: /idiomas?orderBy=nombre 

Respuesta:

Body    Status Code: 200(OK)

Nos devuelve la coleccion de Idiomas ordenada alfabeticamente por nombre.

Ejemplo:    
Method: GET         Endpoint: /idiomas?orderBy=-nombre 

Respuesta:

Body    Status Code: 200(OK)

Nos devuelve la coleccion de Idiomas ordenada de forma alfabetica descendente por nombre.

Otro criterio a utilizar corresponde a la cantidad de modulos. Este servicio nos devuelve la coleccion de Idiomas ordenados por numero de modulos, respectivamente ascendente o descendente.

Ejemplo:   

Method: GET         Endpoint: /idiomas?orderBy=modulos

Method: GET         Endpoint: /idiomas?orderBy=-modulos 

### Profesores
En el caso de Profesores en forma ascendente o descendente de acuerdo a su Nombre e Idioma que dicta.

Ejemplo:    
Method: GET         Endpoint: /profesores?orderBy=nombre 

Respuesta:

Body    Status Code: 200(OK)

Nos devuelve la coleccion de Profesores ordenada alfabeticamente por nombre

Ejemplo:    
Method: GET         Endpoint: /profesores?orderBy=-nombre 

Respuesta:

Body    Status Code: 200(OK)

Nos devuelve la coleccion de Profesores ordenada de forma alfabetica descendente por nombre

Otro criterio a utilizar corresponde al Idioma que dicta. Este servicio nos devuelve la coleccion de Profesores ordenados por Idioma, respectivamente ascendente o descendente.

Ejemplo:    
Method: GET         Endpoint: /profesores?orderBy=idioma

Method: GET         Endpoint: /profesores?orderBy=-idioma 

### Obtener Idioma por su ID
Method: GET         Endpoint: /idiomas/:id 

Nos devuelve en caso de existir, el Idioma con sus detalles.

Ejemplo: 
Method: GET        Endpoint: /idiomas/1

Respuesta:

Body    Status Code: 200(OK)

```
{
    "id_idioma": 1,
    "nombre": "Ingles",
    "descripcion": "Lengua de origen Europeo",
    "modulos": 4
}
```

### Obtener Profesor por su ID
Method: GET         Endpoint: /profesores/:id 

Nos devuelve en caso de existir, el Profesor con sus detalles.

Ejemplo: 
Method: GET        Endpoint: /profesores/1

Respuesta:

Body    Status Code: 200(OK)

```
{ 
    "id": 1,
    "nombre": "Matias",
    "telefono": 15336756,
    "email": "matias@idiomas.com",
    "id_idioma": 1
}
```

### Agregar Idioma
Method: POST         Endpoint: /idioma 

Completamos en estructura raw JSON, todos los campos correspondientes:

```
{
    "nombre": "IdiomaNuevo",
    "descripcion": "Agregamos un nuevo Idioma",
    "modulos": 2
}
```

Respuesta:

Body    Status Code: 201(Created)

```
{
    "id_idioma": 6, --> Asigna un id al nuevo idioma, un numero autoincremental ascendente 
    "nombre": "IdiomaNuevo",
    "descripcion": "Agregamos un nuevo Idioma",
    "modulos": 2
}
```

### Agregar Profesor
Method: POST         Endpoint: /profesor 

Completamos en estructura raw JSON, todos los campos correspondientes:

```
{
    "nombre": "ProfesorNuevo",
    "telefono": 15644521,
    "email": "profesornuevo@idiomas.com",
    "id_idioma": 3
}
```

Respuesta:

Body    Status Code: 201(Created)

```
{
    "id": 27,
    "nombre": "ProfesorNuevo",
    "telefono": 15644521,
    "email": "profesornuevo@idiomas.com",
    "id_idioma": 3
}
```

## Modificar Idioma
Method: PUT         Endpoint: /idioma/:id 

Completamos en estructura raw JSON, todos los campos correspondientes, actualizando los campos necesarios:

Ejemplo:

Method: PUT         Endpoint: /idioma/1 

Actualizamos los campos a modificar 

```
{
    "nombre": "Ingles",
    "descripcion": "Lengua de origen Europeo",
    "modulos": 4
}
```

Respuesta:

Body    Status Code: 200(OK)

```
{
    "id_idioma": 1,
    "nombre": "Ingles",
    "descripcion": "Lengua de origen Europeo",
    "modulos": 5
}
```

## Modificar Profesor
Method: PUT         Endpoint: /profesor/:id 

Completamos en estructura raw JSON, todos los campos correspondientes, actualizando los campos necesarios:

Ejemplo:

Method: PUT         Endpoint: /profesor/2 

Actualizamos los campos a modificar 

```
{
    "nombre": "Carolina",
    "telefono": 15654321,
    "email": "carolina@idiomas.com",
    "id_idioma": 55
 
}
```

Respuesta:

Body    Status Code: 200(OK)

```
{
    "id": 2,
    "nombre": "Carolina",
    "telefono": 15646721,
    "email": "carolinaIdioma@idiomas.com",
    "id_idioma": 55,

}
```

## Eliminar Idioma
Method: DELETE         Endpoint: /idiomas/:id 

Elimina si existe, el Idioma por su id.

Ejemplo:

Method: DELETE        Endpoint: /idiomas/1

Respuesta:

Status Code: 204(No Content)

## Eliminar Profesor
Method: DELETE         Endpoint: /profesores/:id 

Elimina si existe, el profesor por su id.

Ejemplo:

Method: DELETE        Endpoint: /profesores/2

Respuesta:

Status Code: 204(No Content)












