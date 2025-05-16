<?php
require_once '../../Config/config.php';

$nombre   = 'Usuario';
$apellido = 'Normal';
$correo   = 'usuario@tusitio.com';
$usuario  = 'usuario1';
$password = 'usuario123';

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$insert_url = SUPABASE_URL . "usuario";

$payload = json_encode([
    'nombre'      => $nombre,
    'apellido'    => $apellido,
    'correo'      => $correo,
    'nom_usuario' => $usuario,
    'password'    => $password_hash,
    'rol'         => 'usuario'
]);

$ch = curl_init($insert_url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge(getHeaders(), ['Prefer: return=representation']));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_POST, true);

$result = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code >= 200 && $http_code < 300) {
    echo "✅ Usuario creado correctamente.";
} else {
    echo "❌ Error al crear usuario. Respuesta: " . $result;
}
