
const btnGuardarservicio = document.querySelector('#Guardarservicio');
const formulario = document.querySelector('.formulario');



addEventListener();

function addEventListener() {
    formulario.addEventListener('submit', leerFormulario);



}


function leerFormulario(event) {
    event.preventDefault();
    console.log("presionaste");

    //Leer los datos de los inputs
    const nombre = document.querySelector('#nombre').value
    const precio = document.querySelector('#precio').value
    // console.log(nombreform);

    if (nombre === '') {
        mostrarNotificacion("El campo nombre no debe ir vacio", 'noterror');
    } else if (precio === '') {
        mostrarNotificacion("El campo precio no debe ir vacio", 'noterror');
    } else {
        guardarFetch(nombre, precio);
    }





}




function mostrarNotificacion(msj, clase) {
    const notificacion = document.createElement('DIV');
    notificacion.classList.add('notificacion', clase, 'sombra');
    notificacion.textContent = msj;

    //Formulario
    formulario.insertBefore(notificacion, document.querySelector('cont form '));
    // foreach(notificacion){


    //Ocultar y mostrar notificaicion

    setTimeout(() => {
        notificacion.classList.add('visible');

        setTimeout(() => {
            notificacion.classList.remove('visible');
            setTimeout(() => {
                notificacion.remove();
            }, 500);
        }, 3000);

    }, 50);
}


async function guardarFetch(nombre, precio) {

    const datosFormulario = new FormData();
    datosFormulario.append('nombre', nombre);
    datosFormulario.append('precio', precio);

    console.log(...datosFormulario)

    try {
        const url = `${location.origin}/servicios/guardar`;

        const respuesta = await fetch(url, {
            method: 'POST',
            body: datosFormulario
        });
        const resultado = await respuesta.json();
        console.log(resultado);

        if (resultado.resultado == true) {
            mostrarNotificacion("El Servicio Fue Agregado con Exito", 'notexito');
            console.log("agregado......")
            formulario.reset();
            // window.location = "/servicios"

        }


    } catch (error) {
        console.log(error);
    }
}

