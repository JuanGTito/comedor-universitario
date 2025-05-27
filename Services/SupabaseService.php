<?php
// Services/SupabaseService.php
require_once __DIR__ . '/../Config/config.php';

class SupabaseService {
    public static function select($endpoint) {
        $url = SUPABASE_URL . $endpoint;
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => getHeaders(), // llamada a la función global
            CURLOPT_TIMEOUT => 10,
        ]);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpcode >= 400 || !$response) {
            error_log("Error HTTP $httpcode en '$endpoint': $response");
            return [];
        }

        return json_decode($response, true);
    }

    public static function insert($endpoint, $data) {
        $url = SUPABASE_URL . $endpoint;
        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array_merge(getHeaders(), ["Prefer: return=minimal"]),
            CURLOPT_TIMEOUT => 10,
        ]);

        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!in_array($httpcode, [200, 201, 204])) {
            error_log("Error al insertar en '$endpoint': HTTP $httpcode - $response");
            return false;
        }

        return true;
    }

    public static function rpc(string $functionName, array $params = []) {
        $url = SUPABASE_URL . 'rpc/' . $functionName;
        $ch = curl_init($url);
        
        // Filtrar headers duplicados
        $headers = array_filter(getHeaders(), function ($h) {
            return stripos($h, 'Content-Type:') === false && stripos($h, 'Accept:') === false;
        });
    
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept: application/json';
        $headers[] = 'Prefer: return=representation';
    
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 10,
        ]);
    
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        if ($httpcode >= 400) {
            error_log("Error en RPC '$functionName': HTTP $httpcode - $response");
            return false;
        }
    
        return json_decode($response, true);
    }


}
