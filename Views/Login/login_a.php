<?php
// login.php - Página de inicio de sesión para el Comedor Universitario UNAJ
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Comedor Universitario UNAJ</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background-color: #cfe1f0;
      height: 100vh;
    }

    header {
      background-color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 40px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .logo {
      height: 50px;
    }

    .nav {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .nav span {
      color: #333;
      font-weight: 500;
    }

    .back-button {
      background-color: #4169e1;
      color: white;
      border: none;
      padding: 8px 15px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 4px;
      transition: background-color 0.3s;
    }

    .back-button:hover {
      background-color: #3a5fcd;
    }

    main {
      display: flex;
      justify-content: center;
      align-items: center;
      height: calc(100vh - 80px);
      padding: 20px;
    }

    .login-box {
      background-color: white;
      padding: 40px;
      border-radius: 8px;
      text-align: center;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .login-box h2 {
      margin-bottom: 30px;
      font-size: 22px;
      color: #111;
      font-weight: 600;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 25px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      text-align: left;
      gap: 8px;
    }

    label {
      font-size: 14px;
      color: #555;
      font-weight: 500;
    }

    input[type="text"],
    input[type="password"] {
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 16px;
      transition: border-color 0.3s;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: #4169e1;
      outline: none;
    }

    button[type="submit"] {
      padding: 12px;
      background-color: #0086ff;
      color: white;
      font-size: 16px;
      font-weight: 600;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button[type="submit"]:hover {
      background-color: #0070dd;
    }

    .forgot-password {
      margin-top: 15px;
      font-size: 14px;
    }

    .forgot-password a {
      color: #4169e1;
      text-decoration: none;
    }

    .forgot-password a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <header>
    <img src="UNAJ.png" alt="Logo UNAJ" class="logo" />
    <div class="nav">
      <span>Inicio</span>
      <button class="back-button">← Volver</button>
    </div>
  </header>

  <main>
    <div class="login-box">
      <h2>Bienvenido al Comedor Universitario de la UNAJ</h2>
      <form action="autenticar.php" method="POST">
        <div class="form-group">
          <label for="usuario">Usuario</label>
          <input type="text" id="usuario" name="usuario" required placeholder="Ingrese su usuario" />
        </div>

        <div class="form-group">
          <label for="contrasena">Contraseña</label>
          <input type="password" id="contrasena" name="contrasena" required placeholder="Ingrese su contraseña" />
        </div>

        <button type="submit">Iniciar Sesión</button>
        
        <div class="forgot-password">
          <a href="recuperar-contrasena.php">¿Olvidaste tu contraseña?</a>
        </div>
      </form>
    </div>
  </main>
</body>
</html>