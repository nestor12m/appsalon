

let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []

}

console.log(cita)
document.addEventListener('DOMContentLoaded', function () {
    iniciarApp();
})

function iniciarApp() {
    tabs();//Cambia la session cuando presiono los tabs
    mostrarSeccion();//muestra y oculta las secciones
    botonesPaginador();//Agrega o quita botones del paginador
    paginaAnterior();
    paginaSiguiente();
    consultarAPI(); //Consulta la ai de PHP
    nombreCliente(); //Añade el nombre del cliente al objeto de cita
    idCliente(); //Añade el id del cliente al objeto de cita
    seleccionarFecha(); //Añade la fecha de la cita del cliente al objeto de cita
    seleccionarHora(); //Añade la hora de la cita del cliente al objeto de cita
    mostrarResumen(); // Muestra el resumen de la cita
}







// funcion numero 1
function tabs() {

    const botones = document.querySelectorAll('.tabs button');

    botones.forEach(function (boton) {
        boton.addEventListener('click', function (e) {
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();


        })
    })

}


function mostrarSeccion() {

    //Ocultar la session que tenga la clase de motrar
    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    //Seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');



    //Quita la clase del tab anterior pero resalta el actual
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    //Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');


}


// funcion de paginador, toca hacer  llamar l funcion en la funcion de tabs
function botonesPaginador() {
    const PaginaSiguiente = document.querySelector('#siguiente');
    const PaginaAnterior = document.querySelector('#anterior');

    if (paso === 1) {
        PaginaAnterior.classList.add('ocultar');
        PaginaSiguiente.classList.remove('ocultar');

    } else if (paso === 2) {
        PaginaAnterior.classList.remove('ocultar');
        PaginaSiguiente.classList.remove('ocultar');
    }
    else if (paso === 3) {
        PaginaAnterior.classList.remove('ocultar');
        PaginaSiguiente.classList.add('ocultar');
        //Para llamar la funcion mostar resumen cuando meuvo al psa 3 o doy siguente
        mostrarResumen();

    }

    mostrarSeccion();
}

//Funciones Paginadores
function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', () => {
        if (paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    })

}

