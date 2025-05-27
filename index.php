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
            overflow: hidden;
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
            padding: 10px 20px;
            background-color: #052795;
            color: white;
            z-index: 10;
            flex-shrink: 0;
        }
        .logo img {
            height: 40px;
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
            flex-grow: 1;
            overflow: hidden;
            position: relative;
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
            max-width: 80%;
            max-height: 80%;
            border-radius: 2%;
            transform: translate(-50%, -50%);
            object-fit: contain;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            z-index: 1;
        }
        .slider img.active {
            opacity: 1;
        }
        .arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 50px;
            color: rgba(255, 255, 255, 0.6);
            background-color: rgba(0, 0, 0, 0.2);
            padding: 10px;
            cursor: pointer;
            user-select: none;
            border-radius: 15%;
            z-index: 2;
        }
        .arrow:hover {
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .arrow.left {
            left: 25%;
        }
        .arrow.right {
            right: 25%;
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
        <img src="images/logo.jpg" alt="Logo UNAJ" />
    </div>
    <button onclick="location.href='Views/Login/login.php'">Login</button>
</header>

<main>
    <div class="slider">
        <span class="arrow left" onclick="prevSlide()">&#10094;</span>
        <span class="arrow right" onclick="nextSlide()">&#10095;</span>

        <img src="images/slide1.jpg" alt="Imagen 1" class="active" />
        <img src="images/slide2.jpg" alt="Imagen 2" />
        <img src="images/slide3.jpg" alt="Imagen 3" />
    </div>
</main>

<footer>
    &copy; <?= date('Y') ?> Bienestar Universitario - UNAJ. Todos los derechos reservados.
</footer>

<script>
    const slides = document.querySelectorAll('.slider img');
    let currentIndex = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % slides.length;
        showSlide(currentIndex);
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length;
        showSlide(currentIndex);
    }

    setInterval(nextSlide, 10000); // Cambio automático cada 10 segundos
</script>

</body>
</html>
