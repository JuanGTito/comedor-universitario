<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../Config/supabase.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../Views/Login/login.php?error=Método no permitido');
    exit();
}

$usuario = trim($_POST['usuario'] ?? '');
$password = $_POST['password'] ?? '';

if ($usuario === '' || $password === '') {
    header('Location: ../../Views/Login/login.php?error=Debe ingresar usuario y contraseña');
    exit();
}

$user = supabase_get_user($usuario);

if (!$user) {
    header('Location: ../../Views/Login/login.php?error=Usuario no encontrado');
    exit();
}

if (!password_verify($password, $user['password'])) {
    header('Location: ../../Views/Login/login.php?error=Contraseña incorrecta');
    exit();
}

// Guardar datos en sesión
$_SESSION['usuario'] = $user;
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['nombre'];
$_SESSION['user_rol'] = $user['rol'] ?? 'usuario';

header('Location: ../../Views/dashboard.php');
exit();
