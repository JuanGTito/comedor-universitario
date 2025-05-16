<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Página Principal</title>
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
        }
        html, body {
            height: 100%;
            font-family: Arial, sans-serif;
            overflow: hidden; /* Evitar scroll */
        }
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
            background-color: #004080;
            color: white;
            z-index: 10;
            flex-shrink: 0;
        }
        header .logo {
            font-size: 24px;
            font-weight: bold;
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
        main {
            position: relative;
            flex-grow: 1;
            overflow: hidden;
        }
        .slider {
            width: 100%;
            height: 100%;
            position: relative;
        }
        .slider img {
            position: absolute;
            top: 50%;
            left: 50%;
            max-width: 100%;
            max-height: 100%;
            transform: translate(-50%, -50%);
            object-fit: contain;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            width: auto;
            height: auto;
        }
        .slider img.active {
            opacity: 1;
            z-index: 1;
        }
        footer {
            background-color: #222;
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
    <div class="logo">UNAJ</div>
    <button onclick="location.href='Views/Login/login.php'">Login</button>
</header>

<main>
    <div class="slider">
        <img src="images/slide1.jpg" alt="Imagen 1" class="active" />
        <img src="images/slide2.jpg" alt="Imagen 2" />
        <img src="images/slide3.jpg" alt="Imagen 3" />
    </div>
</main>

<footer>
    &copy; <?= date('Y') ?> Universidad Nacional De Juliaca. Todos los derechos reservados.
</footer>

<script>
    const slides = document.querySelectorAll('.slider img');
    let currentIndex = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
    }

    setInterval(() => {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    }, 10000); // 10 segundos
</script>

</body>
</html>
