<!-- perfil.php -->
<div id="modalPerfil" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal('modalPerfil')">&times;</span>
        <h2>Perfil de Usuario</h2>
        <p>Este es el contenido del perfil del usuario.</p>
    </div>
</div>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50%;
        max-width: 600px;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .close {
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 24px;
        cursor: pointer;
    }
</style>
