document.addEventListener("DOMContentLoaded", function() {
    const faqItems = document.querySelectorAll(".faq-item");

    faqItems.forEach(item => {
        const question = item.querySelector(".faq-question");
        const answer = item.querySelector(".faq-answer");
        const toggle = item.querySelector(".faq-toggle i");

        question.addEventListener("click", () => {
            const isVisible = answer.style.display === "block";
            answer.style.display = isVisible ? "none" : "block";
            toggle.className = isVisible ? "fa-solid fa-plus" : "fa-solid fa-minus";
        });
    });
});

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const menubarContent = document.getElementById('menubar-content');
    const contentPage = document.querySelector('.content-page');
    const settings = document.getElementById('settings-profile');

    menubarContent.classList.toggle('hidden');
    sidebar.classList.toggle('collapsed')
    contentPage.classList.toggle('expands');
    settings.classList.remove('hiddenS');
}

function refreshIndex() {
    document.getElementById('logo-image').addEventListener('click', ()=> {
        location.href='/Digital_Solutions/';
    })
}

function cambiarFormulario() {
    const formRegister = document.getElementById('form-register');
    const formLoggin = document.getElementById('form-loggin');

    formRegister.classList.toggle('active');
    formLoggin.classList.toggle('active');
}


// BARRA DE NAVEGACION
let lastScrollTop = 0;
const navbar = document.getElementById('hero');
const delta = 5; // Valor mínimo de desplazamiento para mostrar/ocultar la barra de navegación

window.addEventListener('scroll', function() {
    let scrollTop = window.scrollY;

    if (Math.abs(lastScrollTop - scrollTop) <= delta)
        return;

    if (scrollTop > lastScrollTop && scrollTop > navbar.clientHeight) {
        navbar.style.top = `-${navbar.clientHeight}px`; // Oculta la barra de navegación
    } else {
        navbar.style.top = '0'; // Muestra la barra de navegación
    }

    lastScrollTop = scrollTop;
});


document.addEventListener('DOMContentLoaded', (event) => {

    document.addEventListener('click', (event) => {
        if (sidebar.classList.contains('collapsed')) {
            if (!sidebar.contains(event.target)) {
                toggleSidebar();
            }
        }
    });

    sidebar.addEventListener('click', (event) => {
        event.stopPropagation();
    });
});





// Carrusel team
let currentIndex = 0;
const items = document.querySelectorAll('.team-carrusel .team-item');
const totalItems = items.length;

const nextButton = document.querySelector('.team-next');
const prevButton = document.querySelector('.team-prev');
const dots = document.querySelectorAll('.team-dot');

if (nextButton) {
    nextButton.addEventListener('click', () => {
        moveToNext();
    });
}

if (prevButton) {
    prevButton.addEventListener('click', () => {
        moveToPrev();
    });
}

function updateCarrusel() {
    const carruselItems = document.querySelector('.team-carrusel-items');
    if (carruselItems) {
        carruselItems.style.transform = `translateX(-${currentIndex * 100}%)`;
        updateDots();
    }
}

function moveToNext() {
    currentIndex = (currentIndex + 1) % totalItems;
    updateCarrusel();
}

function moveToPrev() {
    currentIndex = (currentIndex - 1 + totalItems) % totalItems;
    updateCarrusel();
}

if (dots.length) {
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentIndex = index;
            updateCarrusel();
        });
    });
}

function updateDots() {
    if (dots.length) {
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentIndex);
        });
    }
}

if (totalItems > 0) {
    updateCarrusel();
}





// // FUNCION PARA LOS FORMULARIOS CON AJAX
// $(document).ready(function() {
//     $('.formAjax').submit(function(e) {
//         e.preventDefault();

//         var form = $(this);
//         var tipo = form.attr('data-form');
//         var accion = form.attr('action');
//         var metodo = form.attr('method');
//         var respuesta = form.find('.RespuestaAjax');

//         var msjError = "<script>Swal.fire('Ocurrió un error inesperado','Por favor recargue la página','error');</script>";
//         var formdata = new FormData(this);

