<?php
// Models/estadisticaModel.php

require_once __DIR__ . '/../Services/SupabaseService.php';

class EstadisticaModel {

    public static function resumenHoy() {
        $data = SupabaseService::select("resumen_panel_estadistico");
        return $data[0] ?? null;
    }

    public static function puntualidadGeneral() {
        $resumen = self::resumenHoy();
        if (!$resumen || $resumen['total_registros'] == 0) return 0;
        return round(($resumen['total_asistencias'] / $resumen['total_registros']) * 100, 2);
    }

    public static function asistenciaPorTurno() {
        $data = SupabaseService::select("asistencia_por_turno_vista");
        $result = ['labels' => [], 'datos' => []];

        foreach ($data as $row) {
            $result['labels'][] = $row['turno'] ?? 'Sin Turno';
            $result['datos'][] = (int) ($row['cantidad'] ?? 0);
        }

        return $result;
    }

    public static function asistenciaPorCarrera() {
        $data = SupabaseService::select("asistencia_por_carrera_vista");
        $result = ['labels' => [], 'datos' => []];

        foreach ($data as $row) {
            $result['labels'][] = $row['carrera'] ?? 'Sin Carrera';
            $result['datos'][] = (int) ($row['cantidad'] ?? 0);
        }

        return $result;
    }
}
