"use strict"

const BASE_URL = "api/"; // url relativa a donde estoy parado (http://localhost/web2/2024/todo-list-rest/api)

// arreglo de profesores
let profesores = [];


async function getAll() {
    try {
        const response = await fetch(BASE_URL + "profesores");
        if (!response.ok) {
            throw new Error('Error al llamar los profesores');
        }

        profesores = await response.json();
       /// showTasks();
    } catch(error) {
        console.log(error)
    }
}