function paginaSiguiente() {
    const PaginaSiguiente = document.querySelector('#siguiente');
    PaginaSiguiente.addEventListener('click', () => {
        if (paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
        console.log(paso)
    })
}


// ---------------------------------------------------------------------------------------
// ------------------------------API DE PHP----------------------------------------------
// ---------------------------------------------------------------------------------------

//Funcion para consultar la API
async function consultarAPI() {

    try {
        url = `${location.origin}/api/servicios`;
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    } catch (error) {
        console.log(error)
    }
}

//Funcion para mostrar el html
function mostrarServicios(servicios) {

    //iterar sobre los servicios

    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;

        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$ ${precio}`;

        ServicioDiv = document.createElement('DIV');
        ServicioDiv.classList.add('servicio');
        ServicioDiv.dataset.idServicio = id;

        ServicioDiv.addEventListener('click', () => {
            seleccionarServicios(servicio);
        })

        ServicioDiv.appendChild(nombreServicio);
        ServicioDiv.appendChild(precioServicio);


        const divHtml = document.querySelector('#servicios');
        divHtml.appendChild(ServicioDiv);




    })
}
function seleccionarServicios(servicio) {

    const { id } = servicio;
    //aplicando destructuring a los objetos
    const { servicios } = cita;


    //Identificar el elmento al que se da click
    const ServicioDiv = document.querySelector(`[data-id-servicio = "${id}"]`);
    //Comprobar si un servicio ya fue agregado para quitarlo
    if (servicios.some(agregado => agregado.id === servicio.id)) {
        //Eliminarlo
        cita.servicios = servicios.filter(agregado => agregado.id !== servicio.id);
        ServicioDiv.classList.remove('seleccionado');
    }
    else {
        //Agregarlo
        //toma una copia de los servicios y le agrega el nuevo servicio gracias al spred operator
        cita.servicios = [...servicios, servicio];
        ServicioDiv.classList.add('seleccionado');
    }

    //
    // console.log(cita);
}

function nombreCliente() {
    const nombre = document.querySelector('#nombre').value;
    cita.nombre = nombre;
    // console.log(cita);
}

function idCliente() {
    const id = document.querySelector('#id').value;
    cita.id = id;
}

function seleccionarFecha() {
    const inputfecha = document.querySelector('#fecha');
    inputfecha.addEventListener('input', (e) => {

        const dia = new Date(e.target.value).getUTCDay();

        if ([6, 0].includes(dia)) {
            e.target.value = '';
            // console.log("Es sabado y Domingo no abrimos");
            motrarAlerta('Los fines de semana no estamos disponibles', 'error', '#paso-2 p');
        } else {
            cita.fecha = e.target.value;
        }

        // console.log(dia);

        // console.log(cita);
    })
}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', (e) => {

        const horaCita = e.target.value;
        //separar la horad e los minutos
        const hora = horaCita.split(':')[0];

        if (hora < 9 || hora > 22) {
            e.target.value = '';
            motrarAlerta('Hora no valida', 'error', '#paso-2 p');
        } else {

            cita.hora = horaCita;
        }

        // console.log(cita);
    })
}


function motrarAlerta(mensaje, tipo, elemento, desaparece = true) {

    //Previene que se genere mas de una alerta
    const alertaPrevia = document.querySelector('.alertas');
    if (alertaPrevia) {
        alertaPrevia.remove();
    }

    // creando domm scriting
    const divAlerta = document.createElement('DIV');
    divAlerta.textContent = mensaje;
    divAlerta.classList.add('alertas');
    divAlerta.classList.add(tipo);

    const elementoHTML = document.querySelector(elemento);
    elementoHTML.appendChild(divAlerta);
    // console.log(elementoHTML);

    if (desaparece) {
        // Quitar la alerta despues de cierto tiempo
        setTimeout(() => {
            divAlerta.remove();
        }, 3000);
    }


}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    //Limpiar contenido Previo
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    //Para verfificar si todos los campos estan llenos
    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        // console.log("Hacenfalta datos");
        motrarAlerta('Hacen falta datos', 'error', '.contenido-resumen', false);
        return;
    }

    // Formatear el div de resumen
    const { nombre, fecha, hora, servicios } = cita; // aplicar destructotin al objeto

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre} `;

    //Fecha
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    const opciones = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }
    const fechaFormateada = fechaUTC.toLocaleDateString('es-CO', opciones);

    console.log(fechaFormateada);


    const fechaCliente = document.createElement('P');
    fechaCliente.innerHTML = `<span>Fecha:</span> ${fechaFormateada} `;


    const horaCliente = document.createElement('P');
    horaCliente.innerHTML = `<span>Hora:</span> ${hora} `;



    const tituloServicio = document.createElement('h3');
    tituloServicio.textContent = 'Resumen de servicios';
    resumen.appendChild(tituloServicio);

    servicios.forEach(servicio => {
        const { id, nombre, precio } = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $ ${precio} `;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);


        resumen.appendChild(contenedorServicio);
    })
    const tituloDatosCita = document.createElement('h3');
    tituloDatosCita.textContent = 'Resumen de Cita';
    resumen.appendChild(tituloDatosCita);

    //Reservar cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.addEventListener('click', () => {
        reservarCita();
    })


    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCliente);
    resumen.appendChild(horaCliente);
    resumen.appendChild(botonReservar);







}

async function reservarCita() {

    //Del objeto de cita
    const { nombre, id, fecha, hora, servicios } = cita;

    //extraer el id de los servicios con map
    // busca la columna id y lo guarda en una variable
    const idServicios = servicios.map(servicio => servicio.id);

    // console.log(idServicios);
    // return;

    //Enviar datos a la bd a travez de Fetch API
    const datos = new FormData();
    //Para agregar datos se  usa append
    // datos.append('nombre', nombre);
    datos.append('fecha', fecha);
    datos.append('hora', hora);
    datos.append('usuarioid', id);
    datos.append('servicios', idServicios);


    try {
        //Para mirar que estoy enviando en el formData
        // console.log([...datos]);

        //Peticion hacia la API 
        const url = `${location.origin}/api/citas`;

        const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
        });
        const resultado = await respuesta.json();

        // console.log(resultado)

        if (resultado) {
            Swal.fire({

                icon: 'success',
                title: 'Cita creada',
                text: 'Tu cita ha sido registrada correctamente',
                button: 'OK',
                // timer: 1500
            }).then(() => {
                window.location.reload();
            })
            // console.log("exito.....")
        }
    } catch (error) {
        Swal.fire({

            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al guardr la cita',
            button: 'OK',
            // timer: 1500
        }).then(() => {
            window.location.reload();
        })
        console.log(error)
    }
}