const form = document.getElementById('formBusquedaCarnet');
const btnBuscar = document.getElementById('btnBuscar');
const contenidoCarnet = document.getElementById('contenidoCarnet');
const modalCarnet = document.getElementById('modalCarnet');

form.addEventListener('submit', function(e) {
    e.preventDefault();

    const busqueda = document.getElementById('busquedaCarnet').value.trim();
    if (!busqueda) {
        alert('Ingrese DNI o Código');
        return;
    }

    btnBuscar.disabled = true;
    contenidoCarnet.innerHTML = "<p>Cargando...</p>";
    modalCarnet.style.display = 'block';

    fetch('../Modals/carnet_estudiante.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'busqueda=' + encodeURIComponent(busqueda)
    })
    .then(res => res.text())
    .then(data => {
        contenidoCarnet.innerHTML = data;
    })
    .catch(err => {
        contenidoCarnet.innerHTML = "<p style='color:red;'>Error al buscar estudiante. Intente de nuevo.</p>";
        console.error(err);
    })
    .finally(() => {
        btnBuscar.disabled = false;
    });
});

function cerrarModalCarnet() {
    modalCarnet.style.display = 'none';
    contenidoCarnet.innerHTML = '';
}

window.addEventListener('click', function(event) {
    if (event.target === modalCarnet) {
        cerrarModalCarnet();
    }
});