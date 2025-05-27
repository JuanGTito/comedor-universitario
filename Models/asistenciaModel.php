<?php
// Models/asistenciaModel.php
require_once __DIR__ . '/../Services/SupabaseService.php';

class AsistenciaModel {
    public function obtenerTurnoActual(): ?string {
        date_default_timezone_set('America/Lima');
        $horaActual = date('H:i:s');
        
        // Traemos todos los horarios desde la tabla 'horario'
        $horarios = SupabaseService::select("horario?select=*");
        
        $turnoEncontrado = null;
        $minDiferencia = null;
        
        $tsHoraActual = strtotime($horaActual);
        
        foreach ($horarios as $h) {
            $tsInicio = strtotime($h['h_inicio']);
            $tsFinal = strtotime($h['h_final']);
            $tsFinalLibre = strtotime('+1 hour', $tsFinal);
        
            // Turno activo
            if ($tsHoraActual >= $tsInicio && $tsHoraActual <= $tsFinal) {
                return $h['turno'];
            }
        
            // Periodo libre 1 hora después del turno
            if ($tsHoraActual > $tsFinal && $tsHoraActual <= $tsFinalLibre) {
                return $h['turno'] . ' (libre)';
            }
        
            // Turno próximo (aún no iniciado)
            if ($tsHoraActual < $tsInicio) {
                $diferencia = $tsInicio - $tsHoraActual;
                if ($minDiferencia === null || $diferencia < $minDiferencia) {
                    $minDiferencia = $diferencia;
                    $turnoEncontrado = 'Próximo turno: ' . $h['turno'] . ' desde ' . $h['h_inicio'];
                }
            }
        }
    
        // Si no hay turno actual ni próximo, retorno null
        return $turnoEncontrado ?? null;
    }
    // Llama a la función RPC con la fecha pasada en formato 'YYYY-MM-DD'
    public static function obtenerReporteBecarios($fecha) {
        // En Supabase RPC el nombre del parámetro debe coincidir exactamente con el de la función
        $resultado = SupabaseService::rpc('reporte_asistencia_becarios', ['fecha_param' => $fecha]);
        
        if (!$resultado) {
            return null;
        }
    
        return $resultado; // array con los registros
    }
}

