<?php
// Models/EstudianteModel.php
require_once __DIR__ . '/../Config/config.php';
require_once __DIR__ . '/../Services/SupabaseService.php';

class EstudianteModel {
    private string $tablaVista;

    public function __construct() {
        $this->tablaVista = 'vista_estudiantes';
    }

    /**
     * Obtiene todos los estudiantes desde la vista con sus datos completos y clases visuales por número de faltas.
     * @return array
     */
    public function obtenerEstudiantes(): array {
        $estudiantes = SupabaseService::select("{$this->tablaVista}?select=*");

        foreach ($estudiantes as &$est) {
            $faltas = $est['total_faltas'] ?? 0;

            $est['btnClass'] = match (true) {
                $faltas >= 5 => 'btn-danger',
                $faltas >= 2 => 'btn-warning',
                default      => 'btn-success',
            };
        }

        return $estudiantes;
    }

    /**
 * Busca estudiante por DNI o código.
 * @param string $busqueda
 * @return array
 */
public function buscarPorDniOCodigo(string $busqueda): array {
    $busqueda = urlencode($busqueda);
    $filtro = "?or=(dni.eq.$busqueda,id.eq.$busqueda)&select=*";
    return SupabaseService::select("vista_estudiantes$filtro");
}
}
