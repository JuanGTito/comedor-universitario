<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Gestión de Usuarios</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Estilos CSS -->
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2ecc71;
            --dark-color: #34495e;
            --light-color: #ecf0f1;
            --danger-color: #e74c3c;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        
        /* Estilos para el contenido principal */
        .main-content {
            flex: 1;
            padding: 20px;
        }
        
        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .modal-title {
            font-size: 20px;
            color: var(--dark-color);
        }
        
        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #777;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">    
        <!-- Contenido principal -->
        <div class="main-content">
            <!-- Sección de gestión de usuarios -->
            <div id="usuarios" class="dashboard-content active">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-users"></i> Gestión de Usuarios
                    </h2>
                    <div class="action-buttons">
                        <button class="btn btn-primary" id="openModalBtn">
                            <i class="fas fa-user-plus"></i> Agregar Usuario
                        </button>
                        <button class="btn btn-secondary">
                            <i class="fas fa-file-import"></i> Importar Listado
                        </button>
                    </div>
                </div>
                
                <!-- Tabla de usuarios -->
                <div class="table-responsive">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Juan Pérez</td>
                                <td>juan@example.com</td>
                                <td>Administrador</td>
                                <td><span class="badge active">Activo</span></td>
                                <td class="user-actions">
                                    <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>María García</td>
                                <td>maria@example.com</td>
                                <td>Editor</td>
                                <td><span class="badge active">Activo</span></td>
                                <td class="user-actions">
                                    <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Carlos López</td>
                                <td>carlos@example.com</td>
                                <td>Usuario</td>
                                <td><span class="badge inactive">Inactivo</span></td>
                                <td class="user-actions">
                                    <button class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal para agregar/editar usuario -->
    <div class="modal" id="userModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Agregar Nuevo Usuario</h3>
                <button class="close-modal">&times;</button>
            </div>
            <form id="userForm">
                <div class="form-group">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select id="rol" class="form-control" required>
                        <option value="">Seleccionar rol</option>
                        <option value="admin">Administrador</option>
                        <option value="editor">Editor</option>
                        <option value="user">Usuario</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirmar contraseña</label>
                    <input type="password" id="confirmPassword" class="form-control" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" id="cancelBtn">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Scripts JavaScript -->
    <script>
        // Funcionalidad para abrir/cerrar el modal
        document.getElementById('openModalBtn').addEventListener('click', function() {
            document.getElementById('userModal').style.display = 'flex';
        });
        
        document.querySelector('.close-modal').addEventListener('click', function() {
            document.getElementById('userModal').style.display = 'none';
        });
        
        document.getElementById('cancelBtn').addEventListener('click', function() {
            document.getElementById('userModal').style.display = 'none';
        });
        
        // Cerrar modal al hacer clic fuera del contenido
        window.addEventListener('click', function(event) {
            if (event.target === document.getElementById('userModal')) {
                document.getElementById('userModal').style.display = 'none';
            }
        });
        
        // Manejar el envío del formulario
        document.getElementById('userForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Aquí iría la lógica para guardar el usuario
            alert('Usuario guardado correctamente');
            document.getElementById('userModal').style.display = 'none';
            // Limpiar el formulario
            this.reset();
        });
    </script>
</body>
</html>