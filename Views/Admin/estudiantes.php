<link rel="stylesheet" href="/comedor-universitario/Assets/css/admin/estudiante.css">
<div class="content">
    <div class="options">
        <button class="btn-importar">Importar</button>
        <button class="btn-exportar">Exportar</button>
        <button class="btn-agregar">Agregar Estudiante</button>
    </div>
    <br>
    <table class="student-table display">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombres</th>
                <th>Carrera</th>
                <th>Condicion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td>12345678</td>
                <td>Juan Pérez</td>
                <td>
                    <button class="btn-info">
                        <i class="fa fa-plus"></i> 
                    </button>
                </td>
            </tr>
            <tr>
                <td>87654321</td>
                <td>Maria García</td>
                <td>
                    <button class="btn-info">
                        <i class="fa fa-plus"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>11223344</td>
                <td>Carlos Sánchez</td>
                <td>
                    <button class="btn-info">
                        <i class="fa fa-plus"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>22334455</td>
                <td>Ana López</td>
                <td>
                    <button class="btn-info">
                        <i class="fa fa-plus"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>33445566</td>
                <td>Pedro Martínez</td>
                <td>
                    <button class="btn-info">
                        <i class="fa fa-plus"></i>
                    </button>
                </td>
            </tr>
            <tr>
                <td>44556677</td>
                <td>Lucía Fernández</td>
                <td>
                    <button class="btn-info">
                        <i class="fa fa-plus"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('.student-table').DataTable({
            "paging": true,           
            "searching": true,        
            "ordering": true,         
            "info": true,             
            "language": {
                "search": "Buscar: ",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });
</script>
