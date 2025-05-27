//Assets/Admin/estudiantes.js
$(document).ready(function () {
    // Inicialización DataTable
    $('#usersTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        language: {
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando _START_ a _END_ de _TOTAL_",
            paginate: {
                next: "Siguiente",
                previous: "Anterior"
            }
        }
    });

    // Evento click en botones de info
    $('#usersTable').on('click', '.btn-info-est', function () {
        let idEstudiante = $(this).data('id');
        if (!idEstudiante) return;

        // Mostrar modal
        $('#modalCarnet').fadeIn();

        // Cargar contenido por AJAX
        $('#contenidoCarnet').html('<p>Cargando...</p>');

        $.post('../../Views/Modals/info-est.php', { id: idEstudiante })
            .done(function (data) {
                $('#contenidoCarnet').html(data);
            })
            .fail(function () {
                $('#contenidoCarnet').html('<p style="color:red;">Error cargando información.</p>');
            });
    });

    // Cerrar modal
    $('#closeModal').click(function () {
        $('#modalCarnet').fadeOut();
    });

    // Cerrar modal si clic afuera del contenido
    $('#modalCarnet').click(function (e) {
        if (e.target === this) {
            $(this).fadeOut();
        }
    });
});
