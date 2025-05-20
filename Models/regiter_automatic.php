<?php
require_once __DIR__ . '/../Config/config.php';

date_default_timezone_set('America/Lima'); // Zona horaria

function supabaseSelect($endpoint) {
    // (igual que tu función)
}

function supabaseInsert($endpoint, $data) {
    // (igual que tu función)
}

function obtenerEstadoId($nombre) {
    $nombreEncoded = rawurlencode($nombre);
    $estados = supabaseSelect("estado?est_asistencia=eq.$nombreEncoded");
    if (!isset($estados[0]['id'])) {
        die("Estado no encontrado para '$nombre'.");
    }
    return $estados[0]['id'];
}

function obtenerTodosEstudiantes() {
    return supabaseSelect("estudiante"); // Ajusta según tu endpoint
}

function obtenerHorarios() {
    return supabaseSelect("horario?order=h_inicio.asc");
}

function obtenerFechaActual() {
    return date('Y-m-d');
}

function obtenerHoraActual() {
    return date('H:i:s');
}

// *** PROCESO PRINCIPAL ***

$fecha = obtenerFechaActual();
$hora_actual = obtenerHoraActual();
$horarios = obtenerHorarios();

if (!$horarios) {
    die("No se encontraron horarios.");
}

// Encontrar el turno actual y el turno anterior
$turno_actual = null;
$turno_anterior = null;
for ($i = 0; $i < count($horarios); $i++) {
    $h_inicio = $horarios[$i]['h_inicio'];
    $h_final = $horarios[$i]['h_final'];
    if ($hora_actual >= $h_inicio && $hora_actual <= $h_final) {
        $turno_actual = $horarios[$i];
        if ($i > 0) {
            $turno_anterior = $horarios[$i - 1];
        }
        break;
    }
}

// Si no estamos en ningún turno actual (ej: fuera de horarios), tomar el último turno que terminó antes
if (!$turno_actual) {
    for ($i = count($horarios) - 1; $i >= 0; $i--) {
        if ($hora_actual > $horarios[$i]['h_final']) {
            $turno_anterior = $horarios[$i];
            break;
        }
    }
}

// Si no hay turno anterior, no hay nada que hacer
if (!$turno_anterior) {
    die("No hay turno anterior para procesar.");
}

$estudiantes = obtenerTodosEstudiantes();
$estado_no_asistio = obtenerEstadoId('no asistio');

foreach ($estudiantes as $estudiante) {
    $estudiante_id = $estudiante['id'];

    // Revisar si ya tiene registro en asistencia para ese turno y fecha
    $filtro = "estudiante_id=eq.$estudiante_id&fecha=eq.$fecha&horario_id=eq." . $turno_anterior['id'];
    $asistencia = supabaseSelect("asistencia?$filtro");

    if (empty($asistencia)) {
        // No tiene registro, entonces insertamos "no asistio"
        $registro = [
            "fecha" => $fecha,
            "hora" => $turno_anterior['h_final'], // se puede poner la hora final del turno
            "horario_id" => $turno_anterior['id'],
            "estado_id" => $estado_no_asistio,
            "estudiante_id" => $estudiante_id
        ];
        supabaseInsert("asistencia", $registro);
    }
}

echo "Proceso completado: registros 'no asistio' agregados para estudiantes sin asistencia en turno anterior.\n";
