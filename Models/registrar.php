<?php
require_once __DIR__ . '/config/supabase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id_estudiante'];
    $data = [
        'fecha' => date('Y-m-d'),
        'hora' => date('H:i:s'),
        'horario_id' => 1, // Asume turno
        'estado_id' => 1, // Asume presente
        'estudiante_id' => $id
    ];

    $res = supabaseRequest('asistencia', 'POST', $data);
    header('Location: views/dashboard.php');
    exit();
}
?>
