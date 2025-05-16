<?php
// config.php

define('SUPABASE_URL', 'https://xrkeheyvtsakkzwbyrel.supabase.co/rest/v1/');
define('SUPABASE_API_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inhya2VoZXl2dHNha2t6d2J5cmVsIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDY3NDA1NzcsImV4cCI6MjA2MjMxNjU3N30.2tSdiCbpIaUEOOMkPPuTsEk-tn80XnAZR_A_dIfp5qY');

// Encabezados para las peticiones
function getHeaders() {
    return [
        'Content-Type: application/json',
        'apikey: ' . SUPABASE_API_KEY,
        'Authorization: Bearer ' . SUPABASE_API_KEY
    ];
}
