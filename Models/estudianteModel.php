<?php
// Models/EstudianteModel.php

require_once __DIR__ . '/../Config/config.php';
require_once __DIR__ . '/../Config/client.php';

class EstudianteModel {
    private $apiUrl;
    private $headers;

    public function __construct() {
        // Endpoint con relaciones embebidas
        $this->apiUrl = SUPABASE_URL . 'estudiante?select=id,dni,nombre,apellido,escuela_profesional(carrera),condicion_asignacion(estado)';
        $this->headers = getHeaders();
    }

    public function obtenerEstudiantes() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            return [];
        }

        return json_decode($response, true);
    }

    public function buscarPorDniOCodigo($busqueda) {
        $filtro = "?or=(dni.eq.$busqueda,id.eq.$busqueda)&select=*,escuela_profesional(*),condicion_asignacion(*)";
        return supabaseRequest("estudiante$filtro");
    }
}
