<?php
require_once __DIR__ . '/../Config/config.php';

date_default_timezone_set('America/Lima'); // Hora local Perú

function supabaseSelect($endpoint) {
    $url = SUPABASE_URL . $endpoint;
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => getHeaders(),
    ]);

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode != 200) {
        die("Error HTTP $httpcode al obtener datos: $response");
    }

    return json_decode($response, true);
}

function supabaseInsert($endpoint, $data) {
    $url = SUPABASE_URL . $endpoint;
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array_merge(getHeaders(), ["Prefer: return=minimal"]),
    ]);

    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if (!in_array($httpcode, [200, 201, 204])) {
        die("Error HTTP $httpcode al insertar datos: $response");
    }

    return true;
}

function obtenerEstadoId($nombre) {
    $nombreEncoded = rawurlencode($nombre); // sin comillas simples
    $estados = supabaseSelect("estado?est_asistencia=eq.$nombreEncoded");

    if (!isset($estados[0]['id'])) {
        die("Estado no encontrado para '$nombre'.");
    }

    return $estados[0]['id'];
}

// Función para verificar si ya existe asistencia para fecha, horario y estudiante
function asistenciaRegistrada($fecha, $horario_id, $estudiante_id) {
    $fechaEncoded = rawurlencode($fecha);
    $url = "asistencia?fecha=eq.$fechaEncoded&horario_id=eq.$horario_id&estudiante_id=eq.$estudiante_id";
    $result = supabaseSelect($url);
    return !empty($result);
}

// Función para marcar automáticamente no asistió para horarios pasados sin registro
function marcarNoAsistioTurnosPasados($fecha, $hora_actual, $estudiante_id, $horarios, $estado_no_asistio_id) {
    // Recorremos los horarios
    foreach ($horarios as $horario) {
        // Solo consideramos horarios que ya pasaron (h_final < hora_actual)
        if ($horario['h_final'] < $hora_actual) {
            // Si no hay registro de asistencia para ese horario y estudiante, lo insertamos como no asistió
            if (!asistenciaRegistrada($fecha, $horario['id'], $estudiante_id)) {
                $registro_no_asistio = [
                    "fecha" => $fecha,
                    "hora" => $horario['h_final'], // marca la hora final del turno
                    "horario_id" => $horario['id'],
                    "estado_id" => $estado_no_asistio_id,
                    "estudiante_id" => $estudiante_id
                ];
                supabaseInsert("asistencia", $registro_no_asistio);
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_estudiante'])) {
    $estudiante_id = trim($_POST['id_estudiante']);
    $fecha_actual = date('Y-m-d');
    $hora_actual = date('H:i:s');

    // Traemos todos los horarios ordenados ascendente por hora inicio
    $horarios = supabaseSelect("horario?order=h_inicio.asc");
    if (!$horarios) {
        die("No se encontraron horarios.");
    }

    // Estado IDs para diferentes estados
    $estado_asistio_id = obtenerEstadoId('asistio');
    $estado_tarde_id = obtenerEstadoId('tarde');

    $estado_id = null;
    $horario_id = null;

    // Buscamos horario donde la hora actual esté entre h_inicio y h_final
    foreach ($horarios as $horario) {
        if ($hora_actual >= $horario['h_inicio'] && $hora_actual <= $horario['h_final']) {
            $estado_id = $estado_asistio_id;
            $horario_id = $horario['id'];
            break;
        }
    }

    // Si no está dentro de algún horario, se considera tarde
    if (!$estado_id) {
        $estado_id = $estado_tarde_id;

        // Buscamos el horario más reciente con h_inicio <= hora actual
        $horaEncoded = rawurlencode("'$hora_actual'");
        $horario_busqueda = supabaseSelect("horario?h_inicio=lte.$horaEncoded&order=h_inicio.desc&limit=1");

        if (!$horario_busqueda || !isset($horario_busqueda[0]['id'])) {
            die("No se encontró un horario válido para registrar.");
        }

        $horario_id = $horario_busqueda[0]['id'];
    }

    // Verificamos si ya tiene asistencia registrada para este horario y fecha
    if (asistenciaRegistrada($fecha_actual, $horario_id, $estudiante_id)) {
        die("Ya existe un registro de asistencia para este estudiante en este turno.");
    }

    $nuevoRegistro = [
        "fecha" => $fecha_actual,
        "hora" => $hora_actual,
        "horario_id" => $horario_id,
        "estado_id" => $estado_id,
        "estudiante_id" => $estudiante_id
    ];

    if (supabaseInsert("asistencia", $nuevoRegistro)) {
        echo "<script>alert('Asistencia registrada correctamente'); window.history.back();</script>";
    } else {
        echo "Error al registrar asistencia.";
    }
} else {
    echo "Solicitud no válida.";
}
