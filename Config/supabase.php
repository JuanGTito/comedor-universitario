<?php
require_once __DIR__ . '/config.php';

// Función para obtener usuario (por correo o usuario)
function supabase_get_user($usuario) {
    // Construir la URL con filtro OR para buscar por correo o nombre de usuario
    $url = SUPABASE_URL . "usuario?or=(correo.eq." . urlencode($usuario) . ",nom_usuario.eq." . urlencode($usuario) . ")";
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, getHeaders());
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    
    if(curl_errno($ch)){
        // En caso de error en curl, devuelve null
        curl_close($ch);
        return null;
    }

    curl_close($ch);

    $data = json_decode($result, true);
    
    if (is_array($data) && count($data) > 0) {
        return $data[0];  // Devuelve el primer usuario encontrado
    }
    
    return null;
}
