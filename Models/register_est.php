<?php
// Models/register_est.php
require_once __DIR__ . '/../Config/config.php';
require_once __DIR__ . '/../Services/SupabaseService.php';

date_default_timezone_set('America/Lima');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id_estudiante'])) {
    $identificador = trim($_POST['id_estudiante']);
    $fecha_actual = date('Y-m-d');
    $hora_actual = date('H:i:s');

    $params = [
        'p_identificador' => $identificador,
        'p_fecha'         => $fecha_actual,
        'p_hora'          => $hora_actual,
    ];

    $resultado = SupabaseService::rpc('registrar_asistencia', $params);

    $mensaje = null;

    if (is_array($resultado)) {
        // Forma común: array con clave 'registrar_asistencia'
        if (isset($resultado[0]['registrar_asistencia'])) {
            $mensaje = $resultado[0]['registrar_asistencia'];
        } 
        // Alternativa: puede venir sólo un string en la posición 0
        elseif (isset($resultado[0]) && is_string($resultado[0])) {
            $mensaje = $resultado[0];
        }
    } elseif (is_string($resultado)) {
        // Por si viene directamente un string
        $mensaje = $resultado;
    }

    if ($mensaje !== null) {
        $mensaje_limpio = addslashes($mensaje);
        echo "<script>alert('$mensaje_limpio'); window.history.back();</script>";
        exit;
    }

    // Si no hubo mensaje válido
    error_log('⚠️ Error en registrar_asistencia RPC. Resultado inesperado: ' . var_export($resultado, true));
    echo "<script>alert('Error al registrar asistencia. Revise logs.'); window.history.back();</script>";

} else {
    echo "<script>alert('Solicitud no válida.'); window.history.back();</script>";
}