//         var textoAlerta;
//         if (tipo === "save") {
//             textoAlerta = "Los datos que enviaras quedaran almacenados en el sistema";
//         } else if (tipo === "delete") {
//             textoAlerta = "Los datos serán eliminados completamente del sistema";
//         } else if (tipo === "update") {
//             textoAlerta = "Los datos del sistema serán actualizados";
//         } else {
//             textoAlerta = "Quieres realizar la operación solicitada";
//         }

//         Swal.fire({
//             title: "¿Estás seguro?",
//             text: textoAlerta,
//             icon: "question",
//             showCancelButton: true,
//             confirmButtonText: "Aceptar",
//             cancelButtonText: "Cancelar"
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 $.ajax({
//                     type: metodo,
//                     url: accion,
//                     data: formdata,
//                     cache: false,
//                     contentType: false,
//                     processData: false,
//                     xhr: function() {
//                         var xhr = new window.XMLHttpRequest();
//                         xhr.upload.addEventListener("progress", function(evt) {
//                             if (evt.lengthComputable) {
//                                 var percentComplete = evt.loaded / evt.total;
//                                 percentComplete = parseInt(percentComplete * 100);
//                                 if (percentComplete < 100) {
//                                     respuesta.html('<p class="text-center">Procesado... (' + percentComplete + '%)</p><div><div style="width: ' + percentComplete + '%;"></div></div>');
//                                 } else {
//                                     respuesta.html('<p ></p>');
//                                 }
//                             }
//                         }, false);
//                         return xhr;
//                     },
//                     success: function(data) {
//                         respuesta.html(data);
//                     },
//                     error: function() {
//                         respuesta.html(msjError);
//                     }
//                 });
//                 return false;
//             }
//         });
//     });
// });


// MOSTRAR MENU DE OPCIONES Y AJUSTES DE LOS PERFILES
function showSettings() {
    const settings = document.getElementById('settings-profile');
    settings.classList.toggle('hiddenS');
}



// BOTONES CRUD
// function showOptions(rowId) {
//     // const fAT = document.getElementById('formAjax'+rowId);
//     // fAT.style.position = 'relative';
//     const bAT = document.getElementById('buttonsActionsTables'+rowId);
//     bAT.style.display = (bAT.style.display === 'none') ? 'flex' : 'none';
//     bAT.style.gap = '.8em';
//     bAT.style.transition = 'display 1s';
// }


// // SETEAR ACCION DEL CRUD
// function setAction(action) {
//     document.getElementById('action').value = action;
// }



// FORMULARIO AGREGAR ORGANIZACION
async function mostrarFormulario() {
    const { value: formValues } = await Swal.fire({
        title: "Agregar Organización",
        html: `
            <form id="form-sweetalert" autocomplete="off" enctype="multipart/form-data">
                <input id="nom-org" class="swal2-input" placeholder="Nombre de la organización">
                <input id="num-org" class="swal2-input" placeholder="Número">
                <input id="dir-org" class="swal2-input" placeholder="Dirección">
                <textarea id="desc-org" class="swal2-textarea" placeholder="Descripción"></textarea>
                <input type="file" id="img-org" class="swal2-file">
            </form>
        `,
        focusConfirm: false,
        preConfirm: () => {
            return new Promise((resolve) => {
                resolve({
                    nombre: document.getElementById('nom-org').value,
                    numero: document.getElementById('num-org').value,
                    direccion: document.getElementById('dir-org').value,
                    descripcion: document.getElementById('desc-org').value,
                    imagen: document.getElementById('img-org').files[0]
                });
            });
        }
    });

    if (formValues) {
        enviarDatos(formValues);
    }
}
function enviarDatos(datos) {
    var formData = new FormData();
    formData.append('nombre', datos.nombre);
    formData.append('numero', datos.numero);
    formData.append('direccion', datos.direccion);
    formData.append('descripcion', datos.descripcion);
    formData.append('imagen', datos.imagen);
    formData.append('action', 'add');

    $.ajax({
        type: 'POST',
        url: $('#formAjax').attr('action'),
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            $('.RespuestaAjax').html(response);
        },
        error: function() {
            Swal.fire('Ocurrió un error inesperado', 'Por favor recargue la página', 'error');
        }
    });
}
$('.formAjax').submit(function(e) {
    e.preventDefault();
});
//////////////
