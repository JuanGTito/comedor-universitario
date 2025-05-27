<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
        }
        html, body {
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
        }
        body {
            min-height: 100vh;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #052795;
            color: white;
            flex-shrink: 0;
        }
        header .logo {
            font-size: 24px;
            font-weight: bold;
            cursor: default;
        }
        header button {
            background-color: #007BFF;
            border: none;
            padding: 10px 20px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        header button:hover {
            background-color: #0056b3;
        }
        .logo img {
            height: 40px;
        }
        main {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }
        .login-form {
            background: white;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-form h2 {
            margin-bottom: 20px;
            color: #052795;
            text-align: center;
        }
        .login-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .login-form input[type="text"]:focus,
        .login-form input[type="password"]:focus {
            border-color: #007BFF;
            outline: none;
        }
        .login-form button {
            width: 100%;
            padding: 12px;
            background-color: #052795;
            color: white;
            font-weight: bold;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-form button:hover {
            background-color:rgb(77, 110, 218);
        }
        footer {
            background-color: #052795;
            color: #ccc;
            text-align: center;
            padding: 15px 10px;
            font-size: 14px;
            flex-shrink: 0;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="../../images/logo.jpg" alt="Logo UNAJ" />
    </div>
    <button onclick="location.href='../../index.php'">Inicio</button>
</header>

<main>
    <form class="login-form" method="POST" action="../../Models/authlogin/procesarLogin.php">
        <h2>Iniciar Sesión</h2>
        <label for="usuario">Usuario</label>
        <input type="text" id="usuario" name="usuario" required autocomplete="username" />
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required autocomplete="current-password" />
        <button type="submit">Entrar</button>
    </form>
</main>

<footer>
    &copy; <?= date('Y') ?> Mi Empresa. Todos los derechos reservados.
</footer>

</body>
</html>
